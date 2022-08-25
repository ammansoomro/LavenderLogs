<?php

require 'config/database.php';

echo "Hello From Outside";

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    echo "Hello From Inside";

    echo "ID: " . $id . " previous_thumbnail_name:" . $previous_thumbnail_name . " thumbnail " . $thumbnail . "Title:" . $title . " Body: "  . $body . " Category:" . $category_id . " is_featured: " . $is_featured;



    $is_featured = $is_featured == 1 ?: 0;


    if (!$title) {
        $_SESSION['edit-post'] = "Enter Post Title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Select Post Category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Enter Post Body";
    } else {

        //Delete current thumbnail if new is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            //Rename the thumbnail to make it unique
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
                    $_SESSION['edit-post'] = "File size too large, should be less than 1MB";
                }
            } else {
                $_SESSION['edit-post'] = "File should be .png, .jpg, or .jpeg";
            }
        }
    }

    //Go back to edit-post page if there was any problem
    if (isset($_SESSION['edit-post'])) {
        header('location:' . ROOT_URL . 'admin/index.php');
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

        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        //EDIT POST
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert',category_id='$category_id',is_featured='$is_featured' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
    }


    if (!mysqli_error($conn)) {
        $_SESSION['edit-post-success'] = "New post edited successfully.";
    }
}

header('location:' . ROOT_URL . 'admin/index.php');
die();
