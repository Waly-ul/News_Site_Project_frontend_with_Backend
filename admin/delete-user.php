<?php 

    include_once('config.php');

    if($_SESSION['role'] == 0){
        header("Location: http://news-site.test/admin/post.php");
    }

    $user_id = $_REQUEST['id'];

    $sql = "DELETE from user where user.user_id = $user_id";

    if(mysqli_query($con, $sql)){
        header("Location: http://news-site.test/admin/users.php?page=1");
    }else{
        echo "<h2>Query Failed</h2>";
    }

    mysqli_close($con);

?>