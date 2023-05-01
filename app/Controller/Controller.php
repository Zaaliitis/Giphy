<?php

namespace App\Controller;

use App\Model\ApiClient;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Controller
{
    private ApiClient $client;
    private Environment $twig;

    private array $favoriteTags;

    public function __construct()
    {
        $this->client = new ApiClient();
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
        $this->favoriteTags = [
            'John Wick',
            'Boston Terrier',
            'Movie',
            'Weather',
            "Hockey",
        ];
        sort($this->favoriteTags);
    }

    public function search(): string
    {
        $searchQuery = $_GET['search_query'] ?? '';
        $offset = $_GET['offset'] ?? 0;
        $favoriteTag = $_GET['favorite_tag'] ?? '';
        if ($favoriteTag) {
            $searchQuery .= ' ' . $favoriteTag;
        }
        $gifs = $searchQuery ? $this->client->getBySearch($searchQuery, $offset) : [];

        $moreGifsUrl = '';
        if ($gifs && count($gifs) == 5) {
            $moreGifsUrl = '/?search_query=' . urlencode($searchQuery) . '&offset=' . ($offset + 5);
        }

        return $this->twig->render('view.html.twig', [
            'gifs' => $gifs,
            'moreGifsUrl' => $moreGifsUrl,
            'favoriteTags' => $this->favoriteTags
        ]);
    }

    public function random(): string
    {
        $gifs = $this->client->getRandom();
        return $this->twig->render('view.html.twig', ['gifs' => $gifs]);
    }

    public function trending(): string
    {
        $gifs = $this->client->getTrending();
        return $this->twig->render('view.html.twig', ['gifs' => $gifs]);
    }    public function home(): string
    {
        $gifs = $this->client->getTrending();
        return $this->twig->render('view.html.twig', ['favoriteTags' => $this->favoriteTags,]);
    }
}