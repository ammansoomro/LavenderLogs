<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "Username or Email Required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password Required";
    } else {
        $check_user_query = "SELECT * FROM users WHERE username= '$username_email' OR email='$username_email'";
        $check_user_result = mysqli_query($conn, $check_user_query);

        if (mysqli_num_rows($check_user_result) == 1) {
            $user_record = mysqli_fetch_assoc($check_user_result);
            $db_password = $user_record['password'];

            if (password_verify($password, $db_password)) {
                $_SESSION['user-id'] = $user_record['id'];
                if ($user_record['is_admin'] == 1) {
                    //set session if user is admin
                    $_SESSION['user_is_admin'] = true;
                }

                //Log the user in
                header('location:' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Please check your input";
            }
        } else {
            $_SESSION['signin'] = "User not Found";
        }
    }


    //If there is any problem redirect to signin page with login data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
