<?php
include 'partials/header.php';
$query0 = "SELECT * FROM posts ORDER BY date_time DESC";
$result0 = mysqli_query($conn, $query0);

$query = "SELECT * FROM posts WHERE is_featured = 1";
$result = mysqli_query($conn, $query);
$featured = mysqli_fetch_assoc($result);

$featured_category_id = $featured['category_id'];
$query2 = "SELECT * from categories WHERE id = $featured_category_id";
$result2 = mysqli_query($conn, $query2);
$featured_category = mysqli_fetch_assoc($result2);

$featured_author_id = $featured['author_id'];
$query3 = "SELECT * from users WHERE id = $featured_author_id";
$result3 = mysqli_query($conn, $query3);
$featured_author = mysqli_fetch_assoc($result3);
// SELECT 9 POSTS from the Table
$post_update_query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$post_update_result = mysqli_query($conn, $post_update_query);
?>

<section class="featured">
    <div class="slidershow middle">
        <div class="slides">
            <input type="radio" name="r" id="r1" checked>
            <input type="radio" name="r" id="r2">
            <input type="radio" name="r" id="r3">
            <input type="radio" name="r" id="r4">
            <input type="radio" name="r" id="r5">
            <div class="slide s1">
                <div class="container featured__container">
                    <div class="post__thumbnail">
                        <img src="<?php echo ROOT_URL . "images/" . $featured['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post__info">
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured_category['id'] ?>" class="category__button"><?php echo $featured_category['title'] ?></a>
                        <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?php echo $featured['title'] ?></a></h2>
                        <p class="post__body">
                            <?php echo substr($featured['body'], 0, 300); ?>...
                        </p>
                        <div class="post__author">
                            <div class="post__author-avatar">
                                <img src="<?= ROOT_URL . "images/" . $featured_author['avatar'] ?>" alt="">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <?= $featured_author['firstname'] . " " . $featured_author['lastname'] ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="slide">
                    <div class="container featured__container">
                        <div class="post__thumbnail">
                            <img src="<?php echo ROOT_URL . "images/" . $row['thumbnail'] ?>" alt="">
                        </div>
                        <div class="post__info">
                            <?php
                            $featured_category_id = $row['category_id'];
                            $query2 = "SELECT * from categories WHERE id = $featured_category_id";
                            $result2 = mysqli_query($conn, $query2);
                            $featured_category = mysqli_fetch_assoc($result2);
                            ?>
                            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured_category['id'] ?>" class="category__button"><?php echo $featured_category['title'] ?></a>
                            <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $row['id'] ?>"><?php echo $row['title'] ?></a></h2>
                            <p class="post__body">
                                <?php echo substr($row['body'], 0, 300); ?>...
                            </p>
                            <div class="post__author">
                                <?php
                                $featured_author_id = $row['author_id'];
                                $query3 = "SELECT * from users WHERE id = $featured_author_id";
                                $result3 = mysqli_query($conn, $query3);
                                $featured_author = mysqli_fetch_assoc($result3);
                                ?>
                                <div class="post__author-avatar">
                                    <img src="<?= ROOT_URL . "images/" . $featured_author['avatar'] ?>" alt="">
                                </div>
                                <div class="post__author-info">
                                    <h5>By: <?= $featured_author['firstname'] . " " . $featured_author['lastname'] ?></h5>
                                    <small><?= date("M d, Y - H:i", strtotime($row['date_time'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
        <div class="navigation">
            <label for="r1" class="bar"></label>
            <label for="r2" class="bar"></label>
            <label for="r3" class="bar"></label>
            <label for="r4" class="bar"></label>
            <label for="r5" class="bar"></label>
        </div>
    </div>
</section>

<!-- =================== END OF FEATURED =================== -->


<section class="search__bar">
    <form action="" class="container search__bar-container">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="" placeholder="Search">
        </div>
        <button type="submit" class="btn">Go</button>
    </form>
</section>

<!-- =================== END OF SEARCH =================== -->

<section class="posts">
    <div class="container posts__container">
        <?php while ($post = $posts = mysqli_fetch_assoc($result0)) : ?>
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
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?php echo $category['title']; ?></a>
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