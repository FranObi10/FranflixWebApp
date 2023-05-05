<!-- /**
* This script handles the password reset functionality.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
ob_start(); // Start output buffering

include 'includes/header_landing_page.html';
require('functionality/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and new password from form
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    // Check if passwords match
    if ($new_password == $confirm_password) {
        // Hash the new password using SHA-256
        $hashed_password = hash('sha256', $new_password);

        // Update the password in the database
        $sql = "UPDATE users SET pass='$hashed_password' WHERE email='$email'";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            // Redirect to the reset_success.php page
            header("Location: reset_success.php");
            ob_end_flush(); // Flush output buffer and send headers
            exit();
        } else {
            echo "<p>There was an error updating the password. Please try again.</p>";
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<strong>Password do not match. Please try again</strong><br>';
    }
}

?>

<body>
    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="col-md-6 mt-3">
            <div class="card card1 p-3">
                <div class="d-flex flex-column">
                    <span class="form-title mt-3">Reset Password</span>
                </div>
                <form action="reset_password.php" method="post">
                    <div class="input-field d-flex flex-column mt-3">
                        <span class="mt-3">Email</span>
                        <input type="email" class="form-control" placeholder="Email address" name="email" required
                            size="20">
                        <br>
                        <span class="mt-3">Password</span>
                        <input type="password" class="form-control" placeholder="New password" name="new_password"
                            required>
                        <br>
                        <span class="mt-3">Confirm New Password</span>
                        <input type="password" class="form-control" placeholder="Confirm new password"
                            name="confirm_password" required>
                        <button type="submit" class="mt-4 btn btn-dark">Reset Password</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>


    <?php
include 'includes/footer.html';
?>