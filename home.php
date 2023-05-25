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
session_start();

# Set page title and display header section.
$page_title = 'Home';

# Connect to the database
require('functionality/connect_db.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

# Include the header
include('includes/header.php');

// Fetch movie data from the database for carousel
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

<style>
.text-left {
    color: #fff;
    font-size: 1.5rem;
}

.carousel-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 1));
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

/* Coming soon text */
@keyframes dotAnimation {
    0% {
        opacity: 0.1;
        transform: scale(0.8);
    }

    50% {
        opacity: 0.8;
        transform: scale(1.2);
    }

    100% {
        opacity: 0.3;
        transform: scale(0.8);
    }
}

.dot-animation {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: #fff;
    border-radius: 50%;
    margin-left: 5px;
    opacity: 1;
    animation: dotAnimation 1.5s infinite;
}

.dot-animation:nth-child(2) {
    animation-delay: 0.5s;
}

.dot-animation:nth-child(3) {
    animation-delay: 1s;
}

.carousel-text {
    position: absolute;
    bottom: 20px;
    right: 50px;
    text-align: right;
}

.carousel-text h2 {
    color: #fff;
    opacity: 1;
    font-size: 10px;
}


/* Text for non registered user */
.join-membership-text {
    font-size: 40px;
}

.join-membership-text {
    animation: pulsate 2s infinite;
}

@keyframes pulsate {
    0% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: 0.5;
        transform: scale(1.1);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

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
                            <div class="text-center mb-3">
                                <p class="join-membership-text">Join Our membership to have unlimited access to the
                                    catalog</p>
                            </div>
                            <div>
                                <a href="join_membership.php"
                                    class="btn-get-started animate__animated animate__fadeInUp scrollto">JOIN
                                    NOW</a>
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

    <!-- The Most liked -->
    <div class="container my-5">
        <h3 class="text-left fw-bold display-1 mb-5">Recommended by Users</h3>
        <div class="row owl-carousel owl-theme">
            <?php
        # Get 10 most liked shows from both movies and tv_shows
        $q = "SELECT * FROM (
            (SELECT movies.*, 'movie' as show_type, COUNT(user_likes.id) as num_likes
             FROM movies
             LEFT JOIN user_likes ON movies.id = user_likes.movie_id
             GROUP BY movies.id
             ORDER BY num_likes DESC LIMIT 5)
            UNION
            (SELECT tv_shows.*, 'show' as show_type, COUNT(user_likes.id) as num_likes
             FROM tv_shows
             LEFT JOIN user_likes ON tv_shows.id = user_likes.movie_id
             GROUP BY tv_shows.id
             ORDER BY num_likes DESC LIMIT 5)
         ) AS shows ORDER BY num_likes DESC";
        
        $r = mysqli_query($connection, $q);

        while ($show = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $show_page = ($show['show_type'] == 'movie') ? 'display_movie.php' : 'display_show.php';
            $show_id = $show['id'];
            ?>
            <div class="col-lg-12 col-md-12 mb-6 movie-container">
                <a href="<?= $show_page ?>?id=<?= $show_id ?>">
                    <img src="<?= $show['image'] ?>" alt="" class="img-fluid movie-image">
                </a>
            </div>
            <?php
        }
        ?>
        </div>
    </div>




    <!-- Category Sections -->
    <div class="container">
        <?php
        // Fetch unique categories from both movies and tv_shows tables
        $category_query = "SELECT DISTINCT category FROM
                          (SELECT category FROM movies
                           UNION
                           SELECT category FROM tv_shows) AS all_categories";
        $category_result = $connection->query($category_query);

        $categories = [];
        if ($category_result->num_rows > 0) {
            while ($row = $category_result->fetch_assoc()) {
                $categories[] = $row['category'];
            }
        } else {
            echo "No categories found.";
        }

        // Loop through each category
        foreach ($categories as $index => $category) {
            $carousel_class = "owl-carousel-" . $index;
            echo '<h2 class="text-left fw-bold display-4 mb-4">' . $category . '</h2>';
            echo '<div class="row ' . $carousel_class . ' owl-carousel owl-theme">';
    
            // Fetch movies and tv shows belonging to the category
            $show_query = "SELECT * FROM (
                            (SELECT *, 'movie' as show_type FROM movies WHERE category = '$category' LIMIT 5)
                            UNION
                            (SELECT *, 'show' as show_type FROM tv_shows WHERE category = '$category' LIMIT 5)
                          ) AS shows";
            $show_result = mysqli_query($connection, $show_query);

            // Display fetched shows
            while ($show = mysqli_fetch_array($show_result, MYSQLI_ASSOC)) {
                $show_page = ($show['show_type'] == 'movie') ? 'display_movie.php' : 'display_show.php';
                $show_id = $show['id'];
                echo <<<HTML
            <div class="col-lg-12 col-md-12 mb-6 movie-container">
                <a href="{$show_page}?id={$show_id}">
                    <img src="{$show['image']}" alt="" class="img-fluid movie-image">
                </a>
            </div>
    HTML;
            }
    
            echo '</div>';
        }
        ?>
    </div>
</main><!-- End #main -->


<?php
    # Include the footer
    include('includes/footer.html');
    ?>