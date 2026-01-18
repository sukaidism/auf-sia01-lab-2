<?php
session_start();
session_unset();
session_destroy();

// Set a logout message in a new session
session_start();
    $_SESSION['logout_message'] = "Logged out successfully!";
    header('Location: login-form.php');
    exit();
?>