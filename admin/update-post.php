<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form for show edit-->
                <?php
                include_once('config.php');

                $post_id = $_REQUEST['id'];
                $sql = "SELECT post.post_id,post.title,post.description,post.category,post.post_img,category.category_name from post left join category on post.category = category.category_id left join user on post.author = user.user_id where post.post_id = {$post_id}";

                $result = mysqli_query($con, $sql) or die("Query Failed");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $row['post_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?PHP echo $row['title']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea name="postdesc" class="form-control" required rows="5"> <?php echo $row['description']; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <select class="form-control" name="category">
                                <option value="" disabled>Select Category</option>
                                    <?php
                                        $sql2 = "SELECT * from category where 1";
                                        $result2 = mysqli_query($con, $sql2) or die("Query Failed");

                                        if(mysqli_num_rows($result2) > 0){
                                            while( $row2 = mysqli_fetch_assoc($result2)){
                                                if($row['category'] == $row2['category_id']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                echo "<option {$selected} class='{$selected}' value='{$row2['category_id']}'>{$row2['category_name']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Post image</label>
                                <input type="file" name="new-image">
                                <img src="upload/<?php echo $row['post_img']; ?>" height="150px">
                                <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php
                    }
                } else {
                    echo "<h2>Result Not Found.</h2>";
                }
                ?>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>