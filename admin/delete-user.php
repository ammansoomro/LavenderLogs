<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch user data from database
    $query = "SELECT * from users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // DELETE AVATAR

    if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;

        if ($avatar_path) {
            unlink($avatar_path);
        }
    }


    // DELETE POSTS
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
    $thumbnails_result = mysqli_query($conn, $thumbnails_query);
    if (mysqli_num_rows($thumbnails_result) > 0) {
        while($thumbnail = mysqli_fetch_assoc($thumbnails_result))
        {
            $thumbnail_path = '../images/' . $thumbnail['thumbnail'];

            if($thumbnail_path)
            {
                unlink($thumbnail_path);
            }
        }
    }



    // DELETE USER
    $delete_query = "DELETE FROM users WHERE id=$id";
    $delete_result = mysqli_query($conn, $delete_query);

    if (mysqli_errno($conn)) {
        $_SESSION['delete-user'] = "Couldn't delete user";
    } else {
        $_SESSION['delete-user-success'] = "User deleted successfully";
    }
}


header('location:' . ROOT_URL . 'admin/manage-users.php');
