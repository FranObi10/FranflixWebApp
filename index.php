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
<section id="hero"
    style="background-image: url('https://authors.appadvice.com/wp-content/appadvice-v2-media/2016/11/Netflix-background_860c8ece6b34fb4f43af02255ca8f225.jpg'); background-size: cover; height: 100vh; position: relative;">
    <div style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
        <div class="hero-container" style="display: flex; justify-content: center; align-items: center; height: 100%;">
            <div style="text-align: center; color: white;">
                <h1 style="font-size: 3em; animation: pulse 2s infinite;">Welcome to <span
                        id="franflix">Franflix!</span></h1>
                <p><a href="login.php" style="color: #ea580c; text-decoration: underline;">Login</a> or <a
                        href="register.php" style="color: #ea580c; text-decoration: underline;">Register</a></p>
            </div>
        </div>
    </div>
</section>
<!-- End Hero -->

<style>
#franflix {
    color: #ea580c;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.5);
    }

    100% {
        transform: scale(1);
    }
}
</style>



<main id="main">

</main><!-- End #main -->

<?php

include('includes/footer.html');

?>