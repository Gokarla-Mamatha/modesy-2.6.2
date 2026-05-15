<?php namespace App\Models;

use CodeIgniter\Model;

class ForumThreadModel extends Model
{
    protected $table = 'forum_threads';
    protected $primaryKey = 'id';

  
protected $allowedFields = [
    'category_id', 'user_id', 'title', 'slug', 'content',
    'is_pinned', 'is_locked', 'solved_post_id',
    'status', 'views_count', 'replies_count','thumbnail','hide_replies','invited_user_ids',
    'created_at', 'updated_at'
];
  

    // Increment view count
    public function incrementViews($threadId)
    {
        $this->set('views_count', 'views_count + 1', false)
            ->where('id', $threadId)
            ->update();
    }
        
    // Get thread by slug
    public function getThreadBySlug($slug)
    {
        return $this->select('forum_threads.*, users.username, users.slug as user_slug, users.avatar')
            ->join('users', 'users.id = forum_threads.user_id')
            ->where('forum_threads.slug', $slug)
            ->first();
    }

    public function getThreadsByCategory($categoryId, $limit = 10, $offset = 0)
    {
        return $this->select('forum_threads.*, users.username, users.slug as user_slug,
                            (SELECT COUNT(*) FROM forum_posts WHERE thread_id = forum_threads.id) AS replies_count')
                    ->join('users', 'users.id = forum_threads.user_id')
                    ->where('category_id', $categoryId)
                    ->where('status', 'approved')
                    ->orderBy('is_pinned', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

public function getThreadDetails($slug)
{
    return $this->asObject()
        ->select('forum_threads.id, forum_threads.*, 
                  forum_categories.name as category_name, 
                  forum_categories.slug as category_slug, 
                  users.username, 
                  users.slug as user_slug')
        ->join('forum_categories', 'forum_categories.id = forum_threads.category_id')
        ->join('users', 'users.id = forum_threads.user_id')
        ->where('forum_threads.slug', $slug)
        ->first();
}
}
