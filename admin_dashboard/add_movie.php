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
    $duration = $_POST['duration'];
    $youtube_link = $_POST['youtube_link'];

    $query = "INSERT INTO movies (title, creator, image, category, description, release_year, language, duration, youtube_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssssss", $title, $creator, $image, $category, $description, $release_year, $language, $duration, $youtube_link);

    if ($stmt->execute()) {
        echo "Movie added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
       