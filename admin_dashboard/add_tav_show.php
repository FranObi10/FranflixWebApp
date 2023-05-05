<?php
require('../functionality/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $creator = $_POST['creator'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $release_year = $_POST['release_year'];
    $language = $_POST['language'];
    $num_seasons = $_POST['num_seasons'];
    $num_episodes = $_POST['num_episodes'];
    $youtube_link = $_POST['youtube_link'];

    $query = "INSERT INTO tv_shows (title, creator, image, category, description, release_year, language, num_seasons, num_episodes, youtube_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssssiis", $title, $creator, $image, $category, $description, $release_year, $language, $num_seasons, $num_episodes, $youtube_link);

    if ($stmt->execute()) {
        echo "TV Show added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}