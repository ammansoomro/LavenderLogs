<?php
require './config/database.php';
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpass = filter_var($_POST['createpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpass = filter_var($_POST['confirmpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter valid Email";
    } elseif (strlen($createpass) < 8 || strlen($confirmpass) < 8) {
        $_SESSION['add-user'] = "Password should be at least 8 characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please add an Avatar";
    } else {
        if ($confirmpass !== $createpass) {
            $_SESSION['add-user'] = "Password do not match";
        } else {
            //Hashing the Password.
            $hashed_password = password_hash($createpass, PASSWORD_DEFAULT);

            //Check if the User already exists
            $user_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($conn, $user_check);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already exists.";
            } else {
                //Rename Avatar to make it unique
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //File should be an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);

                if (in_array($extension, $allowed_files)) {
                    if ($avatar['size'] < 1000000) {
                        //Upload Avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "File size too large, should be less than 1MB";
                    }
                } else {
                    $_SESSION['add-user'] = "File should be .png, .jpg, or .jpeg";
                }
            }
        }
    }

    //Go back to add-user page if there was any problem
    if (isset($_SESSION['add-user'])) {
        //Pass Data Back too
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        //Insert user into Database
        $insert_user_query = "INSERT INTO users (firstname,lastname,username,email,password,avatar,is_admin) VALUES('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name','$is_admin')";
        $insert_user_result = mysqli_query($conn, $insert_user_query);

        if (!mysqli_error($conn)) {
            $_SESSION['add-user-success'] = "New User $firstname $lastname added successfully.";
            header('location:' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
} else {
    header('location:' . ROOT_URL . 'admin/add-user.php');
}
