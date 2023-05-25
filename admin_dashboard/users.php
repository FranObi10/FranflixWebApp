<?php
# Access session.
session_start();

# Set page title and display header section.
$page_title = 'Admin Dashboard';

#include ( 'includes/logout.html' ) ;
include('../includes/admin_header.html');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('../functionality/login_tools.php');
    load();
}

# Open database connection.
require('../functionality/connect_db.php');
?>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fa-solid fa-pen"></i>
                </i>FRANFLIX</div>
            <div class="list-group list-group-flush my-3">
                <a href="admin_dashboard.php"
                    class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="users.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-users"></i> Users</a>
                <a href="shows.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-film"></i> Shows</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-shopping-cart me-2"></i>Memberships</a>
                <a href="../logout.php"
                    class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Admin Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../home.php">Home</a></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                </div>

                <!-- Users table -->
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Users</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Registration Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
    $q = "SELECT user_id, first_name, last_name, email, role, reg_date FROM users";
    $r = mysqli_query($connection, $q);
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <th scope="row">' . $row['user_id'] . '</th>
            <td>' . $row['first_name'] . '</td>
            <td>' . $row['last_name'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['role'] . '</td>
            <td>' . $row['reg_date'] . '</td>
            <td>
            <a href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="' . $row['user_id'] .'" class="edit-link">Edit</a> |
            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="' . $row['user_id'] . '" class="delete-link">Delete</a>
            
            </td>
        </tr>';
    }
    
    ?>

                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="post" action="edit_user.php">
                    <div class="modal-body">
                        <!-- Add form inputs for editing user details -->
                        <input type="hidden" name="edit_user_id" id="edit_user_id">
                        <div class="form-group">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="edit_first_name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="edit_email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_role">Role</label>
                            <select class="form-control" id="edit_role" name="edit_role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="blocked">Blocked</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit User Modal -->

    <script>
    // Edit User Modal
    // Edit User Modal
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');

        // Make an AJAX request to fetch the user data based on the userId
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_user.php?user_id=' + userId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var userData = JSON.parse(xhr.responseText);

                    // Populate the form fields with the fetched user data
                    document.getElementById('edit_user_id').value = userData.user_id;
                    document.getElementById('edit_first_name').value = userData.first_name;
                    document.getElementById('edit_last_name').value = userData.last_name;
                    document.getElementById('edit_email').value = userData.email;
                    document.getElementById('edit_role').value = userData.role;
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        xhr.send();
    });
    </script>



    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteUserForm" method="post" action="delete_user.php">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                        <input type="hidden" name="user_id" id="delete_user_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete User Modal -->

    <script>
    // Edit User Modal
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');

        // I'm using dummy data here. REMEMBER to change it
        var userData = {
            user_id: userId,
            first_name: 'John',
            last_name: 'Doe',
            email: 'john.doe@example.com',
            role: 'user'
        };

        document.getElementById('edit_user_id').value = userData.user_id;
        document.getElementById('edit_first_name').value = userData.first_name;
        document.getElementById('edit_last_name').value = userData.last_name;
        document.getElementById('edit_email').value = userData.email;
        document.getElementById('edit_role').value = userData.role;
    });

    // Delete User Modal
    var deleteUserModal = document.getElementById('deleteUserModal');
    deleteUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');

        document.getElementById('delete_user_id').value = userId;
    });
    </script>





    <script>
    var el = document.getElementById(" wrapper");
    var toggleButton = document.getElementById("menu-toggle");
    toggleButton.onclick = function() {
        el.classList.toggle("toggled");
    };
    </script>

</body>

<?php
include('../includes/admin_footer.html');
?>