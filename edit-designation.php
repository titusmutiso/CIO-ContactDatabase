<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//session
session_start();
if(!isset($_SESSION['login_user']))
{
    header("Location: index");
}
$login_session=$_SESSION['login_user'];
$user_id = $_SESSION['id'];
//get id
$get_id = $_GET['id'];
//db config
require 'includes/config.php';
require 'user_profile.php';
//functions
require 'includes/functions.php';
//page name
$mainpage ='';
$page = 'dashboard';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    //header
    require 'includes/header.php';
    //css
    require 'includes/css.php';

    ?>
</head>
<body class="sidebar-wide">
<!--navigation-->
<?php
//top navigation
require 'includes/top-menu.php';

?>
<!-- Page container -->
<div class="page-container">
    <!-- side bar-->
    <?php require 'includes/side-menu.php'; ?>
    <!--ennd of side bar-->
    <!-- Page content -->
    <div class="page-content">
        <!-- Page header -->
        <?php require 'includes/breadcrumb.php'; ?>
        <!-- end Page header-->
        <!-- Default panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Default panel</h6>
            </div>
            <div class="panel-body">
                <?php
                //select from DB
                $role_query ="SELECT * FROM sp_designation WHERE id='$get_id'";
                $role_result = mysqli_query($connection,$role_query);
                $role_row = mysqli_fetch_array($role_result);

                $design_name = $role_row['role'];

                if (isset($_POST['save'])) {
                    // get the form data

                    $role_name = $_POST['role'];
                    $sql= "UPDATE `sp_designation` SET `role` ='$role_name', `date_created`=NOW() WHERE id='$get_id'";
                    if(mysqli_query($connection, $sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        echo $role_name ;
                        echo' &nbsp; &nbsp;Updated successfully
                  </div>';
                        //update Log
                        $today = date("F j, Y, g:i a");
                        $ip=$_SERVER['REMOTE_ADDR'];
                        $activity = " Edited <strong>".$design_name."s</strong> to <strong>".$role_name."</strong>";
                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                        $last_id = mysqli_insert_id($connection);
                        $status = 0;
                        //notification Count
                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                    } else {
                        echo '<div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Error while Adding  &nbsp; &nbsp;';
                        echo $role_name ;
                        echo'
                  </div>';
                    }
                }
                ?>
                <!--add form without refresh-->
                <form class="" method="POST" action="">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Slide-title">Designation /Role</label>
                            <input class="form-control" name="role" type="text" value="<?php echo  $design_name  ?>" id="role" required>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" name="save" id="send" class="btn btn-primary  btn-square pull-right">Submit</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- /default panel -->

        <!--footer-->
        <?php require 'includes/footer.php'; ?>
    </div>
</div>

<!-- end Page container -->
<!--JS-->
<?php require 'includes/js.php';?>
</body>
</html>

