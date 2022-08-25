<?php

require 'config/database.php';

if (isset($_POST['submit'])) {
    echo "Echo from the inside";
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Invalid input";
    } else {
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id LIMIT 1";
        $result =  mysqli_query($conn, $query);
        if (mysqli_errno($conn)) {
            $_SESSION['edit-category'] = "Failed to update category.";
        } else {
            $_SESSION['edit-category-success'] = "$title updated successfully.";
        }
    }
}

header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
