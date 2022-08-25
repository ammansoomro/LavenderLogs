<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch post data from database
    $query = "SELECT * from posts WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);

    // DELETE Thumbnail

    if (mysqli_num_rows($result) == 1) {
        $thumbnail = $post['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail;

        if ($thumbnail_path) {
            unlink($thumbnail_path);
            $delete_query = "DELETE FROM posts WHERE id=$id";
            $delete_result = mysqli_query($conn, $delete_query);

            if (mysqli_errno($conn)) {
                $_SESSION['delete-post'] = "Couldn't delete post";
            } else {
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }
        }
    }


    // DELETE POSTS




    // DELETE post

}


header('location:' . ROOT_URL . 'admin/index.php');
