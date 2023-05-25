<!-- /**
This script displays movies from a database, grouped by category. It first checks if the user is logged in, and if not,
redirects to the login page. It then opens a connection to the database and retrieves all the distinct categories from
the 'movies' table. For each category, it retrieves all the movies in that category and displays them in a carousel.
Clicking on a movie takes the user to a page that displays more information about the movie.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
# Access session.
session_start();

# Set page title and display header.
$page_title = 'Movies';

include('includes/header.php');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('functionality/login_tools.php');
    load();
}

# Open database connection.
require('functionality/connect_db.php');

?>


<style>
#my-header-category {
    color: #fff;
    font-size: 1.5rem;
}

.movie-container {
    width: 300px;
    height: auto;
    overflow: hidden;
}

.movie-image {
    width: 100%;
    height: 200px;
    display: block;
}
</style>


<main id="main">

    <?php
    # Get all categories
    $q = "SELECT DISTINCT category FROM movies ORDER BY category ASC";
    $r = mysqli_query($connection, $q);

    while ($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        # Get movies for category
        $q = "SELECT * FROM movies WHERE category='{$cat['category']}' ORDER BY title ASC";
        $r2 = mysqli_query($connection, $q);

        if (mysqli_num_rows($r2) > 0) {
    ?>

    <div class="container my-5">
        <h4 id="my-header-category" class="text-left fw-bold display-4 mb-4"><?= $cat['category'] ?></h4>
        <div class="row owl-carousel owl-theme">
            <?php
            while ($movie = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
            ?>
            <div class="col-lg-12 col-md-12 mb-6 movie-container">
                <a href="display_movie.php?id=<?= $movie['id'] ?>">
                    <img src="<?= $movie['image'] ?>" alt="" class="img-fluid movie-image">
                </a>
            </div>

            <?php
            }
            ?>
        </div>
    </div>

    <?php
        }
    }
    ?>

</main><!-- End #main -->



<?php
include('includes/footer.html');
?>