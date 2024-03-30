<?php 
    include_once('config.php');

    if(empty($_FILES['new-image']['name'])){
        $file_name = $_POST['old-image'];
    }else{
        $errors = array();

        $file_name = $_FILES['new-image']['name'];
        $file_size = $_FILES['new-image']['size'];
        $file_tmp = $_FILES['new-image']['tmp_name'];
        $file_type = $_FILES['new-image']['type'];
        $file_ext = strtolower(end(explode('.',$file_name)));
        $extension = array("jpg","jpeg","png");

        if(in_array($file_ext, $extension) === false){
            $errors[] = "This extension file not allowed, Please Choose jpg, png or jpeg";
        }

        if($file_size > 2097152){
            $errors[] = "The Image file size is less then MB or equal";
        }

        if(empty($errors) == true){
            move_uploaded_file($file_tmp,"upload/".$file_name);
        }else{
            print_r($errors);
            die();
        }
    }

    $post_id = $_POST['post_id'];
    $post_title = $_POST['post_title'];
    $post_desc = $_POST['postdesc'];
    $post_category = $_POST['category'];


    $sql = "UPDATE  post set title = '{$post_title}', description = '{$post_desc}', category = {$post_category}, post_img = '{$filename}' where post.post_id = {$post_id}";

    if(mysqli_query($con, $sql)){
        header("Location: http://news-site.test/admin/post.php");
    }else{
        echo "<h2>Query Failed.</h2>";
    }
?>