<!-- /**
This script handles user registration. It receives user input through a form and validates the input data. If the input
data is valid, it inserts the user data into the 'users' database table. If there are any errors, it displays them to
the user.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php

# Connect to the database.
require('functionality/connect_db.php');

# Include HTML static file 
include('includes/header_landing_page.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  # Initialize an error array.
  $errors = array();

  # Check for a first name.
  if (empty($_POST['first_name'])) {
    $errors[] = 'Enter your first name.';
  } else {
    $fn = mysqli_real_escape_string($connection, trim($_POST['first_name']));
  }

  # Check for a last name.
  if (empty($_POST['last_name'])) {
    $errors[] = 'Enter your last name.';
  } else {
    $ln = mysqli_real_escape_string($connection, trim($_POST['last_name']));
  }

    # Check for email.
  if (empty($_POST['email'])) {
    $errors[] = 'Enter your email address.';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Enter a valid email address.';
} else {
    $e = mysqli_real_escape_string($connection, trim($_POST['email']));
}

  # Check for a password and matching input passwords.
  if (!empty($_POST['pass1'])) {
    if ($_POST['pass1'] != $_POST['pass2']) {
      $errors[] = 'Passwords do not match.';
    } else {
      $p = mysqli_real_escape_string($connection, trim($_POST['pass1']));
    }
  } else {
    $errors[] = 'Enter your password.';
  }
  
  # Check if email address already registered.
if (empty($errors)) {
  $q = "SELECT user_id FROM users WHERE email='$e'";
  $r = mysqli_query($connection, $q);
  if (mysqli_num_rows($r) != 0) {
    $errors[] = 'Email address already registered. <a class="alert" href="login.php">Sign In Now</a>';
  }
}
  # Get the selected logo id
  if (isset($_POST['logo_id'])) {
    $logo_id = mysqli_real_escape_string($connection, trim($_POST['logo_id']));
  } else {
    $errors[] = 'Select a logo.';
  }

  # On success register user inserting into 'users' database table.
  if (empty($errors)) {
    $q = "INSERT INTO users (first_name, last_name, email, pass, role,reg_date, logo_id)
    VALUES ('$fn', '$ln', '$e', SHA2('$p',256),'registered', NOW(), '{$_POST['logo_id']}' )";
$r = mysqli_query($connection, $q);
if ($r) {
echo '<div class="alert alert-success" role="alert">
You are now registered.
<a href="login.php">Login</a>
</div>';
mysqli_close($connection);
exit();
} else {
echo '<div class="alert alert-danger" role="alert">
<p>An error occurred while registering. Please try again later.</p>
</div>';
}
} else {
echo '<div class="alert alert-danger" role="alert">
<p>The following error(s) occurred:</p>';
foreach ($errors as $msg) {
echo " - $msg<br>";
}
echo '<p>Please try again.</p>
</div>';
}
}

?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card p-3">
                <div class="d-flex flex-column">
                    <span class="form-title mt-3">Register Here</span>
                </div>
                <form action="register.php" method="post" class="d-flex flex-column mt-3">
                    <div class="input-field d-flex flex-column mt-3">
                        <span>First Name</span>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter your first name"
                            value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
                    </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Last Name</span>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter your last name"
                            value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
                    </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Email</span>
                        <input type="text" name="email" class="form-control" placeholder="Enter your email address"
                            value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                    </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Password</span>
                        <input type="password" name="pass1" class="form-control" placeholder="Choose a password">
                    </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Re-type Password</span>
                        <input type="password" name="pass2" class="form-control" placeholder="Confirm the password">
                    </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Select a logo</span>
                        <?php
        # Retrieve logos from the logos table.
        $q = "SELECT * FROM logos";
        $r = mysqli_query($connection, $q);
    ?>
                        <div class="row">
                            <?php while ($logo = mysqli_fetch_array($r, MYSQLI_ASSOC)) { ?>
                            <div class="col-md-3">
                                <input type="radio" name="logo_id" value="<?php echo $logo['logo_id']; ?>"
                                    required="required">
                                <img src="<?php echo $logo['logo_url']; ?>" alt="<?php echo $logo['logo_name']; ?>"
                                    height="100">
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <button type="submit"
                        class="mt-3 btn btn-dark d-flex justify-content-center align-items-center">Register</button>
                    <div class="mt-4 d-flex align-items-center">
                        <span class="me-2">Already have an account?</span>
                        <span class="login"><a href="login.php">Log in here</a></span>
                    </div>
                </form>


            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php
# Display footer section.
include('includes/footer.html');

# Close the connection.
mysqli_close($connection);
?>