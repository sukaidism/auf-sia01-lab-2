<?php 
session_start();

require_once 'db.php';

if(isset($_POST['loginBtn']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $errors = [];

    if(empty(trim($username)) || empty(trim($password))){
        array_push($errors, "All fields are mandatory");
        $_SESSION['errors'] = $errors;
        header('Location: login-form.php');
        exit();
    }
    
    if(count($errors) > 0)
    {
        $_SESSION['errors'] = $errors;
        header('Location: login-form.php');
        exit();
    }

    try {
        $userQuery = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $userQuery);
        
        if(!$result){
            throw new Exception("Database query failed: " . mysqli_error($conn));
        }
        
        $row = mysqli_fetch_assoc($result); // Fetch the result in based on the username
        
        // Check if user exists
        if($row && isset($row['passwd'])){
            $passwordVerified = password_verify($password, $row['passwd']); // Verify the password
            
            if($passwordVerified){
                $_SESSION['is_logged_in'] = true;
                $_SESSION['message'] = "Logged In Successfully!";
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['login_timestamp'] = date('Y-m-d H:i:s');
                error_log("LOGIN_SUCCESS: User logged in successfully - Username: " . $row['username'] . ", Timestamp: " . date('Y-m-d H:i:s'));
                header('Location: welcome.php');
                exit();
            }else{
                array_push($errors, "Invalid Username or Password!");
                $_SESSION['errors'] = $errors;
                error_log("LOGIN_FAILED: Failed login attempt - Username: $username, Timestamp: " . date('Y-m-d H:i:s'));
                header('Location: login-form.php');
                exit();
            }
        }else{
            array_push($errors, "Invalid Username or Password!");
            $_SESSION['errors'] = $errors;
            error_log("LOGIN_FAILED: Failed login attempt - Username: $username, Timestamp: " . date('Y-m-d H:i:s'));
            header('Location: login-form.php');
            exit();
        }
    } catch (Exception $e) {
        error_log("DATABASE_ERROR: " . $e->getMessage() . " | Timestamp: " . date('Y-m-d H:i:s'));
        array_push($errors, "Unable to process login. Please try again later.");
        $_SESSION['errors'] = $errors;
        header('Location: login-form.php');
        exit();
    }
}