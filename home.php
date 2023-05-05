<!-- /**
* This script displays the homepage of the website. It connects to the database, retrieves the movies from the
carousel_movies table, and displays them in a carousel. It also displays all the categories of movies available on the
website and the movies under each category in a carousel. If the user is not a member, it displays a "JOIN MEMBERSHIP"
button. It includes the header, footer, and logout HTML files.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php

# Access session.
session_start() ;

# Set page title and display header section.
$page_title = 'Home' ;

# Connect to database
require('functionality/connect_db.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

#include ( 'includes/logout.html' ) ;
include ( 'includes/header.php' ) ;

// Fetch movie data from the database
$sql = "SELECT * FROM carousel_movies";
$result = $connection->query($sql);

$movies = [];
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$movies[] = $row;
}
} else {
echo "0 results";
}
?>

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" data-bs-interval="3000" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">
                <?php
                $isFirst = true;
                foreach ($movies as $movie) {
                    $activeClass = $isFirst ? 'active' : '';
                    $isFirst = false;
                ?>

                <!-- Slide -->
                <div class="carousel-item <?php echo $activeClass; ?>"
                    style="background-image: url('<?php echo $movie['image']; ?>');">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <?php if (!$is_member) { ?>
                            <div>
                                <a href="join_membership.php"
                                    class="btn-get-started animate__animated animate__fadeInUp scrollto">JOIN
                                    MEMBERSHIP</a>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </div>
</section><!-- End Hero -->


<main id="main">

    <?php
  # Get all categories
  $q = "SELECT DISTINCT category FROM movies ORDER BY category ASC" ;
  $r = mysqli_query($connection, $q) ;

  while ($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

    # Get movies for this category
    $q = "SELECT * FROM movies WHERE category='{$cat['category']}' ORDER BY title ASC" ;
    $r2 = mysqli_query($connection, $q) ;

    if (mysqli_num_rows($r2) > 0) {
      ?>

    <div class="container my-5">
        <h1 class="text-left fw-bold display-1 mb-5"><?= $cat['category'] ?></h1>
        <div class="row owl-carousel owl-theme">
            <?php
        while ($movie = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        ?>
            <div class="col-lg-12 col-md-12 mb-6 movie-container">
                <img src="assets/img/img_movies/<?= $movie['image'] ?>" alt="" class="img-fluid movie-image">
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