<?php namespace App\Models;

use CodeIgniter\Model;

class ForumAttachmentModel extends Model
{
    protected $table = 'forum_attachments';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'post_id', 'file_name', 'file_path',
        'mime_type', 'file_size', 'created_at'
    ];


      public function getThreadAttachments($threadId)
    {
        return $this->db->table('forum_attachments fa')
            ->select('fa.*')
            ->join('forum_posts fp', 'fp.id = fa.post_id')
            ->where('fp.thread_id', $threadId)
            ->get()
            ->getResultArray();
    } 
    public function getPostAttachments($postId)
    {
        return $this->where('post_id', $postId)->get()->getResultArray();
    }
}
