<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalService
{
    protected $client;

    public function __construct()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (env('PAYPAL_MODE') === 'live') {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        } else {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }

        $this->client = new PayPalHttpClient($environment);
    }

    public function client()
    {
        return $this->client;
    }
}