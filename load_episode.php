<!-- /**
* Returns a JSON-encoded array of episodes for a given TV show ID and season.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<!-- get_episodes.php -->
<?php
require('fetch_episodes.php');

if (!isset($_GET['tv_show_id'])) {
    echo "TV show ID not provided";
    exit();
}

$season = $_GET['season'] ?? null;
$episode = $_GET['episode'] ?? null;
$tv_show_id = $_GET['tv_show_id'] ?? null;

if ($tv_show_id === null || $season === null || $episode === null) {
    echo "TV Show ID, season, or episode number not provided";
    exit();
}

fetch_episodes($tv_show_id, $season, $episode);
?>