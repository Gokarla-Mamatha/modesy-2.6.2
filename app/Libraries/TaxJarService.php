<?php

namespace App\Libraries;

use TaxJar\Client;

class TaxJarService
{
    protected $client;

    public function __construct()
    {
        $this->client = Client::withApiKey(env('taxjar.apiKey'));

        // Use only for sandbox testing
        /*
        $this->client->setApiConfig(
            'api_url',
            Client::SANDBOX_API_URL
        );
        */

        // Optional
        $this->client->setApiConfig('timeout', 30);
    }

    public function calculateTax(array $data)
    {
        try {

            return $this->client->taxForOrder($data);

        } catch (\Exception $e) {

            log_message('error', 'TaxJar Error: ' . $e->getMessage());

            session()->setFlashdata(
                'shipping_error',
                 $e->getMessage()
            );

            return null;
        }
    }
}