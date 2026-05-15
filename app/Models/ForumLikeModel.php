<?php namespace App\Models;

use CodeIgniter\Model;

class ForumLikeModel extends Model
{
    protected $table      = 'forum_likes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'post_id', 'user_id', 'type', 'created_at'
    ];

    protected $useTimestamps = false;

    /**
     * Allowed reaction types
     */
    protected $reactionTypes = ['like', 'love', 'laugh', 'angry', 'sad', 'dislike'];

    public function getReactionTypes(): array
    {
        return $this->reactionTypes;
    }

    public function toggleReaction(int $postId, int $userId, string $type)
    {
        if (!in_array($type, $this->reactionTypes, true)) {
            return;
        }

        $existing = $this->where([
            'post_id' => $postId,
            'user_id' => $userId,
        ])->first();

        // If same reaction exists → remove (unreact)
        if ($existing && $existing['type'] === $type) {
            $this->delete($existing['id']);
            return;
        }

        // If exists with different type → update
        if ($existing) {
            $this->update($existing['id'], ['type' => $type]);
        } else {
            $this->insert([
                'post_id'   => $postId,
                'user_id'   => $userId,
                'type'      => $type,
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }
    }

    public function getReactionCounts(int $postId): array
    {
        $rows = $this->select('type, COUNT(*) as total')
            ->where('post_id', $postId)
            ->groupBy('type')
            ->findAll();

        $counts = [];
        foreach ($this->reactionTypes as $type) {
            $counts[$type] = 0;
        }

        foreach ($rows as $row) {
            $counts[$row['type']] = (int)$row['total'];
        }

        return $counts;
    }

    public function getReaction(int $postId, int $userId)
    {
        return $this->where([
            'post_id' => $postId,
            'user_id' => $userId
        ])->first();
    }

    public function getUsersByReaction(int $postId, string $type)
    {
        return $this->select('forum_likes.*, users.username, users.slug as user_slug, users.avatar')
            ->join('users', 'users.id = forum_likes.user_id', 'left')
            ->where('forum_likes.post_id', $postId)
            ->where('forum_likes.type', $type)
            ->orderBy('forum_likes.created_at', 'DESC')
            ->findAll();
    }
}
