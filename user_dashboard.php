<?php
# Access session.
session_start();

# Set page title and display header section.
$page_title = 'User Dashboard';

include('includes/header.php');

## Retrieve user information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT first_name, last_name, email, role FROM users WHERE user_id='$user_id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

# Assign retrieved values to variables
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$email = $row['email'];
$role = $row['role'];

$sql = "SELECT u.first_name, u.role, l.logo_url
        FROM users u LEFT JOIN logos l
        ON u.logo_id = l.logo_id
        WHERE u.user_id = $user_id";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    $row = array();
}

?>

<style>
.position-relative {
    position: relative;
}

.edit-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    cursor: pointer;
}

.favorite-text {
    color: #ea580c !important;
    font-weight: bold;
}
</style>

<div id="alert-container">
</div>
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php if (!empty($row['logo_url'])) { ?>
                            <img src="<?php echo $row['logo_url']; ?>" alt="User Avatar" class="rounded-circle"
                                width="150">
                            <?php } else { ?>
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Default Avatar"
                                class="rounded-circle" width="150">
                            <?php } ?>
                            <div id="logoDropdown" style="display: none;"></div>
                            <div class="mt-3">
                                <h4><?php echo $row['first_name']; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-globe mr-2 icon-inline">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                    </path>
                                </svg></h6>
                            <span class="text-secondary"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-github mr-2 icon-inline">
                                    <path
                                        d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                    </path>
                                </svg></h6>
                            <span class="text-secondary"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-twitter mr-2 icon-inline text-info">
                                    <path
                                        d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                </svg></h6>
                            <span class="text-secondary"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-instagram mr-2 icon-inline text-danger">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg></h6>
                            <span class="text-secondary"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-facebook mr-2 icon-inline text-primary">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg></h6>
                            <span class="text-secondary"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $first_name; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Last Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $last_name; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $email; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Type of user</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $role; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type='button' class='btn btn-info' data-bs-toggle='modal'
                                    data-bs-target='#changePasswordModal'>
                                    Edit Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Change Password modal -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="changePasswordModal">Change Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="change-password-form">
                                    <div class="form-group">
                                        <label for="new_password">New Password:</label>
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required>
                                    </div>
                                    <button type='submit' class='btn btn-primary'>Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('change-password-form').addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Serialize form data
                        const formData = new FormData(e.target);

                        // Send AJAX request
                        fetch('functionality/change_password.php', {
                                method: 'POST',
                                body: formData,
                            })
                            .then((response) => {
                                console.log('Response status:', response.status);
                                return response.json();
                            })
                            .then((data) => {
                                console.log('Response data:', data);
                                const alertContainer = document.createElement('div');
                                alertContainer.classList.add('alert', 'alert-dismissible', 'fade',
                                    'show');

                                if (data.status === 'success') {
                                    alertContainer.classList.add('alert-success');
                                    alertContainer.innerHTML = `
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Success!</strong> ${data.message}
          `;

                                    // Close the modal
                                    const changePasswordModal = document.getElementById(
                                        'changePasswordModal');
                                    const bootstrapModal = bootstrap.Modal.getInstance(
                                        changePasswordModal);
                                    bootstrapModal.hide();
                                } else {
                                    alertContainer.classList.add('alert-danger');
                                    alertContainer.innerHTML = `
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Error!</strong> ${data.message}
          `;
                                }

                                // Add the alert to the main alert container
                                const mainAlertContainer = document.getElementById(
                                    'alert-container');
                                mainAlertContainer.appendChild(alertContainer);
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    });
                });
                </script>


                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i
                                        class="material-icons text-info mr-2 favorite-text">Favorite</i>Movies</h6>
                                <?php
                $sql = "SELECT m.title, m.category, m.display_img
                        FROM user_likes ul
                        JOIN movies m ON ul.movie_id = m.id
                        WHERE ul.user_id = $user_id";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='row mb-3'>";
                        echo "<div class='col-sm-4'>";
                        echo "<img src='" . $row['display_img'] . "' class='img-fluid'>";
                        echo "</div>";
                        echo "<div class='col-sm-8'>";
                        echo "<h6>" . $row['title'] . "</h6>";
                        echo "<p>" . $row['category'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>You have not liked any movies yet.</p>";
                }
                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i
                                        class="material-icons text-info mr-2 favorite-text">Favorite</i>TV
                                    Shows</h6>
                                <?php
                $sql = "SELECT m.title, m.category, m.image
                        FROM user_likes ul
                        JOIN tv_shows m ON ul.movie_id = m.id
                        WHERE ul.user_id = $user_id";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='row mb-3'>";
                        echo "<div class='col-sm-4'>";
                        echo "<img src='" . $row['image'] . "' class='img-fluid'>";
                        echo "</div>";
                        echo "<div class='col-sm-8'>";
                        echo "<h6>" . $row['title'] . "</h6>";
                        echo "<p>" . $row['category'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>You have not liked any TV shows yet.</p>";
                }
                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<?php
# Include footer file.
include('includes/footer.html');
?>