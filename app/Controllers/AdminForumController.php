<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ForumThreadModel;
use App\Models\ForumPostModel;

class AdminForumController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    private function isAdmin()
    {
        return authCheck() && isset(user()->role_id) && user()->role_id == 1;
    }

    public function adminThreads()
    {
        $db = \Config\Database::connect();

        $search   = trim($this->request->getGet('q'));
        $status   = trim($this->request->getGet('status'));
        $category = trim($this->request->getGet('category'));
        $userId   = trim($this->request->getGet('user_id'));

        $builder = $db->table('forum_threads ft')
            ->select('ft.*, fc.name AS category_name, u.username,
                    (SELECT COUNT(*) FROM forum_posts WHERE thread_id = ft.id) AS replies_count')
            ->join('forum_categories fc', 'fc.id = ft.category_id', 'left')
            ->join('users u', 'u.id = ft.user_id', 'left');

        if ($search !== '') {
            $builder->like('ft.title', $search);
        }
        if ($status !== '') {
            $builder->where('ft.status', $status);
        }
        if ($category !== '') {
            $builder->where('ft.category_id', $category);
        }
        if ($userId !== '') {
            $builder->where('ft.user_id', $userId);
        }
        $data = [
            'title'      => 'Forum Threads (Admin)',
            'threads'    => $builder->orderBy('ft.created_at', 'DESC')->get()->getResultArray(),
            'categories' => $db->table('forum_categories')->get()->getResultArray(),
            'users'      => $db->table('users')->get()->getResultArray()
        ];
        return view('admin/forums/threads_list', $data);
    }

    public function threads()
    {
        $db = \Config\Database::connect();
        $userId = user()->id;
        $search = trim($this->request->getGet('q'));
        $status   = trim($this->request->getGet('status'));
        $category = trim($this->request->getGet('category'));
        
        $builder = $db->table('forum_threads ft')
            ->select('ft.*, fc.name AS category_name, u.username,
                    (SELECT COUNT(*) FROM forum_posts WHERE thread_id = ft.id) AS replies_count')
            ->join('forum_categories fc', 'fc.id = ft.category_id', 'left')
            ->join('users u', 'u.id = ft.user_id', 'left')
            ->where('ft.user_id', $userId);
        if ($search !== '') {
            $builder->like('ft.title', $search);
        }
        if ($status !== '') {
            $builder->where('ft.status', $status);
        }
        if ($category !== '') {
            $builder->where('ft.category_id', $category);
        }
        $data = [
            'title'   => 'Threads',
            'threads' => $builder->orderBy('ft.created_at', 'DESC')->get()->getResultArray(),
            'categories' => $db->table('forum_categories')->get()->getResultArray()
        ];
        $data['data'] = $data;

        return view('dashboard/forums/threads_list', $data);
    }

    public function editThread($id)
    {
        $model = new ForumThreadModel();
        $thread = $model->find($id);

        if (!$thread) {
            return redirect()->back()->with('error', 'Thread not found.');
        }
        if (!$this->isAdmin() && $thread['user_id'] != user()->id) {
            return redirect()->back()->with('error', 'You cannot edit this thread.');
        }
        $data = [
            'title'   => 'Edit Thread',
            'thread'  => $thread,
            'isAdmin' => $this->isAdmin()
        ];
        $isDashboard = strpos(current_url(), '/dashboard/') !== false;
        if ($isDashboard) {
            return view('dashboard/includes/_header', $data)
                . view('forum/edit_thread', $data)
                . view('dashboard/includes/_footer');
        }
        return view('admin/includes/_header', $data)
            . view('forum/edit_thread', $data)
            . view('admin/includes/_footer');
    }


    public function editThreadPost()
    {
        $id = $this->request->getPost('id');
        $model = new ForumThreadModel();

        $thread = $model->find($id);
        if (!$thread) {
            return redirect()->back()->with('error', 'Thread not found.');
        }

        if (!$this->isAdmin() && $thread['user_id'] != user()->id) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $updateData = [
            'title'         => inputPost('title'),
            'content'       => inputPost('content'),
            'is_locked'    => $this->request->getPost('is_locked') ? 1 : 0,
            'hide_replies' => $this->request->getPost('hide_replies') ? 1 : 0,
        ];

        if ($this->isAdmin()) {
            $updateData['status'] = $this->request->getPost('status');
        }

        $model->update($id, $updateData);

        return redirect()->to(
            $this->isAdmin() ? adminUrl('forums-threads') : base_url('dashboard/threads')
        )->with('success', 'Thread updated.');
    }



public function deleteThread($id)
{
    $threadModel = new ForumThreadModel();
    $postModel   = new ForumPostModel();
    $db = \Config\Database::connect();

    $thread = $threadModel->find($id);
    if (!$thread) {
        return redirect()->back()->with('error', 'Thread not found.');
    }

    if (!$this->isAdmin() && $thread['user_id'] != user()->id) {
        return redirect()->back()->with('error', 'You cannot delete this thread.');
    }
    $posts = $postModel->where('thread_id', $id)->findAll();
    foreach ($posts as $post) {
        $files = $db->table('forum_attachments')->where('post_id', $post['id'])->get()->getResultArray();
        
        foreach ($files as $file) {
            $path = FCPATH . $file['file_path'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $db->table('forum_attachments')->where('post_id', $post['id'])->delete();
    }

    $postModel->where('thread_id', $id)->delete();
    $db->table('forum_thread_tags')->where('thread_id', $id)->delete();
    $threadModel->delete($id);
    
    if ($this->isAdmin()) {
        if (strpos(current_url(), '/admin/') !== false) {
            return redirect()->to(adminUrl('forums-threads'))->with('success', 'Thread deleted successfully.');
        } else {
            return redirect()->to(base_url('dashboard/threads'))->with('success', 'Thread deleted successfully.');
        }
    }
}
public function inviteUsers($threadId)
{
    if (!$this->isAdmin()) {
        return redirect()->back()->with('error', 'Unauthorized');
    }

    $db = \Config\Database::connect();

    $thread = $db->table('forum_threads')
        ->where('id', $threadId)
        ->get()
        ->getRowArray();

    if (!$thread) {
        return redirect()->back()->with('error', 'Thread not found');
    }

    $users = $db->table('users')
        ->select('id, username')
        ->orderBy('username', 'ASC')
        ->get()
        ->getResultArray();

    $invitedUsers = json_decode($thread['invited_user_ids'] ?? '[]', true);

    return view('admin/forums/invite_users', [
        'title'        => 'Invite Members',
        'thread'       => $thread,
        'users'        => $users,
        'invitedUsers' => $invitedUsers
    ]);

}

public function inviteUsersPost()
{
    if (!$this->isAdmin()) {
        return redirect()->back()->with('error', 'Unauthorized');
    }

    $threadId = $this->request->getPost('thread_id');
    $users    = (array) $this->request->getPost('users');

    $invitedIds = !empty($users)
        ? json_encode(array_map('intval', $users))
        : null;

    $db = \Config\Database::connect();
    $db->table('forum_threads')
        ->where('id', $threadId)
        ->update([
            'invited_user_ids' => $invitedIds
        ]);

    return redirect()->to(adminUrl('forums-threads'))
        ->with('success', 'Members invited successfully');
}



}
