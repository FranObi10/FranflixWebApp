<!-- Load edit form based on show type. -->
<?php
require('../functionality/connect_db.php');

$show_id = $_GET['id'];
$type = $_GET['type'];

if ($type === 'movie') {
    $table = 'movies';
} else {
    $table = 'tv_shows';
}

// Fetch show data from the database
$query = "SELECT * FROM $table WHERE id = $show_id";
$result = mysqli_query($connection, $query);
$show = mysqli_fetch_array($result, MYSQLI_ASSOC);

// Appropriate form based on show type
if ($type === 'movie') {
?>
<form action="update_show.php" method="POST" class="form">

    <!-- Aggiungo input fields for show ID and type -->
    <input type="hidden" name="id" value="<?= $show_id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <!-- Movie-specific form fields -->
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?= $show['title'] ?>" required>

    <label for="creator">Director:</label>
    <input type="text" name="creator" id="creator" value="<?= $show['creator'] ?>" required>

    <label for="category">Category:</label>
    <input type="text" name="category" id="category" value="<?= $show['category'] ?>" required>

    <label for="image">Image URL:</label>
    <input type="text" name="image" id="image" value="<?= $show['image'] ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" required><?= $show['description'] ?></textarea>

    <label for="duration">Duration:</label>
    <input type="text" name="duration" id="duration" value="<?= $show['duration'] ?>" required>

    <label for="release_year">Release Year:</label>
    <input type="text" name="release_year" id="release_year" value="<?= $show['release_year'] ?>" required>

    <label for="language">Language:</label>
    <input type="text" name="language" id="language" value="<?= $show['language'] ?>" required>

    <label for="youtube_link">Video Link:</label>
    <input type="text" name="youtube_link" id="youtube_link" value="<?= $show['youtube_link'] ?>" required>

    <!-- <input type="submit" value="Update Movie"> -->
</form>
<?php
} else {
?>
<form action="update_show.php" method="POST" class="form">

    <!-- Aggiungo input fields for show ID and type -->
    <input type="hidden" name="id" value="<?= $show_id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <!-- TV Show-specific form fields -->
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?= $show['title'] ?>" required>

    <label for="creator">Creator:</label>
    <input type="text" name="creator" id="creator" value="<?= $show['creator'] ?>" required>

    <label for="category">Category:</label>
    <input type="text" name="category" id="category" value="<?= $show['category'] ?>" required>

    <label for="image">Image URL:</label>
    <input type="text" name="image" id="image" value="<?= $show['image'] ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" required><?= $show['description'] ?></textarea>

    <label for="release_year">Release Year:</label>
    <input type="text" name="release_year" id="release_year" value="<?= $show['release_year'] ?>" required>

    <label for="language">Language:</label>
    <input type="text" name="language" id="language" value="<?= $show['language'] ?>" required>

    <label for="num_seasons">Seasons:</label>
    <input type="number" name="num_seasons" id="num_seasons" value="<?= $show['num_seasons'] ?>" required>

    <label for="num_episodes">Episodes:</label>
    <input type="number" name="num_episodes" id="num_episodes" value="<?= $show['num_episodes'] ?>" required>

    <!-- <input type="submit" value="Update TV Show"> -->
</form>
<?php
}
?>