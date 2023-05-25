<!-- /**
 * This script displays the complete login page. It starts a session and retrieves the image URLs from the database table 'tv_shows'. It then selects a random image URL and displays it on the login page. If there are any error messages, they are displayed as well. The user can enter their email and password to log in, or they can click on the 'Forgot password?' link to reset their password. If the user does not have an account, they can click on the 'Register here' link to create a new account. 
 *
 * @Francesca Obino
 * @Franflix WebApp
 */ -->
<?php
session_start(); // Add this line to start a session

# Set page title and display header section.
$page_title = 'Login';

if (isset($_SESSION['login_error'])) {
    $errors = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

#include ( 'includes/logout.html' ) ;
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

# Display any error messages if present.
if (isset($errors) && !empty($errors)) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<strong>Oops! There was a problem:</strong><br>';
    foreach ($errors as $msg) {
        echo " - $msg<br>";
    }
    echo 'Please try again or <a href="register.php">Register</a></p>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex flex-row g-0">
        <div class="col-md-6 mt-3">
            <div class="card card1 p-3">
                <div class="d-flex flex-column">
                    <span class="form-title mt-3">Log in</span>
                </div>
                <form action="functionality/login_action.php" method="post">
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Email</span>
                        <input type="text" class="form-control" placeholder="email@example.com" name="email" required
                            size="20" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                        <span class="mt-3">Password</span>
                        <input type="password" class="form-control" placeholder="Enter Your Password" name="pass"
                            required size="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>">
                        <button type="submit"
                            class="mt-4 btn btn-dark d-flex justify-content-center align-items-center">Login</button>
                        <div class="mt-3 text1">
                            <span class="mt-3 forget"><a href="reset_password.php">Forgot password?</a></span>
                        </div>
                        <div class="mt-4 d-flex align-items-center">
                            <span class="me-2">Don't have an account?</span>
                            <span class="register"><a href="register.php">Register here</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card card2 p-3">
                <div class="image">
                    <img src="<?php echo $random_image_url; ?>" class="fit-image">
                </div>
            </div>
        </div>
    </div>
</div>



<?php
    #Display footer section.
    include ( 'includes/footer.html' ) ;
    ?>