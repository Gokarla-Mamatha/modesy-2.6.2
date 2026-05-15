<?php namespace App\Models;

use CodeIgniter\Model;

class ForumThreadTagModel extends Model
{
    protected $table = 'forum_thread_tags';
    protected $primaryKey = null; // No auto increment key (composite key)
    public $timestamps = false;

    protected $allowedFields = ['thread_id', 'tag_id'];

    /**
     * Get all tags linked to a thread
     */
    public function getTagsByThread($threadId)
    {
        return $this->select('forum_tags.*')
                    ->join('forum_tags', 'forum_tags.id = forum_thread_tags.tag_id')
                    ->where('thread_id', $threadId)
                    ->findAll();
    }

    /**
     * Add tags to a thread
     * @param int $threadId
     * @param array $tagIds
     */
    public function assignTagsToThread($threadId, array $tagIds)
    {
        // Remove existing tags first
        $this->where('thread_id', $threadId)->delete();

        // Assign new tags
        foreach ($tagIds as $tagId) {
            $this->insert([
                'thread_id' => $threadId,
                'tag_id'    => $tagId
            ]);
        }
        return true;
    }

    /**
     * Remove all tags from a thread
     */
    public function removeTagsByThread($threadId)
    {
        return $this->where('thread_id', $threadId)->delete();
    }

    /**
     * Get all threads linked to a specific tag
     */
    public function getThreadsByTag($tagId)
    {
        return $this->select('forum_threads.*')
                    ->join('forum_threads', 'forum_threads.id = forum_thread_tags.thread_id')
                    ->where('tag_id', $tagId)
                    ->where('forum_threads.status', 'approved')
                    ->findAll();
    }
}
