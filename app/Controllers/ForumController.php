<?php namespace App\Controllers;

use App\Models\ForumCategoryModel;
use App\Models\ForumThreadModel;
use App\Models\ForumPostModel;
use App\Models\ForumTagModel;
use App\Models\ForumThreadTagModel;
use App\Models\ForumLikeModel;
use App\Models\ForumReportModel;
use App\Models\ForumAttachmentModel;

class ForumController extends BaseController
{
     public $forumCategoryModel;
    public $threadModel;
    public $postModel;
    public $tagModel;
    public $threadTagModel;
    public $likeModel;
    public $reportModel;
    public $attachmentModel;

    public function __construct()
    {
        $this->forumCategoryModel = new ForumCategoryModel();
        $this->threadModel   = new ForumThreadModel();
        $this->postModel     = new ForumPostModel();
        $this->tagModel      = new ForumTagModel();
        $this->threadTagModel = new ForumThreadTagModel();
        $this->likeModel     = new ForumLikeModel();
        $this->reportModel   = new ForumReportModel();
        $this->attachmentModel = new ForumAttachmentModel();
    }

    public function index()
    {
        $data['title'] = "FORUMS";
        $data['description'] = "FORUMS";
        $data['keywords'] = "FORUMS";
        $data['categories'] = $this->forumCategoryModel->getActiveCategoriesWithThreadCount();
        echo view('partials/_header', $data);
        echo view('forum/index', $data);
        echo view('partials/_footer');
    }

   public function category($slug)
    {
        $category = $this->forumCategoryModel->getCategoryBySlug($slug);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['title'] = "FORUMS | " . $category->name;
        $data['description'] = "Browse threads in " . $category->name;
        $data['keywords'] = "forums," . $category->name;
        $category=(array) $category;
        $data['category'] = $category;
        $data['categories'] = $this->forumCategoryModel->getActiveCategoriesWithThreadCount();
        $userId = authCheck() ? user()->id : 0;
        $data['threads'] = $this->threadModel
                ->select('forum_threads.*, users.username, users.slug as user_slug,
                    (SELECT COUNT(*) FROM forum_posts WHERE thread_id = forum_threads.id) AS replies_count')
                ->join('users', 'users.id = forum_threads.user_id', 'left')
                ->groupStart()
                    ->where('forum_threads.invited_user_ids IS NULL')
                    ->orWhere('forum_threads.invited_user_ids', '')
                    ->orWhere("JSON_CONTAINS(forum_threads.invited_user_ids, '$userId')")
                ->groupEnd()
                ->where('forum_threads.category_id', $category['id'])
                ->where('forum_threads.status', 'approved')
                ->orderBy('is_pinned', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $data['pager'] = $this->threadModel->pager;
        echo view('partials/_header', $data);
        echo view('forum/category', $data);
        echo view('partials/_footer');
    }

     public function thread($slug)
    {
        $thread = $this->threadModel->getThreadDetails($slug);
        $data['title'] = "FORUMS";
        $data['description'] = "FORUMS";
            $data['keywords'] = "FORUMS";
        if (!$thread) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment views
        $this->threadModel->incrementViews($thread->id);

        $data['thread'] = $thread;
        $data['posts'] = $this->postModel->getPostsWithExtras($thread->id, 10);
        $data['tags']  = $this->threadTagModel->getTagsByThread($thread->id);
        $data['pager'] = $this->postModel->pager;
        $data['categories'] = $this->forumCategoryModel->getActiveCategoriesWithThreadCount();

    
        echo view('partials/_header', $data);
        echo view('forum/thread', $data);
        echo view('partials/_footer');
    }

    public function createThread($categorySlug)
    {
        if (!authCheck()) {
            return redirect()->to('/login')->with('error', 'Please login to start a discussion.');
        }

        $category = $this->forumCategoryModel->getCategoryBySlug($categorySlug);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['category'] = $category;
        $data['categories'] = $this->forumCategoryModel->getActiveCategories();
        $data['title'] = "FORUMS";
        $data['description'] = "FORUMS";
        $data['keywords'] = "FORUMS";
        echo view('partials/_header', $data);
        echo view('forum/create_thread', $data);
        echo view('partials/_footer');
    }

    public function submitThread()
    {
        if (!authCheck()) {
            return redirect()->to('/login')->with('error', 'Please login to create a thread.');
        }
        $validation = \Config\Services::validation();
        $rules = [
            'title'       => 'required|min_length[5]',
            'category_id' => 'required|numeric',
            'content'     => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $slug = url_title($this->request->getPost('title'), '-', true);
        $exists = $this->threadModel->where('slug', $slug)->first();
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This title already exists.');
        }
        $this->threadModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'user_id'     => user()->id,
            'title'       => $this->request->getPost('title'),
            'slug'        => $slug,
            'content'     => $this->request->getPost('content'),
            'status'      => 'approved',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $threadId = $this->threadModel->getInsertID();
        $file = $this->request->getFile('thumbnail');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower($file->getExtension());

            if (in_array($ext, $allowed)) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/thread/', $newName);
                $this->threadModel->update($threadId, [
                    'thumbnail' => 'uploads/thread/' . $newName
                ]);
            }
        }
        $tagsInput = $this->request->getPost('tags');

        if (!empty($tagsInput)) {
            $tagsArray = array_filter(array_map('trim', explode(',', $tagsInput)));
            $tagIds = [];

            foreach ($tagsArray as $tagName) {
                $tagSlug = url_title($tagName, '-', true);

                $existingTag = $this->tagModel
                    ->where('slug', $tagSlug)
                    ->first();
                    
                if ($existingTag) {
                    $tagIds[] = $existingTag['id'];
                } else {
                    $this->tagModel->insert([
                        'name' => $tagName,
                        'slug' => $tagSlug
                    ]);
                    $tagIds[] = $this->tagModel->getInsertID();
                }
            }
            $this->threadTagModel->assignTagsToThread($threadId, $tagIds);
        }
        return redirect()->to('/forum/thread/' . $slug)->with('success', 'Thread created successfully!');
    }

    public function reply($threadId)
{
    if (!authCheck()) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Please login first.']);
    }

    $validation = \Config\Services::validation();
    $rules = [
        'content'    => 'required|min_length[1]',
        'parent_id'  => 'permit_empty|numeric'
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => implode(', ', $validation->getErrors())
        ]);
    }

    $data = [
        'thread_id'      => $threadId,
        'user_id'        => user()->id,
        'content'        => $this->request->getPost('content'),
        'parent_post_id' => $this->request->getPost('parent_id') ?: NULL,
        'is_anonymous'   => $this->request->getPost('is_anonymous') ? 1 : 0,
        'created_at'     => date('Y-m-d H:i:s'),
        'status'         => 'visible',
    ];

    $this->postModel->insert($data);
    $insertId = $this->postModel->insertID();

   $file = $this->request->getFile('attachment');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
        if (in_array(strtolower($file->getExtension()), $allowedTypes)) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/forum/', $newName);
            $this->attachmentModel->insert([
                'post_id'    => $insertId,
                'file_name'  => $file->getClientName(),
                'file_path'  => 'uploads/forum/' . $newName,
                'mime_type'  => $file->getClientMimeType(),
                'file_size'  => $file->getSize(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Only Image and PDF files are allowed!'
            ]);
        }
    }

    // Fetch freshly inserted reply with user info
    $reply = $this->postModel->select('forum_posts.*, users.username, users.avatar, users.slug as user_slug')
        ->join('users', 'users.id = forum_posts.user_id')
        ->find($insertId);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Reply posted successfully!',
        'reply' => $reply
    ]);
}


   public function reactPost()
{
    if (!authCheck()) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Login required']);
    }

    $postId = $this->request->getPost('post_id');
    $type   = $this->request->getPost('type');
    $userId = user()->id;

    $db = \Config\Database::connect();
    $reaction = $db->table('forum_likes')
        ->where('post_id', $postId)
        ->where('user_id', $userId)
        ->get()->getRowArray();

    if ($reaction && $reaction['type'] == $type) {
        // Remove reaction
        $db->table('forum_likes')->where('id', $reaction['id'])->delete();
    } else {
        // Remove old and add new reaction
        $db->table('forum_likes')->where('post_id', $postId)->where('user_id', $userId)->delete();
        $db->table('forum_likes')->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'type' => $type,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // Return updated counts
    $counts = $this->postModel->getReactionCounts($postId);

    return $this->response->setJSON([
        'status' => 'success',
        'counts' => $counts,
        'user_reaction' => $reaction && $reaction['type'] == $type ? null : $type
    ]);
}



    public function markSolution($postId)
    {
        if (!authCheck() || !isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $post = $this->postModel->find($postId);
        if ($post) {
            $this->postModel->update($postId, ['is_solution' => 1]);
            $this->threadModel->update($post['thread_id'], ['solved_post_id' => $postId]);
        }

        return redirect()->back()->with('success', 'Marked as Best Answer!');
    }
    
    public function postReactions($postId, $type)
{
    if (!authCheck()) {
        return $this->response->setStatusCode(403)->setJSON([
            'status'  => 'error',
            'message' => 'Unauthorized'
        ]);
    }

    $postId = (int) $postId;
    $post   = $this->postModel->find($postId);

    if (!$post) {
        return $this->response->setStatusCode(404)->setJSON([
            'status'  => 'error',
            'message' => 'Post not found.'
        ]);
    }

    // Only comment owner or admin/mod can see full list
    if ((int)$post['user_id'] !== (int)user()->id && !isAdmin()) {
        return $this->response->setStatusCode(403)->setJSON([
            'status'  => 'error',
            'message' => 'You are not allowed to view this list.'
        ]);
    }

    $allowedTypes = $this->likeModel->getReactionTypes();
    if (!in_array($type, $allowedTypes, true)) {
        return $this->response->setStatusCode(400)->setJSON([
            'status'  => 'error',
            'message' => 'Invalid reaction type.'
        ]);
    }

    $users = $this->likeModel->getUsersByReaction($postId, $type);

    return $this->response->setJSON([
        'status' => 'success',
        'data'   => $users,
    ]);
}

public function showReactions($postId)
{
    $likeModel = new \App\Models\ForumLikeModel();
    $data['reactions'] = $likeModel->getAllReactionsByPost($postId);

    return view('forum/reactions_list', $data); // Load into a modal
}

public function forumSearch()
{
    $q = trim($this->request->getGet('q'));
    $q = ltrim($q, '#'); 

    if ($q === '') {
        return $this->response->setJSON([
            'categories' => [],
            'threads'    => []
        ]);
    }

    $db = \Config\Database::connect();

    $categories = $db->table('forum_categories')
        ->select('id, name, slug, thumbnail')
        ->like('name', $q)
        ->get()
        ->getResultArray();
    $userId = authCheck() ? user()->id : 0;
    $threads = $db->table('forum_threads ft')
        ->select('ft.id, ft.slug, ft.title, u.username, fc.name AS category_name')
        ->join('users u', 'u.id = ft.user_id', 'left')
        ->join('forum_categories fc', 'fc.id = ft.category_id', 'left')
        ->join('forum_thread_tags ftt', 'ftt.thread_id = ft.id', 'left')
        ->join('forum_tags t', 't.id = ftt.tag_id', 'left')
        ->groupStart()
            ->like('ft.title', $q)
            ->orLike('ft.content', $q)
            ->orLike('t.name', $q)
        ->groupEnd()
        ->groupStart()
            ->where('ft.invited_user_ids IS NULL')
            ->orWhere('ft.invited_user_ids', '')
            ->orWhere("JSON_CONTAINS(ft.invited_user_ids, $userId)")
        ->groupEnd()
        ->groupBy('ft.id')
        ->orderBy('ft.created_at', 'DESC')
        ->limit(20)
        ->get()
    ->getResultArray();

    return $this->response->setJSON([
        'categories' => $categories,
        'threads'    => $threads
    ]);
}

public function deletePost()
{
    $id = $this->request->getPost('id');

    $postModel = new ForumPostModel();
    $threadModel = new ForumThreadModel();
    $db = \Config\Database::connect();
    $post = $postModel->find($id);
    if (!$post) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Reply not found.'
        ]);
    }
    $thread = $threadModel->find($post['thread_id']);
    if (!isAdmin() && user()->id != $thread['user_id']) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'You do not have permission to delete this reply.'
        ]);
    }
    $attachments = $db->table('forum_attachments')
        ->where('post_id', $id)
        ->get()
        ->getResultArray();

    foreach ($attachments as $file) {
        $path = FCPATH . $file['file_path'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    $db->table('forum_attachments')->where('post_id', $id)->delete();
    $postModel->where('id', $id)->delete();
    $postModel->where('parent_post_id', $id)->delete();
    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Reply deleted successfully.'
    ]);
}
   
}
