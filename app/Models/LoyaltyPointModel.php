<?php namespace App\Models;

use CodeIgniter\Model;

class LoyaltyPointModel extends Model
{
    protected $table = 'loyalty_point';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'min_amount',
        'max_amount',
        'points',
        'status',
        'created_at'   // ✅ REQUIRED
    ];

    public function getActiveRules()
    {
        return $this->where('status', 1)
                    ->orderBy('min_amount', 'ASC')
                    ->findAll();
    }
}
