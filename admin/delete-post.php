<?php 

    include_once('config.php');

    $post_id = $_REQUEST['id'];
    $cat_id = $_REQUEST['cat_id'];

    $sql1 = "SELECT * from post where post.post_id = $post_id";
    $result = mysqli_query($con, $sql1) or die("Query Failed");

    $row = mysqli_fetch_assoc($result);
    unlink("upload/".$row["post_img"]);

    $sql = "DELETE from post where post_id = {$post_id};";
    $sql .= "UPDATE category set post = post - 1 where category_id = {$cat_id}";

    if(mysqli_multi_query($con, $sql)){
        header("Location: http://news-site.test/admin/post.php");
    }else{
        echo "<h2>Query Failed</h2>";
    }

?>