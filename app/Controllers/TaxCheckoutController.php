<?php

namespace App\Controllers;

use App\Libraries\TaxJarService;

class TaxCheckoutController extends BaseController
{
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
            'to_state' => $shippingData['sState'] ?? '',
            //'to_state' =>  'CA',
            ' ' => $shippingData['sCity'] ?? '',
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

        // print_r($data);exit;
        $tax = $taxJar->calculateTax($data);
        // echo "<pre>";
        // print_r($tax);
        // exit;

        $totalTax += $tax->amount_to_collect ?? 0;
    }

    return $totalTax;
}
}