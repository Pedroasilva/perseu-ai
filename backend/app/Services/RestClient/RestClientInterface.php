<?php

namespace App\Services\RestClient;

interface RestClientInterface
{
    public function get(string $url, array $queryParams = [], array $headers = []);
    public function post(string $url, array $data = [], array $headers = []);
    public function put(string $url, array $data = [], array $headers = []);
    public function delete(string $url, array $headers = []);
}
