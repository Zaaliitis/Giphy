<?php

namespace App\Model;

use GuzzleHttp\Client;


class ApiClient
{
    private Client $client;
    private string $searchInput;
    private int $offset;
    private int $limit;
    private array $parameters;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/gifs/',
        ]);

    }

    private function getParameters($searchInput, $limit, $offset): array
    {
       return $this->parameters = [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'q' => $searchInput,
                'limit' => $limit,
                'offset' => $offset,
                'rating' => 'r',
                'lang' => 'en'
            ],
        ];
    }

    public function getBySearch(string $searchInput, int $offset = 0): array
    {
        $response = $this->client->get('search', $this->getParameters($searchInput, 5, $offset));
        $data = json_decode($response->getBody(), true);
        return array_column($data['data'], 'images');
    }
    public function getTrending(int $offset = 0): array
    {
        $response = $this->client->get('trending', $this->getParameters("", 15, $offset));
        $data = json_decode($response->getBody(), true);
        return array_column($data['data'], 'images');
    }    public function getRandom(int $offset = 0): array
    {
        $response = $this->client->get('random', $this->getParameters("", 1, $offset));
        $data = json_decode($response->getBody(), true);
        return array_column($data, 'images');
    }

}
