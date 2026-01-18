<?php
session_start();

require_once "db.php";

if(isset($_POST['registerBtn']))
{
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn,$_POST['confirmPassword']);
    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $date = new DateTime();
    $dateNow = date('Y-m-d H:i:s');
    $errors = [];

    if($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Enter valid email address");
    }

    if(isset($email)){
        $emailCheck = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                array_push($errors, "Email address already exists");
            }
        }else{
            array_push($errors, "Something Went Wrong!");
        }
    }

    if(isset($username)){
        $userCheck = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
        if($userCheck){
            if(mysqli_num_rows($userCheck) > 0){
                array_push($errors, "Username already exists");
            }
        }else{
            array_push($errors, "Something Went Wrong!");
        }
    }

    if($password != $confirmPassword){
        array_push($errors, "Password and Confirm Password should be the same!");
    }

    if($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Enter valid email address");
    }

    if(count($errors) > 0){
        $_SESSION['errors'] = $errors;
        header('Location: registration-form.php');
        exit();
    }

    $hash_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (email, username, passwd, fullname, created_at) VALUES ('$email','$username','$hash_password','$fullname', '$dateNow')";
    $userResult = mysqli_query($conn, $query);

    if($userResult){
        $_SESSION['message'] = "Registered Successfully";
        header('Location: registration-form.php');
        exit();
    }else{
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: registration-form.php');
        exit();
    }

}

?>