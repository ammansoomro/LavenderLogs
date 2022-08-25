<?php
include 'partials/header.php';

$query2 = "SELECT * FROM categories";
$categories = mysqli_query($conn, $query2);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/index.php');
    die();
}

?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">

            <input type="hidden" name="id" value="<?= $posts['id'] ?>">

            <input type="hidden" name="previous_thumbnail_name" value="<?= $posts['thumbnail'] ?>">

            <input type="text" name="title" value="<?= $posts['title'] ?>" placeholder="Title">

            <select name="category" id="">
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></option>
                <?php endwhile ?>
            </select>

            <textarea rows="4" name="body" placeholder="Body"><?php echo $posts['body'] ?></textarea>
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" checked>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" checked>
            </div>

            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>

<!-- =================== END OF FORM =================== -->



<?php
include '../partials/footer.php';
?>