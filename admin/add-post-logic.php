<?php
require './config/database.php';
if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ?: 0;


    if (!$title) {
        $_SESSION['add-post'] = "Enter Post Title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select Post Category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter Post Body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Please add a Thumbnail";
    } else {
        //Rename thumbnail to make it unique
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        //File should be an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            if ($thumbnail['size'] < 2000000) {
                //Upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size too large, should be less than 1MB";
            }
        } else {
            $_SESSION['add-post'] = "File should be .png, .jpg, or .jpeg";
        }
    }

    //Go back to add-post page if there was any problem
    if (isset($_SESSION['add-post'])) {
        //Pass Data Back too
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {

        if ($is_featured == 1) {
            $count_featured_query = "SELECT * FROM posts WHERE is_featured = 1";
            $count_featured_result = mysqli_query($conn, $count_featured_query);
            if (mysqli_num_rows($count_featured_result) == 5) {
                $zero_is_featured = "SELECT * FROM posts WHERE is_featured=1 ORDER BY date_time ASC LIMIT 1";
                $zero_is_featured_result = mysqli_query($conn, $zero_is_featured);
                $zero_is_featured_post = mysqli_fetch_assoc($zero_is_featured_result);
                $id = $zero_is_featured_post['id'];
                $zero_is_featured = "UPDATE posts SET is_featured = 0 WHERE id = $id";
                $result = mysqli_query($conn, $zero_is_featured);
            }
        }

        //Insert post into Database
        $insert_post_query = "INSERT INTO posts (title,body,thumbnail,category_id,author_id,is_featured) VALUES('$title','$body','$thumbnail_name','$category_id','$author_id','$is_featured')";
        $insert_post_result = mysqli_query($conn, $insert_post_query);

        if (!mysqli_error($conn)) {
            $_SESSION['add-post-success'] = "New post added successfully.";
            header('location:' . ROOT_URL . 'admin/index.php');
            die();
        }
    }
} else {
    header('location:' . ROOT_URL . 'admin/add-post.php');
}
