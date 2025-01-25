<?php

namespace App\Services\RestClient;

use Illuminate\Support\Facades\Http;

class RestClient implements RestClientInterface
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get(string $url, array $queryParams = [], array $headers = [])
    {
        return Http::withHeaders($headers)
            ->get($this->fullUrl($url), $queryParams)
            ->json();
    }

    public function post(string $url, array $data = [], array $headers = [])
    {
        return Http::withHeaders($headers)
            ->post($this->fullUrl($url), $data)
            ->json();
    }

    public function put(string $url, array $data = [], array $headers = [])
    {
        return Http::withHeaders($headers)
            ->put($this->fullUrl($url), $data)
            ->json();
    }

    public function delete(string $url, array $headers = [])
    {
        return Http::withHeaders($headers)
            ->delete($this->fullUrl($url))
            ->json();
    }

    private function fullUrl(string $url): string
    {
        return "{$this->baseUrl}/" . ltrim($url, '/');
    }
}
