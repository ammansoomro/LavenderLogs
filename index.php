<?php
include 'partials/header.php';

$members_query  = "SELECT * FROM users LIMIT 20";
$members_query_result = mysqli_query($conn, $members_query);
$post_update_query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$post_update_result = mysqli_query($conn, $post_update_query);
?>

<!-- <section class="featured">
    <div class="container">
        <div class="splide" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list" style="max-height: 400px">
                    <li class="splide__slide"><img style="object-fit: fill" src="images/16578119381114291.jpg" alt=""></li>
                    <li class="splide__slide"><img style="object-fit: fill" src="images/1657836760wp5929128-gaming-aesthetic-wallpapers.jpg" alt=""></li>
                    <li class="splide__slide"><img style="object-fit: fill" src="images/1657836896wp5426686-overwatch-aesthetic-pc-wallpapers.jpg" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</section>
<script type="text/javascript">
    new Splide(".splide", {
        type: "loop",
        perPage: 1,
        autoplay: true,
        pagination: false,
        snap: false
    }).mount();
</script> -->
<!-- =================== END OF FEATURED =================== -->
<section class="posts">
    <div class="container news__container">
        <div class="news__table table__update">
            <h3>News / Updates</h3>
            <table>
                <thead>
                    <tr>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($post_update_result)) : ?>
                        <?php
                        $id = $row['id'];
                        $query6 = "SELECT * from users WHERE id = $id";
                        $result6 = mysqli_query($conn, $query6);
                        $post__author = mysqli_fetch_assoc($result6); ?>

                        <tr>
                            <td>
                                <div class="post__info">
                                    <?php
                                    $category_id = $row['category_id'];
                                    $query5 = "SELECT * from categories WHERE id = $category_id";
                                    $result5 = mysqli_query($conn, $query5);
                                    $category = mysqli_fetch_assoc($result5);
                                    ?>

                                    <p class="post__body">
                                        Posted a new blog named <?php echo $row['title'] ?> in <?php echo $category['title'] ?> category.</p>
                                </div>
                                <div class="post__author">
                                    <?php
                                    $author_id = $row['author_id'];
                                    $query6 = "SELECT * from users WHERE id = $author_id";
                                    $result6 = mysqli_query($conn, $query6);
                                    $author = mysqli_fetch_assoc($result6);
                                    ?>
                                    <div class="post__author-avatar">
                                        <img src="<?= ROOT_URL . "images/" . $author['avatar'] ?>" alt="">
                                    </div>
                                    <div class="post__author-info">
                                        <h5>By: <?= $author['firstname'] . " " . $author['lastname'] ?></h5>
                                        <small><?= date("M d, Y - H:i", strtotime($row['date_time'])) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h3 class="post__title">
                                    <h3 class="post__title"><a class="category__button" href="<?= ROOT_URL ?>post.php?id=<?= $row['id'] ?>"><?php echo "View Blog" ?></a></h3>
                                </h3>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
        <div class="news__table table__users">
            <h3 class="table__header">Members</h3>
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($members_query_result)) : ?>

                        <tr>
                            <td class="user__img"> <img src="<?= ROOT_URL . "images/" . $row['avatar']  ?>"> </td>
                            <td> <?php echo $row["firstname"]; ?> </td>
                            <td> <?php echo $row["is_admin"] == 1 ?  "Admin" :  "Author"; ?> </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
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