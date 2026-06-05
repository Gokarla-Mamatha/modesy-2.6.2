<?php

namespace App\Controllers;

use App\Libraries\TaxJarService;

class TaxCheckoutController extends BaseController
{

    public function getStateCode($state)
    {

        $db = \Config\Database::connect();
        $stateCode = '';

        $state = $db->table('location_states')
            ->select('state_code')
            ->where('name', $state)
            ->get()
            ->getRow();

        if ($state) {
             return $stateCode = $state->state_code;
        }

        return $stateCode;
    }
    public function tax($cart_items)
{
    $taxJar = new TaxJarService();

    $totalTax = 0;

    foreach ($cart_items as $item) {
        $shippingData = json_decode($item->shipping_data, true);
        $data = [
            'from_country' => 'US',
            'from_zip' => '92093',
            'from_state' => 'CA',
            'from_city' => 'La Jolla',
            'from_street' => '9500 Gilman Drive',

            //'to_country' => $shippingData['sCountry'] ?? '',
            'to_country' => ($shippingData['sCountry'] ?? '') == 'United States'
            ? 'US'
            : ($shippingData['sCountry'] ?? ''),
            'to_zip' => $shippingData['sZipCode'] ?? '',
            //'to_zip' => '90002',
            'to_state' => $this->getStateCode($shippingData['sState'] ?? ''),
            //'to_state' =>  'CA',
            'to_city' => $shippingData['sCity'] ?? '',
            //'to_city' => 'Los Angeles',
            'to_street' => $shippingData['sAddress'] ?? '',

            'amount' => $item->total_price,
            'shipping' => (float)$item->shipping_cost,

            'line_items' => [
                [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'product_tax_code' => '20010',
                    'unit_price' => $item->unit_price,
                    'discount' => 0
                ]
            ]
        ];

        //print_r($data);
        log_message('debug', 'TaxJar Request: ' . json_encode($data));
        $tax = $taxJar->calculateTax($data);
        log_message('debug', 'TaxJar Response: ' . json_encode($tax));
        // echo "<pre>";
        // print_r($tax);
        // exit;
        if ($tax == null) {
            return 0;
        }
        $totalTax += $tax->amount_to_collect ?? 0;
    }

    return $totalTax;
}
}