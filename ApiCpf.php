<?php

namespace Fernandothedev\BaseBotTelegramPhp\Api;

use Fernandothedev\BaseBotTelegramPhp\Model\Promise;
use GuzzleHttp\Client;

final class ApiCpf
{
    private Client $client;
    private array $headers = [
        'Accept' => '*/*',
        'Accept-Language' => 'pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6,pl;q=0.5,mt;q=0.4',
        'Origin' => 'https://zapay.legitimuz.com',
        'Referer' => 'https://zapay.legitimuz.com/',
        'Sec-Ch-Ua' => '"Not_A Brand";v="8", "Chromium";v="120", "Microsoft Edge";v="120"',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.0.0'
    ];

    public function __construct() {
        $this->client = new Client([
            'base_uri' => 'https://api.legitimuz.com/external/kyc/',
            'verify' => false,
        ]);
    }

    public function getData(int $cpf): Promise
    {
        $promise = new Promise();

        try {
            $url = "https://api.legitimuz.com/external/kyc/cpf-history?cpf={$cpf}&token=176512e3-43e6-479a-8dd8-fd58fa8acb8d";
            $response = $this->client->get($url, [
                'headers' => $this->headers,
            ]);

            $promise->resolve(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            $promise->reject($e->getMessage());
        }

        return $promise;
    }
}