<?php
include 'partials/header.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);

    $post_author_id = $post['author_id'];
    $query2 = "SELECT * FROM users WHERE id=$post_author_id";
    $result2 = mysqli_query($conn, $query2);
    $author = mysqli_fetch_assoc($result2);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
}

?>

<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?php echo $post['title']; ?></h2>
        <div class="post__author">
            <div class="post__author-avatar">
                <img src="<?= ROOT_URL . "images/" . $author['avatar'] ?>" alt="">
            </div>
            <div class="post__author-info">
                <h5>By: <?= $author['firstname'] . " " . $author['lastname'] ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="<?php echo ROOT_URL . "images/" . $post['thumbnail'] ?>" alt="">
        </div>
        <p><?php echo $post['body']; ?></p>
    </div>
</section>


<?php
include 'partials/footer.php';
?>