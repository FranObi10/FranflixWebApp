<!-- /**
This script displays a carousel of movies on the landing page.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php

# Access session.
session_start();

# Set page title and display header section.
$page_title = 'Movies';

require('functionality/connect_db.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

#include ( 'includes/logout.html' ) ;
include('includes/header_landing_page.html');

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
                            <div>
                            </div>
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

</main><!-- End #main -->

<?php

include('includes/footer.html');

?>