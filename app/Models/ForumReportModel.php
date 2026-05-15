<?php namespace App\Models;

use CodeIgniter\Model;

class ForumReportModel extends Model
{
    protected $table = 'forum_reports';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'post_id', 'reported_by', 'reason', 'status',
        'created_at', 'reviewed_by', 'reviewed_at'
    ];
}
