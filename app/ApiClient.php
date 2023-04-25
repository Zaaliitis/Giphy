<?php
namespace App;

use GuzzleHttp\Client;

class ApiClient
{
    private Client $client;
    private int $offset = 0;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/gifs/',
        ]);
        if (isset($_GET['offset'])) {
            $this->offset = intval($_GET['offset']);
        }
    }
    public function getOffset(): int
    {
        return $this->offset;
    }
    public function getGifs(string $searchQuery): void
    {
        $response = $this->client->get('search', [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'q' => $searchQuery,
                'limit' => 21,
                'offset' => $this->offset,
                'rating' => 'r',
                'lang' => 'en'
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $gifs = array_column($data['data'], 'images');

        echo '<div style="text-align:center;">';
        $count = 0;
        foreach ($gifs as $gif) {
            $gif_url = $gif['fixed_height']['url'];
            echo '<img src="' . $gif_url . '">';

            $count++;
            if ($count % 3 == 0) {
                echo '<br>';
            }
        }
        echo '</div>';
        $this->offset += 21;
    }
}