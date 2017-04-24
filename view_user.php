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
        $users_query  = "select * from sp_users WHERE id ='$get_id'";
        $users_res    = mysqli_query($connection,$users_query);
        $users_count  =   mysqli_num_rows($users_res);
        $users_row=mysqli_fetch_array($users_res);
        $users_image = $users_row['user_img'];
        $users_names = $users_row['first_name']." ". $users_row['last_name'];
        $users_role = $users_row['role'];
        $users_status = $users_row['status'];
        $users_phone= $users_row['phone_no'];
        $users_fname= $users_row['first_name'];
        $users_lname= $users_row['last_name'];
        $users_email= $users_row['email_add'];

        $users_id = $users_row['id']

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
                                <h6><?php echo $users_names ?> <small>
                                        <?php
                                        if($users_role==1){
                                    echo'Admin';
                                        }else{
                                           echo'User';
                                        } ?>
                                    </small></h6>
                                <div class="icons-group"> <a href="#" title="Google Drive" class="tip"><i class="icon-google-drive"></i></a> <a href="#" title="Twitter" class="tip"><i class="icon-twitter"></i></a> <a href="#" title="Github" class="tip"><i class="icon-github3"></i></a> </div>
                            </div>
                        </div>
                    </div>



                </div>
                <?php
                //get contacts history update profile/password
                $contacts_query ="SELECT * FROM `sp_contacts` WHERE owner='$get_id'";
                $contacts_res    = mysqli_query($connection,$contacts_query);
                $contacts_row=mysqli_fetch_array($contacts_res);
                //contacts count
                $contacts_count = mysqli_num_rows($contacts_res);
                
                //login Counts
                $history_query  = "select * from sp_log WHERE user_id='$get_id'";
                $history_res    = mysqli_query($connection,$history_query);
                $history_count  =   mysqli_num_rows($history_res);
                
                
                $contacts_image = $contacts_row['profile_image'];
                $contacts_names = $contacts_row['first_name']." ".$contacts_row['last_name'];
                $contacts_phone= $contacts_row['phone_no'];
                $contacts_email= $contacts_row['email_address'];
                $contacts_company= $contacts_row['company'];
                $contacts_designation= $contacts_row['designation'];
                $contacts_industry= $contacts_row['industry'];
                $contacts_profile= $contacts_row['designation'];
                ?>
                <!-- /profile links -->
            </div>
            <div class="col-lg-10">
                <!-- Page tabs -->
                <div class="tabbable page-tabs">
                    <ul class="nav nav-pills nav-justified">

                        <li><a href="#contacts" data-toggle="tab" class="active"><i class="icon-stats2"></i> Contacts Reports </a></li>
                         <li><a href="#update-profile" data-toggle="tab"><i class="icon-cogs"></i> Update Profile</a></li>


                    </ul>
                    <div class="tab-content">
                        <!-- First tab -->
                        <div class="tab-pane active fade in" id="contacts">
                            <!-- Statistics -->
                            <div class="block">
                                <ul class="statistics list-justified">
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a> <strong>
                                                <?php echo $contacts_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div>
                                        </div>
                                        <span>Contacts Registered</span> </li>
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-warning"><i class="icon-lock"></i></a> <strong>
                                                <?php echo $history_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                        <span>Total logins</span> </li>

                                    
                                </ul>

                                    <h6 class="heading-hr"><i class="icon-settings"></i> My Contacts</h6>
                                <div class="datatable">
                                    <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>


                                                <th>Contact Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Company</th>
                                                <th>Title / Designation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                        <tbody>
                                        <?php
                                        $contacts_query  = "select * from sp_contacts WHERE owner='$get_id' ORDER BY id ASC";
                                        $contacts_res    = mysqli_query($connection,$contacts_query);
                                        $contacts_count  =   mysqli_num_rows($contacts_res);

                                        ?>
                                        <?php
                                        if (mysqli_num_rows($contacts_res) > 0) {

                                            while($contacts_row=mysqli_fetch_array($contacts_res)) {

                                                $contacts_image = $contacts_row['profile_image'];
                                                $contacts_names = $contacts_row['first_name']." ".$contacts_row['last_name'];
                                                //$contacts_role = $contacts_row['role'];
                                                //$contacts_status = $contacts_row['status'];
                                                $contacts_phone= $contacts_row['phone_no'];
                                                $contacts_email= $contacts_row['email_address'];
                                                $contacts_company= $contacts_row['company'];
                                                $contacts_designation= $contacts_row['designation'];

                                                $contacts_id = $contacts_row['id'];
                                                //select from companies for company name
                                                $company_query  = "select * from sp_company WHERE id ='$contacts_company'";
                                                $company_res    = mysqli_query($connection,$company_query);
                                                $company_row=mysqli_fetch_array($company_res);
                                                $company_names = $company_row['company_name'];
                                                //pick from designation
                                                $role_query  = "select * from sp_designation WHERE id='$contacts_designation'";
                                                $role_res    = mysqli_query($connection,$role_query);
                                                $role_row=mysqli_fetch_array($role_res);

                                                $role_name = $role_row['role'];




                                                ?>

                                                <tr>

                                                    <td><a href='view-contact?id=<?php echo $contacts_id ?>'><?php echo $contacts_names; ?></a></td>

                                                    <td ><a href="tel:<?php echo $contacts_phone; ?>"> <?php echo $contacts_phone; ?></a></td>
                                                    <td ><a href="mailto:<?php echo $contacts_email; ?>"> <?php echo $contacts_email; ?></a></td>
                                                    <td ><?php echo $company_names; ?></td>
                                                    <td ><a href="all-designation?id=<?php echo $contacts_designation ?>"><?php echo $role_name; ?></a></td>

                                                    <td width="15%"><div class="btn-group"><a href='edit-contact?id=<?php echo $contacts_id ?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                                                            &nbsp;<a href='delete?id=<?php echo $contacts_id ?>&type=contact' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                                            <a href='view-contact?id=<?php echo $contacts_id ?>' class="btn btn-success btn-xs" data-toggle="tooltip" title="View Project" data-placement="top" ><i class="fa fa-eye"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>


                                            <?php }
                                        }  else {
                                            echo 'No Records';
                                        }

                                        ?>
                                        </tbody>
                                    </table>


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

