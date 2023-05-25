<!-- /**
* Helper functions for user login.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
# LOGIN HELPER FUNCTIONS.

# Function to check if the user is blocked
function isUserBlocked($connection, $email) {
    $query = "SELECT role FROM users WHERE email = ?";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        return ($role == 'blocked');
    }

    return false; // Return false by default if the query fails
}

# Function to load specified or default URL.
function load( $page = '../home.php' )
{
  # Begin URL with protocol, domain, and current directory.
  $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) ;

  # Remove trailing slashes then append page name to URL.
  $url = rtrim( $url, '/\\' ) ;
  $url .= '/' . $page ;

  # Execute redirect then quit. 
  ob_start(); // Start output buffering
  header( "Location: $url" ) ; 
  ob_end_flush(); // Flush output buffer and send headers
  exit() ;
}

# Function to check email address, password, and user role. 
function validate($connection, $email = '', $pwd = '', $required_role = '')
{
    # Initialize errors array.
    $errors = array();

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($connection, trim($email));
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($connection, trim($pwd));
    }

    # On success retrieve user_id, first_name, last_name, and user_role from 'users' database.
    if (empty($errors)) {
        $q = "SELECT user_id, first_name, last_name, role FROM users WHERE email='$e' AND pass=SHA2('$p',256)";
        $r = mysqli_query($connection, $q);
        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            # Check if the required role is set and if the user has the required role.
            if ($required_role && $row['role'] != $required_role) {
                $errors[] = 'You do not have permission to access this page.';
                return array(false, $errors);
            }

            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];

            # Return success with user data and role.
            return array(true, array('user_id' => $row['user_id'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_role' => $row['role']));
        }
        # Or on failure set error message.
        else {
            $errors[] = 'Email address and password not found.';
        }
    }
    # On failure retrieve error message/s.
    return array(false, $errors);

  
}


?>