<?php

namespace App\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends BaseController
{
    public function index()
    {
        return view('stripe_payment');
    }

    public function checkout()
    {
        $stripe = new \Config\Stripe();

        Stripe::setApiKey($stripe->secretKey);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Test Product',
                    ],
                    'unit_amount' => 50000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => base_url('payment-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => base_url('payment-cancel'),
        ]);

        return $this->response
    ->setStatusCode(303)
    ->setHeader('Location', $session->url);

    }

    public function success()
    {
        echo "Payment Successful";
    }

    public function cancel()
    {
        echo "Payment Cancelled";
    }

    public function bankAccountVerifyForm()
    {
        return view('stripe_bank_verify');
    }

    public function verifyBankAccount()
    {
        $request    = service('request');
        $customerId = trim((string) $request->getPost('customer_id'));
        $bankId     = trim((string) $request->getPost('bank_account_id'));
        $amount1    = (int) $request->getPost('amount_1');
        $amount2    = (int) $request->getPost('amount_2');

        if ($customerId === '' || $bankId === '' || $amount1 <= 0 || $amount2 <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'customer_id, bank_account_id, amount_1 and amount_2 are all required.',
            ]);
        }

        $stripe = new \Config\Stripe();
        $client = new \Stripe\StripeClient($stripe->secretKey);

        try {
            $bankAccount = $client->customers->verifySource(
                $customerId,
                $bankId,
                ['amounts' => [$amount1, $amount2]]
            );

            return $this->response->setJSON([
                'success'      => true,
                'status'       => $bankAccount->status ?? null,
                'bank_account' => $bankAccount->toArray(),
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            log_message('error', 'Stripe bank verify error: ' . $e->getMessage());

            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'error'   => $e->getMessage(),
                'code'    => $e->getStripeCode(),
                'type'    => get_class($e),
            ]);
        }
    }
}
