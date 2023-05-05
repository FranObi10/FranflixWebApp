<!-- /**
This script displays TV shows from a database, grouped by category. It first checks if the user is logged in, and if
not, redirects to the login page. It then opens a connection to the database and retrieves all the distinct categories
from the 'tv_shows' table. For each category, it retrieves all the TV shows in that category and displays them in a
carousel. Clicking on a TV show takes the user to a page that displays more information about the show.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
# Access session.
session_start() ;

# Set page title and display header section.
$page_title = 'Tv Shows' ;

#include ( 'includes/logout.html' ) ;
include ( 'includes/header.php' ) ;

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('login_tools.php');
    load();
}

# Open database connection.
require('functionality/connect_db.php');


?>

<main id="main">

    <?php
  # Get all categories
  $q = "SELECT DISTINCT category FROM tv_shows ORDER BY category ASC" ;
  $r = mysqli_query($connection, $q) ;

  while ($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

    # Get movies for this category
    $q = "SELECT * FROM tv_shows WHERE category='{$cat['category']}' ORDER BY title ASC" ;
    $r2 = mysqli_query($connection, $q) ;

    if (mysqli_num_rows($r2) > 0) {
      ?>


    <div class="container my-5">
        <h4 id="my-header-category" class="text-left fw-bold display-4 mb-4"><?= $cat['category'] ?></h4>
        <div class="row owl-carousel owl-theme">
            <?php
        while ($movie = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        ?>
            <div class="col-lg-12 col-md-12 mb-6 movie-container">
                <a href="display_show.php?id=<?= $movie['id'] ?>">
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