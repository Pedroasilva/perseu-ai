<?php

namespace App\Services;

use App\Models\Mensagem;
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

    public function startSession($sessionId)
    {
        return $this->client->get('/session/start/'.$sessionId);
    }

    public function getQrCode($sessionId)
    {
        return $this->client->get('/session/qr/'.$sessionId);
    }

    public function checkSession($sessionId)
    {
        return $this->client->get('/session/status/'.$sessionId);
    }

    public function sendMessage($sessionId, $to, $message)
    {
        return $this->client->post('/client/sendMessage/'.$sessionId, [
            'contentType' => 'string',
            'chatId' => $this->formatWhatsappId($to),
            'content' => $message
        ]);
    }

    public function getContactInfo($sessionId, $contactNumber)
    {
        return $this->client->post('/contact/getClassInfo/'.$sessionId, [
            'contactId' => $this->formatWhatsappId($contactNumber)
        ]);
    }

    private function formatWhatsappId(string $number): string
    {
        return "55{$this->formatPhoneNumber($number)}@c.us";
    }

    private function formatPhoneNumber(string $number): string
    {
        return substr_replace($number, '', 2, 1);
    }
}
