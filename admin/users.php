<?php 
    include "header.php";
    if($_SESSION['role'] == 0){
        header("Location: http://news-site.test/admin/post.php");
    }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <?php
                include_once('config.php');

                $limit = 3;
                if(isset($_REQUEST['page'])){
                    $page = $_REQUEST['page'];
                }else{
                    $page = 1;
                }
                $offset = ($page-1) * $limit;
                $sql = "SELECT * from user order by user_id desc limit $offset, $limit";
                $result = mysqli_query($con, $sql) or die("Query Failed");

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td class="id"><?php echo $row["user_id"]; ?></td>
                                    <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                                    <td><?php echo $row["username"]; ?></td>
                                    <td>
                                        <?php
                                        if ($row['role'] == 1) {
                                            echo "Admin";
                                        } else {
                                            echo "Normal User";
                                        }
                                        ?>
                                    </td>
                                    <td class='edit'><a href='update-user.php?id=<?PHP echo $row['user_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?PHP echo $row['user_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                }

                $sql1 = "SELECT * from user where 1";
                $result2 = mysqli_query($con, $sql1) or die("Query Failed");

                if (mysqli_num_rows($result2)>0) {
                    $total_row = mysqli_num_rows($result2);
                    $total_page = ceil($total_row / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    if($page>1){
                        echo '<li><a href="users.php?page='.($page-1).'">Previous</a></li>';
                    }
                    for($i=1; $i<=$total_page; $i++){
                        if($i == $page){
                            $active = "active";
                        }else{
                            $active = "";
                        }
                        echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                    }
                    if($page<$total_page){
                        echo '<li><a href="users.php?page='.($page+1).'">Next</a></li>';
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>