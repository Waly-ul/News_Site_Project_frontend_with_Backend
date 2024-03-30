<?php 
    include_once('config.php');

    if($_SESSION['role'] == 0){
        header("Location: http://news-site.test/admin/post.php");
    }
?>