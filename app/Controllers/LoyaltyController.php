<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoyaltyController extends BaseController
{

public function convert()
{
    if (!user()) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Not logged in'
        ]);
    }

    $db     = \Config\Database::connect();
    $userId = (int) user()->id;
    $points = (int) $this->request->getPost('points');

    $settings = $db->table('settings')->where('id', 1)->get()->getRow();
    $minPoints = (int) $settings->loyalty_convert_points;
    $baseAmount = (float) $settings->loyalty_convert_amount;

    if ($points < $minPoints) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => "Minimum {$minPoints} points required"
        ]);
    }

    $totalBalance = (int) $db->table('loyalty_point_transactions')
        ->selectSum('balance')
        ->where('user_id', $userId)
        ->where('type', 'earned')
        ->get()
        ->getRow()
        ->balance;

    if ($points > $totalBalance) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Not enough points'
        ]);
    }

    $amountPerPoint = $baseAmount / $minPoints;
    $walletAmount   = round($points * $amountPerPoint, 2);

    $rows = $db->table('loyalty_point_transactions')
        ->where('user_id', $userId)
        ->where('type', 'earned')
        ->where('balance >', 0)
        ->orderBy('created_at', 'ASC')
        ->get()
        ->getResult();

    $remaining = $points;

    $db->transStart();

    foreach ($rows as $row) {

        if ($remaining <= 0) break;

        if ($row->balance > $remaining) {

            $db->table('loyalty_point_transactions')
                ->where('id', $row->id)
                ->update([
                    'balance' => $row->balance - $remaining,
                    'type'    => 'earned'
                ]);

            $remaining = 0;

        } else {
            $db->table('loyalty_point_transactions')
                ->where('id', $row->id)
                ->update([
                    'balance' => 0,
                    'type'    => 'redeem',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            $remaining -= $row->balance;
        }
    }

    
    // 🔹 Credit wallet
    $db->table('users')
        ->where('id', $userId)
        ->set('balance', 'balance + ' . $walletAmount, false)
        ->update();

    $db->transComplete();

    if (!$db->transStatus()) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Conversion failed'
        ]);
    }

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => "{$points} points converted to ₹{$walletAmount}"
    ]);
}

}
