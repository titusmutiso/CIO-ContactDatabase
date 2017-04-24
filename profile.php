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

//db config
require 'includes/config.php';
require 'user_profile.php';


//functions
require 'includes/functions.php';
//page name
$mainpage = 'profile';
$page = 'edit-profile';


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

                //script to save
                if (isset($_POST['save'])) {
                    // get the form data

                    $fname = htmlentities($_POST['f_name'], ENT_QUOTES);
                    $lname= htmlentities($_POST['l_name'], ENT_QUOTES);
                    $user_number = htmlentities($_POST['phone_number'], ENT_QUOTES);
                    $user_email = htmlentities($_POST['email_add'], ENT_QUOTES);

                    $user_desc = htmlentities($_POST['user_desc'], ENT_QUOTES);
                    $user_status = htmlentities($_POST['status'], ENT_QUOTES);
                    $user_role = htmlentities($_POST['role'], ENT_QUOTES);
                    //generated automatic
                    $username = strtolower($fname).".".strtolower($lname);
                    $password = md5($user_number);

                    //$user_logo = $_POST['user_avatar'];
                    //Images
                    //new code to upload image 1
                    if($_FILES["user_avatar"]["name"]!=''){
                        //image extensions
                        $allowed_extension = array("jpg","png");
                        $ext =end(explode('.',$_FILES["user_avatar"]["name"]));
                        if(in_array($ext,$allowed_extension)){

                            //check image size 10mb
                            if($_FILES["user_avatar"]["size"]<10000000){
                                $name = substr($fname, 0, 5).'-1'.'.'.$ext; //rename image
                                $user_logo= "uploads/users/".$name; //image path
                                move_uploaded_file($_FILES["user_avatar"]["tmp_name"],$user_logo);
                                //after upload
                                // header("Location:index.php?file-name=".$name."");





                            }else{
                                echo '<script>alert("Image Too Large")</script>';
                            }

                        }else{
                            echo '<script>alert("Invalid Image Extension")</script>';

                        }



                    }else{
                        echo '<script>alert("Please Select Image 1")</script>';
                    }

                    //posting to DB
                   $sql="UPDATE `sp_users` SET `first_name`='$fname',`last_name`='$lname',`phone_no`='$user_number',`user_img`='$user_logo' WHERE id='$user_id'";
                    if(mysqli_query($connection, $sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Update Successful
                                        </div>';
                        //update Log
                        $today = date("F j, Y, g:i a");
                        $ip=$_SERVER['REMOTE_ADDR'];
                        $activity = " Edited Profile";
                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                        $last_id = mysqli_insert_id($connection);
                        $status = 0;
                        //notification Count
                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                    } else {
                        echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Updating
                                        </div>';
                    }
                }

                ?>


                <form role="form" method="post" action="" enctype="multipart/form-data">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Username</label>
                            <input type="text" name="username" class="form-control" id="exampleInputEmail1" value="<?php echo $profile_username ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">First Name</label>
                            <input type="text" name="f_name" class="form-control" id="exampleInputEmail1" value="<?php echo $first_name ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Lats Name</label>
                            <input type="text" name="l_name" class="form-control" id="exampleInputEmail1" value="<?php echo $last_name ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" id="exampleInputEmail1" value="<?php echo $profile_phone ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label for="Slide-title">Email Address</label>

                            <input class="form-control" type="email" name="email_add" value="<?php echo $profile_email ?>"/>

                        </div>
                    </div>



                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Employee Image</label>
                            <input type="file" id="exampleInputFile" name="user_avatar" value="<?php echo $profile_image ?>" class="form-control">
                            <p class="help-block">Image Size Here (200 x 200)</p>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <p class="help-block">Image Size Here (200 x 200)</p>
                            <img src="<?php echo $profile_image ?>" class="img-responsive" width="200" height="200">
                        </div>
                    </div>



                    <div class="col-lg-12">
                        <button type="submit" name="save" class="btn btn-primary  btn-square pull-right">Update</button>
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

