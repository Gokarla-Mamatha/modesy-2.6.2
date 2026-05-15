<?php namespace App\Models;

use CodeIgniter\Model;

class ForumPostModel extends Model
{
    protected $table = 'forum_posts';
    protected $primaryKey = 'id';

  protected $allowedFields = [
    'thread_id', 'user_id', 'parent_post_id',
    'content', 'likes_count', 'status',
    'is_solution', // 👈 Add this
    'created_at', 'updated_at'
];

    // Get all visible posts for a thread
    public function getVisiblePostsByThread($threadId)
    {
        return $this->where('thread_id', $threadId)
                    ->where('status', 'visible')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    // Add like count
    public function addLike($postId)
    {
        return $this->set('likes_count', 'likes_count + 1', false)
                    ->where('id', $postId)
                    ->update();
    }
public function getPostsWithExtras($threadId)
{
    // 1. Fetch all posts
    $posts = $this->select('forum_posts.*, users.username, users.slug as user_slug, users.avatar')
        ->join('users', 'users.id = forum_posts.user_id', 'left')
        ->where('forum_posts.thread_id', $threadId)
        ->orderBy('forum_posts.created_at', 'DESC')
        ->findAll();

    // 2. Index posts by ID
    $indexed = [];
    foreach ($posts as $post) {
        $post['reactions'] = $this->getReactionCounts($post['id']);
        $post['user_reaction'] = authCheck() ? $this->getUserReaction($post['id'], user()->id) : null;
        $post['replies'] = [];
        $indexed[$post['id']] = $post;
    }

    // 3. Attach replies correctly (recursive tree)
    $tree = [];
    foreach ($indexed as $id => &$post) {
        if (!empty($post['parent_post_id']) && isset($indexed[$post['parent_post_id']])) {
            $indexed[$post['parent_post_id']]['replies'][] = &$post;
        } else {
            $tree[$id] = &$post;  // Root posts
        }
    }

    return $tree;
}
public function getReactionCounts($postId)
{
    $db = \Config\Database::connect();
    $query = $db->query("
        SELECT type, COUNT(*) as total 
        FROM forum_likes 
        WHERE post_id = ?
        GROUP BY type
    ", [$postId]);

    $counts = [
        'like' => 0,
        'love' => 0,
        'laugh' => 0,
        'angry' => 0,
        'sad' => 0,
    ];

    foreach ($query->getResultArray() as $row) {
        $counts[$row['type']] = $row['total'];
    }

    return $counts;
}

public function getUserReaction($postId, $userId)
{
    return $this->db->table('forum_likes')
        ->where('post_id', $postId)
        ->where('user_id', $userId)
        ->get()
        ->getRowArray()['type'] ?? null;
}
}
