<?php
include "header.php";

include_once('config.php');

if($_SESSION['role'] == 0){
    header("Location: http://news-site.test/admin/post.php");
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $fname = mysqli_real_escape_string($con, $_POST['f_name']);
    $lname = mysqli_real_escape_string($con, $_POST['l_name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $sql = "UPDATE user set first_name = '{$fname}', last_name = '{$lname}', username = '{$username}', role = '{$role}' where user.user_id = $user_id";

    if(mysqli_query($con, $sql)){
        header("Location: http://news-site.test/admin/users.php?page=1");
    }
    else{
        echo "<h2>Query Failed</h2>";
    }

    mysqli_close($con);
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <?php
                include_once('config.php');

                $user_id = $_REQUEST['id'];
                $sql = "SELECT * from user where user.user_id = $user_id";
                $result = mysqli_query($con, $sql) or die("Query Failed");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?PHP echo $row['user_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?PHP echo $row['first_name']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?PHP echo $row['last_name']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?PHP echo $row['last_name']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                                    <?php
                                    if ($row['role'] == 1) {
                                        echo "<option value='0'>normal User</option>
                                        <option value='1' selected>Admin</option>";
                                    } else {
                                        echo "<option value='0' selected>normal User</option>
                                        <option value='1'>Admin</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                <?php
                    }
                }
                ?>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>