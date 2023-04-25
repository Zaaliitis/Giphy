<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GIPHY SEARCH PAGE</title>
</head>
<body>
<div style="text-align:center;">
<form action="/" method="GET">
    <label for="search_query">Search for GIFs:</label>
    <input type="text" id="search_query" name="search_query">
    <button type="submit">Search</button>
</form>
</div>

<?php
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use App\ApiClient;

$client = new ApiClient();
$searchQuery = $_GET['search_query'];
$client->getGifs($searchQuery);
?>
<div style="text-align:center;">
    <br>
    <button style="font-size: 40px; padding: 20px 40px; background-color: #4E5B31; color: black; border: 2px solid black; border-radius: 5px;"
            type="button"
            onclick="location.href='/index.php?search_query=<?= $searchQuery ?>&offset=<?= $client->getOffset() ?>'">
        MORE GIFs
    </button>
</div>
</body>
</html>