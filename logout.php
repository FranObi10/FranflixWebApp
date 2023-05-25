<?php
session_start();

/* # Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    require('functionality/login_tools.php');
    load();
} */

# Clear existing variables
$_SESSION = array();

# Destroy the session
session_destroy();

# Set page title and display header section
$page_title = "Home";
include('includes/header_landing_page.html');
require('functionality/connect_db.php');

// Fetch image URLs from the 'tv_shows' table
$sql = "SELECT image FROM tv_shows";
$result = $connection->query($sql);

$image_urls = [];

if ($result->num_rows > 0) {
    // Save image URLs into an array
    while ($row = $result->fetch_assoc()) {
        $image_urls[] = $row["image"];
    }
} else {
    echo "0 results";
}

// Pick a random image URL
$random_image_url = $image_urls[array_rand($image_urls)];
?>


<!-- ======= Hero Section ======= -->
<section id="hero"
    style="background-image: url('https://authors.appadvice.com/wp-content/appadvice-v2-media/2016/11/Netflix-background_860c8ece6b34fb4f43af02255ca8f225.jpg'); background-size: cover; height: 100vh; position: relative;">
    <div style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
        <div class="hero-container" style="display: flex; justify-content: center; align-items: center; height: 100%;">
            <div style="text-align: center; color: white;">
                <h1 style="font-size: 3em; animation: pulse 2s infinite;">Goodbye! See you soon on <span
                        id="franflix">Franflix!</span></h1>
                <p><a href="login.php" style="color: #ea580c; text-decoration: underline;">Login</a></p>
            </div>
        </div>
    </div>
</section>
<!-- End Hero -->

<style>
#franflix {
    color: #ea580c;
}
</style>



<?php
    # Display footer section
    include('includes/footer.html');
?>

<!-- <script>
// Redirect to index.php after a short delay
setTimeout(function() {
    window.location.href = 'index.php';
}, 3000); // Redirect after 3 seconds (adjust the delay as needed)
</script>
 
 -->