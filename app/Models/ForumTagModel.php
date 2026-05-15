<?php namespace App\Models;

use CodeIgniter\Model;
class ForumTagModel extends Model { protected $table='forum_tags'; protected $primaryKey='id'; protected $allowedFields=['name','slug']; }
