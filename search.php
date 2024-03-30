<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php

                    include("config.php");

                    if (isset($_REQUEST['search'])) {
                        $search_term = mysqli_real_escape_string($con, $_REQUEST['search']);
                    }

                    ?>
                    <h2 class="page-heading">Search : <?php echo  $search_term; ?></h2>

                    <?php
                    include_once('config.php');

                    $limit = 3;
                    if (isset($_REQUEST['page'])) {
                        $page = $_REQUEST['page'];
                    } else {
                        $page = 1;
                    }
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT post.post_id,post.title,post.description,post.post_date,category.category_name,user.username,post.category,post.post_img,post.author from post left join category on post.category = category.category_id left join user on post.author = user.user_id where post.title like '%{$search_term}%' or post.description like '%{$search_term}%' order by post.post_id desc limit $offset,$limit";

                    $result = mysqli_query($con, $sql) or die("Query Failed");

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php'><?php echo $row['category_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date']; ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 100) . '...'; ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php

                        }
                    }else{
                        echo "<h2>No Record's Found!</h2>";
                    }

                    $sql2 = "SELECT * from post where post.title like '%{$search_term}%'";

                    $result2 = mysqli_query($con, $sql2) or die("Query Failed");

                    $total_page = ceil(mysqli_num_rows($result2)/$limit);

                    if (mysqli_num_rows($result2) > 0) {
                        echo "<ul class='pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="author.php?search=' . $search_term . '&page=' . ($page - 1) . '">Previous</a></li>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($page == $i) {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo '<li class=' . $active . '><a href="author.php?search=' . $search_term . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $total_page) {
                            echo '<li><a href="author.php?search=' . $search_term . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>