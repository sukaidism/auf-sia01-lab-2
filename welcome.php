<?php
session_start();
require_once 'db.php';

if(!isset($_SESSION['is_logged_in'])) {
    $_SESSION['login_required_message'] = "Please login to access this page";
    header('Location: login-form.php');
    exit();
}else {
    // Fetch all registered users with error handling
    try {
        $usersQuery = "SELECT * FROM users ORDER BY created_at DESC";
        $usersResult = mysqli_query($conn, $usersQuery);
        
        if(!$usersResult){
            throw new Exception("Database query failed: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        error_log("DATABASE_ERROR: " . $e->getMessage() . " | Timestamp: " . date('Y-m-d H:i:s'));
        $usersResult = false; // Set to false so the view can handle it gracefully
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-4 card card-body shadow">

                    <h4>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h4>
                    <hr>

                    <?php
                    if(isset($_SESSION['message'])){
                        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <div class="mb-4">
                        <h5>User Information</h5>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['fullname']); ?></p>
                        <p><strong>Login Timestamp:</strong> <?php echo htmlspecialchars($_SESSION['login_timestamp']); ?></p>
                    </div>

                    <div class="mb-3">
                        <a href="logout.php" class="btn btn-danger w-100">Logout</a>
                    </div>

                    <hr>

                    <div class="mt-4">
                        <h5>All Registered Users</h5>
                        <?php if($usersResult && mysqli_num_rows($usersResult) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-primary table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Full Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($user = mysqli_fetch_assoc($usersResult)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php elseif($usersResult === false): ?>
                            <div class="alert alert-danger">Unable to retrieve user data. Please try again later.</div>
                        <?php else: ?>
                            <p class="text-muted">No registered users found.</p>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
