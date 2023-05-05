<!-- /**
* Validates user login credentials and sets session data on success.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('connect_db.php');

    # Get connection, load, and validate functions.
    require('login_tools.php');

    # Check if the user is an admin.
    $required_role = '';
    if (isset($_POST['is_admin']) && $_POST['is_admin'] == 'on') {
        $required_role = 'admin';
    }

    # Check login.
    list($check, $data) = validate($connection, $_POST['email'], $_POST['pass'], $required_role);

    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        session_start();

        $_SESSION['user_role'] = $data['user_role'];
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];

        if ($data['user_role'] == 'admin') {
            header('Location: ../admin_dashboard/admin_dashboard.php');           
             exit();
        } else {
            load('../home.php');
        }
    }
    # Or on failure set errors.
    else {
        $errors = $data;
    }

    # Close database connection.
    mysqli_close($connection);
}

# Continue to display login page on failure.
include('login.php');

?>