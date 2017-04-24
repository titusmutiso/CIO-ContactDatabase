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
                <h6 class="panel-title">Update Industry</h6>
                <span class="pull-right">
                    <a href="industries" class="btn btn-primary">Back To Industries</a>
                </span>
            </div>
            <div class="panel-body">
                <?php
                //select from DB
                $indus_query ="SELECT * FROM sp_industry WHERE id='$get_id'";
                $indus_result = mysqli_query($connection,$indus_query);
                $indus_row = mysqli_fetch_array($indus_result);

                $indus_name = $indus_row['industry_name'];

                if (isset($_POST['save'])) {
                    // get the form data

                    $industry_name = $_POST['industry_name'];
                    $sql= "UPDATE `sp_industry` SET `industry_name`='$industry_name',`date_created`=NOW() WHERE id='$get_id'";
                    if(mysqli_query($connection, $sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        echo '<strong>'.$indus_name.'</strong>';
                        echo' &nbsp; &nbsp;Was Updated successfully to &nbsp; &nbsp;<strong>' .$industry_name.' </strong>
                  </div>';

                        //user Log
                        $today = date("F j, Y, g:i a");
                        $ip=$_SERVER['REMOTE_ADDR'];
                        $activity = "Updated Industry <strong>".$indus_name."</strong> to <strong>".$industry_name."</strong>";
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
                        echo $indus_name ;
                        echo'
                  </div>';
                    }
                }
                ?>
                <!--add form without refresh-->
                <form class="" method="POST" action="">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Slide-title">New Industry</label>
                            <input class="form-control" name="industry_name" type="text" value="<?php echo  $indus_name?>" id="industry_name" required>
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

