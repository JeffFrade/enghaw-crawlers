<?php

namespace App\Core\Services;

use GuzzleHttp\Client;

class EngHawApi
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client ?? $this->createDefaultClient();
    }

    /**
     * @return Client
     */
    private function createDefaultClient()
    {
        return new Client([
            'base_uri' => env('ENGHAW_API_HOST')
        ]);
    }

    /**
     * @param array $music
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function storeMusic(array $music)
    {
        return $this->getClient()->request('POST', '/music', [
            'body' => $music
        ])->getBody()->getContents();
    }
}
