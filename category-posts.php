<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * from categories WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);
    $query4 = "SELECT * FROM posts WHERE category_id = $id ORDER BY date_time DESC LIMIT 9";
    $result4 = mysqli_query($conn, $query4);
} else {
    header('location: ' . ROOT_URL . 'index.php');
}

?>

<header class="category__title">
    <h2><?php echo $category['title'] ?></h2>
</header>

<section class="posts">
    <div class="container posts__container">
        <?php if (mysqli_num_rows($result4) > 0) : ?>
            <?php while ($post = $posts = mysqli_fetch_assoc($result4)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?php echo ROOT_URL . "images/" . $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post__info">
                        <?php
                        $category_id = $post['category_id'];
                        $query5 = "SELECT * from categories WHERE id = $category_id";
                        $result5 = mysqli_query($conn, $query5);
                        $category = mysqli_fetch_assoc($result5);
                        ?>
                        <h3 class="post__title">
                            <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?php echo $post['title'] ?></a></h3>
                        </h3>
                        <p class="post__body">
                            <?php echo substr($post['body'], 0, 300); ?>... </p>
                        <div class="post__author">
                            <?php
                            $author_id = $post['author_id'];
                            $query6 = "SELECT * from users WHERE id = $author_id";
                            $result6 = mysqli_query($conn, $query6);
                            $author = mysqli_fetch_assoc($result6);
                            ?>
                            <div class="post__author-avatar">
                                <img src="<?= ROOT_URL . "images/" . $author['avatar'] ?>" alt="">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <?= $author['firstname'] . " " . $author['lastname'] ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>
        <?php else : ?>
            <div class="alert__message error">
                <p>No Posts found for this category.</p>
            </div>
        <?php endif ?>
    </div>
</section>

<!-- =================== END OF POSTS =================== -->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM categories ORDER BY title ASC";
        $all_categories_result = mysqli_query($conn, $all_categories_query);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?php echo $category['title']; ?></a>
        <?php endwhile; ?>
    </div>
</section>

<!-- =================== END OF CATEGORY BUTTONS =================== -->

<?php
include 'partials/footer.php';
?>