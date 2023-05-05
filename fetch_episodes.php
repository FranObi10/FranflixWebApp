<!-- /**
This script searches for TV show episodes on YouTube and adds them to a MySQL database. 
DA RIVEDERE
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
// Include your database connection script
require('functionality/connect_db.php');

function search_youtube($query, $apiKey) {
    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=50&q=" . urlencode($query) . "&key=" . $apiKey;
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $videoIds = array_map(function ($item) {
        return $item['id']['videoId'];
    }, $data['items']);

    return $videoIds;
}
$apiKey = "AIzaSyDAJnMJrmKOQYGF5LJiGeABqSduc5uWJgE";
$query = "TV_SHOW_NAME S01E01"; // Will eplace with the TV show name and the specific episode
$videoIds = search_youtube($query, $apiKey);

// videoIds to construct YouTube links 

$apiKey = "AIzaSyDAJnMJrmKOQYGF5LJiGeABqSduc5uWJgE";

// Fetch the TV shows from database
$q = "SELECT * FROM tv_shows";
$result = mysqli_query($connection, $q);

// Loop through each TV show and fetch the episodes using the YouTube Data API
while ($tv_show = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    // Replace 'TV_SHOW_NAME' with the title of the TV show from database
    $tv_show_name = $tv_show['title'];

    // Fetch the episodes for each season
    for ($season = 1; $season <= $tv_show['num_seasons']; $season++) {
        for ($episode = 1; $episode <= $tv_show['num_episodes']; $episode++) {
            $query = $tv_show_name . " S" . str_pad($season, 2, "0", STR_PAD_LEFT) . "E" . str_pad($episode, 2, "0", STR_PAD_LEFT);
            $videoIds = search_youtube($query, $apiKey);

            // Set the episode_number and episode_title variables
            $episode_number = $episode;
            $episode_title = $tv_show_name . " - Season " . $season . ", Episode " . $episode;

$youtube_link = $videoIds[0]; // 

$insert_query = "INSERT INTO episodes (tv_show_id, season, episode_number, title, youtube_link) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connection, $insert_query);
mysqli_stmt_bind_param($stmt, 'iiiss', $tv_show['id'], $season, $episode_number, $episode_title, $youtube_link);
mysqli_stmt_execute($stmt);

// Check if the insert was successful
if (mysqli_stmt_affected_rows($stmt) == 1) {
    echo "Episode $episode_number of season $season for '{$tv_show_name}' added successfully.\n";
} else {
    echo "Failed to add episode $episode_number of season $season for '{$tv_show_name}'.\n";
}
        }
    }
}
?>