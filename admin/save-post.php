<?php 

    include_once('config.php');

    if(isset($_FILES['fileToUpload'])){
        $errors = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
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

    session_start();
    $title = mysqli_real_escape_string($con, $_POST['post_title']);
    $description = mysqli_real_escape_string($con, $_POST['postdesc']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $date = date("d M,Y");
    $author = $_SESSION['user_id'];

    $sql = "INSERT into post(title, description, category, post_date, author, post_img) values ('{$title}', '{$description}', {$category},'{$date}',{$author},'{$file_name}');";

    $sql = $sql . "UPDATE category set post = post + 1 where category_id = {$category}";

    if(mysqli_multi_query($con, $sql)){
        header("Location: http://news-site.test/admin/post.php");
    }else{
        echo "<h2>Query Failed.</h2>";
    }
?>