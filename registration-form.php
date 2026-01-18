<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" >
 
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="mt-4 card card-body shadow">

                    <h4>Register</h4>
                    <hr>
                    <?php
                    if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
                        foreach($_SESSION['errors'] as $error){
                            ?>
                            <div class="alert alert-warning"><?= $error; ?></div>
                            <?php
                        }
                        unset($_SESSION['errors']);
                    }

                    if(isset($_SESSION['message'])){
                        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <form action="register.php" method="POST" autocomplete="off">

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required />
                        </div>
                        
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="confirmPassword" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <button type="submit" name="registerBtn" class="btn btn-primary w-100">Register Now</button>
                        </div>
                        <div class="text-center">
                            <a href="login-form.php">Click here to Login</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

