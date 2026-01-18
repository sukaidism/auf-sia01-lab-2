<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-4 card card-body shadow">

                    <h4>Login</h4>
                    <hr>

                    <?php
                        if(isset($_SESSION['logout_message'])){
                            echo '<div class="alert alert-success">'.$_SESSION['logout_message'].'</div>';
                            unset($_SESSION['logout_message']);
                        }
                        
                        if(isset($_SESSION['login_required_message'])){
                            echo '<div class="alert alert-warning">'.$_SESSION['login_required_message'].'</div>';
                            unset($_SESSION['login_required_message']);
                        }
                    ?>

                    <?php
                        if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
                            foreach($_SESSION['errors'] as $error){
                                echo '<div class="alert alert-warning">'.$error.'</div>';
                            }
                            unset($_SESSION['errors']);
                        }
                    ?>

                    <form action="login.php" method="POST" autocomplete="off">

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="loginBtn" class="btn btn-primary w-100">Login Now</button>
                        </div>
                        <div class="text-center">
                            <a href="registration-form.php">Click here to Register</a>
                        </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>