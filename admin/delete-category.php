<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch user data from database
    $update_query = "UPDATE posts SET category_id = 11 WHERE category_id = $id";
    $update_result = mysqli_query($conn, $update_query);




    // DELETE Category

    if (!mysqli_errno($conn)) {
        $delete_query = "DELETE FROM categories WHERE id=$id";
        $delete_result = mysqli_query($conn, $delete_query);
        $_SESSION['delete-category-success'] = "Category deleted successfully";
    }
}


header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
