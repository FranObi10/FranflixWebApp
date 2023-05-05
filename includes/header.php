<!-- /**
This script generates the header section of the Franflix web application. It starts by checking if a session is already
started, and if not, it starts a new session. It then opens a database connection by requiring the 'connect_db.php'
file.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

# Open database connection.
require(__DIR__ . '/../functionality/connect_db.php');

// check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // get the logo_id for the user
    $user_id = $_SESSION['user_id'];
    // database connection code 
    $query = "SELECT logo_id, first_name, membership_status FROM users WHERE user_id = $user_id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $logo_id = $row['logo_id'];
    $user_first_name = $row['first_name'];
    // check if user is member
    $is_member = false;
    $membership_status = $row['membership_status'];
    if ($membership_status == 'active') {
    $is_member = true;
}

    if (isset($logo_id)) {
        // get the logo URL from the logos table
        $logo_query = "SELECT logo_url FROM logos WHERE logo_id = $logo_id";
        $logo_result = mysqli_query($connection, $logo_query);
        $logo_row = mysqli_fetch_assoc($logo_result);
        $logo_url = $logo_row['logo_url'];
    }
}

function setActiveClass($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="nav-link scrollto active"';
    else
        echo 'class="nav-link scrollto"';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Libraries. Not sure if I still need them -->
    <script src="assets/web_app/glightbox/js/glightbox.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Owl Carousel -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- CSS Files -->
    <link href="assets/web_app/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/web_app/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/web_app/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/web_app/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/web_app/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/web_app/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Font Awesome  -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Other meta tags and links -->
    <script src="https://unpkg.com/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="sticky-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="home.php">Franflix</a></h1>
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a <?php setActiveClass('home'); ?> href="home.php">Home</a></li>
                    <li><a <?php setActiveClass('movies'); ?> href="movies.php">Movies</a></li>
                    <li><a <?php setActiveClass('tv_shows'); ?> href="tv_shows.php">Tv Shows</a></li>
                    <li><a <?php setActiveClass('membership'); ?> href="join_membership.php">Membership</a></li>

                    <li class="user-name">
                        <?php if (isset($user_first_name)) : ?>
                        <a class="nav-link scrollto user-name-link" href="#"><?php echo $user_first_name; ?></a>
                        <?php endif; ?>
                    </li>
                    <?php if ($is_member) : ?>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-star member-star"></i>
                        </span>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if(isset($logo_url)) { ?>
                            <img src="<?php echo $logo_url; ?>" alt="User Logo" class="user-logo logo-img">
                            <?php } else { ?>
                            <i class="fas fa-user"></i>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="user_dashboard.php">Manage Account</a>
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav><!-- .navbar -->
        </div>
    </header>

    <!-- End Header -->

    <script src="includes/navbar-hide.js"></script>