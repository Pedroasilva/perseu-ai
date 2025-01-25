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

}
