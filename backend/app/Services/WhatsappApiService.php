<?php

namespace App\Services;

use App\Services\RestClient\RestClient;
use App\Services\RestClient\RestClientInterface;

class WhatsappApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new RestClient(config('services.whatsapp_api.base_url'));
    }

    public function ping()
    {
        return $this->client->get('/ping');
    }

    public function startSession($phone)
    {
        return $this->client->get('/session/start/'.$phone);
    }

    public function getQrCode($phone)
    {
        return $this->client->get('/session/qr/'.$phone);
    }

    public function checkSession($phone)
    {
        return $this->client->get('/session/status/'.$phone);
    }
}
