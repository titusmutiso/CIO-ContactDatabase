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
//contact id
$get_id = $_GET['id'];
//db config
require 'includes/config.php';
require 'user_profile.php';


//functions
require 'includes/functions.php';
//page name
$mainpage ='customers';
$page = 'customers';

//contact Details
$contacts_query ="SELECT * FROM `sp_contacts` WHERE owner='$get_id'";
$contacts_res    = mysqli_query($connection,$contacts_query);
$contacts_row=mysqli_fetch_array($contacts_res);
//contacts count
$contacts_count = mysqli_num_rows($contacts_res);
$contacts_image = $contacts_row['profile_image'];
$contacts_names = $contacts_row['first_name']." ".$contacts_row['last_name'];
$contacts_phone= $contacts_row['phone_no'];
$contacts_email= $contacts_row['email_address'];
$contacts_company= $contacts_row['company'];
$contacts_designation= $contacts_row['designation'];
$contacts_industry= $contacts_row['industry'];
$contacts_profile= $contacts_row['designation'];
$contacts_owner= $contacts_row['owner'];

//owner
$owner_query  = "select * from sp_users WHERE id='$contacts_owner'";
$owner_res    = mysqli_query($connection,$owner_query);
$owner_row=mysqli_fetch_array($owner_res);

$owner_name = $owner_row['username'];

//company
$com_query  = "select * from sp_company WHERE id='$contacts_company'";
$com_res    = mysqli_query($connection,$com_query);
$com_row=mysqli_fetch_array($com_res);

$com_name = $com_row['company_name'];
$com_indu = $com_row['industry_id'];

//Designation
$design_query  = "select * from sp_designation WHERE id='$contacts_designation'";
$design_res    = mysqli_query($connection,$design_query);
$design_row=mysqli_fetch_array($design_res);

$design_name = $design_row['role'];

//industry
$industry_query  = "select * from sp_industry WHERE id='$com_indu'";
$industry_res    = mysqli_query($connection,$industry_query);
$industry_row=mysqli_fetch_array($industry_res);

$industry_name = $industry_row['industry_name'];

//membership
$member_query  = "select * from contact_details WHERE user_id='$get_id'";
$member_res    = mysqli_query($connection,$member_query);
$member_row=mysqli_fetch_array($member_res);

$member_name = $member_row['membership'];
$subscription = $member_row['subscription'];
$fb = $member_row['facebook'];
$twitter = $member_row['twitter'];
$linkedin = $member_row['linkedin'];
$date_subscribed = $member_row['date_subscribed'];

//linked in


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
        <?php


        ?>
        <!-- Default panel -->
        <!-- Profile grid -->
        <div class="row">
            <div class="col-lg-2">
                <!-- Profile links -->
                <div class="block">
                    <div class="block">
                        <div class="thumbnail">
                            <div class="thumb">
                                <?php
                                if(empty($users_image)){
                                    ?>

                                    <img alt="" src="http://static.bleacherreport.net/images/redesign/avatars/default-user-icon-profile.png">
                                    <?php

                                }else {
                                    ?>
                                    <img alt="" src="<?php echo $users_image ?>">
                                    <?php
                                }
                                ?>

                            </div>
                            <div class="caption text-center">
                                <h6><?php echo $contacts_names ?> <small>

                                    </small></h6>
                                <div class="icons-group">
                                    <a href="https://www.facebook.com/<?php echo $fb ?>" target="_blank" title="Facebook" class="tip"><i class="icon-facebook"></i></a> <a target="_blank" href="https://www.twitter.com/<?php echo $twitter ?>" title="Twitter" class="tip"><i class="icon-twitter"></i></a> <a target="_blank" href="https://www.linkedin.com/<?php echo $linkedin ?>" title="Linked In" class="tip"><i class="icon-linkedin"></i></a> </div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- /profile links -->
            </div>
            <div class="col-lg-10">
                <!-- Page tabs -->
                <div class="tabbable page-tabs">
                    <ul class="nav nav-pills nav-justified">

                        <li><a href="#contacts" data-toggle="tab" class="active"><i class="icon-stats2"></i> Contact Detail </a></li>
                        <li><a href="#update-profile" data-toggle="tab"><i class="icon-cogs"></i> Update Profile</a></li>


                    </ul>
                    <div class="tab-content">
                        <!-- First tab -->
                        <div class="tab-pane active fade in" id="contacts">
                            <!-- Statistics -->
                            <div class="block">


                                <h6 class="heading-hr"><i class="icon-settings"></i> Contact Details</h6>

                                <?php
                                //subscription
                                //owned by
                                //company
                                //title

                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-condensed table-bordered table-responsive">
                                            <tr>
                                                <td>Names</td>
                                                <td><?php echo  $contacts_names  ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><?php echo  $contacts_email ?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td><?php echo $contacts_phone ?></td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td><?php echo  $design_name ?></td>
                                            </tr>
                                            <tr>
                                                <td>Company</td>
                                                <td><?php echo  $com_name ?></td>
                                            </tr>
                                            <tr>
                                                <td>Industry</td>
                                                <td><?php echo $industry_name ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-condensed table-bordered table-responsive">
                                            <tr>
                                                <td>Owned By</td>
                                                <td><?php echo $owner_name ?></td>
                                            </tr>
                                            <tr>
                                                <td>Subscription</td>
                                                <td><?php
                                                    if($subscription ==2) {
                                                        echo 'Monthly';

                                                    }else{
                                                        echo 'Yearly Subscription';
                                                    }
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td>Date Subscribed</td>
                                                <td><?php echo  $date_subscribed ?></td>
                                            </tr>
                                            <tr>
                                                <td>Membership</td>
                                                <td>
                                                    <?php
                                                    if($member_name ==1){
                                                        echo'Member';
                                                    }else{
                                                        echo'Not registered';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <h3>Profile from LinkedIn</h3>
                                        <?php
                                        //linked in thru Email
                                        ?>
                                        </p>
                                    </div>
                                </div>


                            </div>
                            <!-- /statistics -->


                        </div>
                        <!-- /first tab -->

                        <div class="tab-pane fade" id="update-profile">
                            <!-- Profile information -->
                            <form action="#" class="block" role="form">
                                <h6 class="heading-hr"><i class="icon-user"></i> Profile information:</h6>
                                <div class="block-inner">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>First name</label>
                                                <input type="text" name="fname" class="form-control" id="exampleInputEmail1" value="<?php echo $users_fname ?>" >
                                            </div>
                                            <div class="col-md-6">
                                                <label>Last name</label>
                                                <input type="text" name="lname"  class="form-control" value="<?php echo $users_lname ?>">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone #</label>
                                                <input type="text"  name="phone" value="<?php echo $users_phone ?>" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Email Address:</label>
                                                <input class="form-control" type="email" name="email_add" value="<?php echo $users_email ?>"/>

                                            </div>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['user']=="admin") { ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label for="Slide-title">Privilege / Role</label>

                                                    <select class="form-control" name="role">
                                                        <option value="<?php echo $users_role ?>" selected>
                                                            <?php
                                                            if($users_role==1){
                                                                echo 'Super Admin';
                                                            }else{
                                                                echo 'User';
                                                            }

                                                            ?>

                                                        </option>
                                                        <option disabled>Select Role</option>

                                                        <option value="2">User</option>
                                                        <option value="1">Super Admin</option>
                                                    </select>

                                                </div>
                                            </div>




                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="Slide-desc">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="<?php echo $users_status ?>" selected><?php
                                                            if($users_status ==1){
                                                                echo'Active';
                                                            }else{
                                                                echo'Inactive';
                                                            }
                                                            ?></option>
                                                        <option value="">Select Status</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="form-group">
                                            <div clas="row">
                                                <div class="col-lg-6">

                                                    <label for="exampleInputFile">Employee Image</label>
                                                    <input type="file" id="exampleInputFile" name="user_avatar" value="<?php echo $users_image ?>" class="form-control">
                                                    <p class="help-block">Image Size Here (200 x 200)</p>

                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <p class="help-block">Image Size Here (200 x 200)</p>
                                                        <img src="<?php echo $users_image ?>" class="img-responsive" width="200" height="200">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="text-right">
                                                <input type="reset" value="Cancel" class="btn btn-default">
                                                <input type="submit" value="Apply changes" class="btn btn-success">
                                            </div>
                            </form>
                            <!-- /profile information -->
                        </div>
                        <!-- Fourth tab -->

                        <!-- /fourth tab -->
                        <!-- Fifth tab -->

                        <!-- /fifth tab -->
                    </div>

                    <!-- /page tabs -->
                </div>
            </div>

            <!-- /profile grid -->

            <!--footer-->
            <?php require 'includes/footer.php'; ?>
        </div>
    </div>

    <!-- end Page container -->
    <!--JS-->
    <?php require 'includes/js.php';?>
</body>
</html>

