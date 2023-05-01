<?php

namespace App\Controller;

use App\Model\ApiClient;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Controller
{
    private ApiClient $client;
    private Environment $twig;

    public function __construct()
    {
        $this->client = new ApiClient();
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function search(): string
    {
        $searchQuery = $_GET['search_query'] ?? '';
        $gifs = $searchQuery ? $this->client->getBySearch($searchQuery) : [];
        return $this->twig->render('view.html.twig', ['gifs' => $gifs]);
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
        return $this->twig->render('view.html.twig');
    }
}