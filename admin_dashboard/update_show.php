<?php
require('../functionality/connect_db.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $table = $type === 'movie' ? 'movies' : 'tv_shows';

    // Get the submitted form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    // Se devo aggiungere altre variabili per altri fields

    // Prepare the query with placeholders
    $query = "UPDATE {$table} SET
                title = ?,
                category = ?,
                image = ?,
                description = ?
              WHERE id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the values to the placeholders
    mysqli_stmt_bind_param($stmt, 'ssssi', $title, $category, $image, $description, $id);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect back to the admin_dashboard with a success message
        header('Location: shows.php?message=Show+updated+successfully');
    } else {
        // Redirect back to the admin_dashboard with an error message
        header('Location: shows.php?message=Error+updating+the+show');
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

?>