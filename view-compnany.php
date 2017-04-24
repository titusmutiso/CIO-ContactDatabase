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
        //comapny Name
        $company_query= mysqli_query($connection,"SELECT * FROM sp_company WHERE id='$get_id'");
        $company_row = mysqli_fetch_array($company_query);
        
        //list of variables
        $co_name = $company_row['company_name'];
        $co_industry = $company_row['industry_id'];
        $co_email= $company_row['email_address'];
        $co_phone = $company_row['phone_number'];
        $co_landline= $company_row['landline'];
        $co_website = $company_row['website_url'];
        $co_address = $company_row['address'];
        $co_postal = $company_row['postal_code'];
        $co_city= $company_row['city'];
        $co_location= $company_row['location'];
        $co_logo= $company_row['logo'];

        //get industry
        $industry_query= mysqli_query($connection,"SELECT * FROM sp_industry WHERE id='$co_industry'");
        $industry_row = mysqli_fetch_array($industry_query);

        //industry Name
      $industry_name = $industry_row['industry_name'];

        //select Countries from a CompanyDetails & Country Table,
        $more_details = mysqli_query($connection,"SELECT * FROM company_details WHERE company_id='$get_id'");
        while($more_row = mysqli_fetch_array($more_details)){
            $countr_id = $more_row['country_id'];
            $cou_query= mysqli_query($connection,"SELECT * FROM sp_countries WHERE id='$countr_id'");
            $row_cou = mysqli_fetch_array($cou_query);


             $co_countries = $row_cou['country_name'];
        }

        
        //select number of contact list
        $contact_query = mysqli_query($connection,"SELECT * FROM sp_contacts WHERE company='$get_id'");

        $contactCount = mysqli_num_rows($contact_query);
        while($contact_row = mysqli_fetch_array($contact_query)){
            //contact variables

             $fname = $contact_row['first_name'];
            $lname= $contact_row['last_name'];
            $email_add = $contact_row['email_address'];
            $phone_no= $contact_row['phone_no'];
            $designation= $contact_row['designation'];
            $membership = $contact_row['membership'];
            $subscription = $contact_row['subscription'];
            $linkedin = $contact_row['linkedin'];
            $twitter= $contact_row['twitter'];
            $facebook = $contact_row['facebook'];

            //pick Designation

            $role_query= mysqli_query($connection,"SELECT * FROM sp_designation WHERE id='$designation'");
            $role_row= mysqli_fetch_array($role_query);

            //
             $contact_role = $role_row['role'];
        }
//Tasks
        $task_query  = "select * from sp_tasks WHERE company='$get_id' ORDER BY id DESC";
        $task_res    = mysqli_query($connection,$task_query);
        $task_count  =   mysqli_num_rows($task_res);

        




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
                                if(empty($co_logo)){
                                    ?>

                                    <img alt="" src="http://static.bleacherreport.net/images/redesign/avatars/default-user-icon-profile.png">
                                    <?php

                                }else {
                                    ?>
                                    <img alt="" src="<?php echo $co_logo ?>">
                                    <?php
                                }
                                ?>

                            </div>
                            <div class="caption text-center">
                                <h6><?php echo $co_name ?> <small>

                                    </small></h6>
                                <div class="icons-group"> <a href="facebook.com/<?php ?>" target="_blank" title="Facebook" class="tip"><i class="icon-facebook"></i></a> <a href="https://twitter.com/<?php ?>" target="_blank" title="Twitter" class="tip"><i class="icon-twitter"></i></a> <a href="mailto:<?php ?>" title="Email Address" class="tip"><i class="icon-mail"></i></a> </div>
                            </div>
                        </div>
                        <div>
                            <h3>Contact Details</h3>
                            <div class="well">
                                <a href="mailto:<?php  echo $co_email; ?>"><?php  echo $co_email; ?></a>
                                <a href="tel:<?php echo $co_phone; ?>"><?php echo $co_phone; ?></a>
                                <a href="<?php echo $co_website;?>"><?php echo $co_website;?></a>
                                <h5>Postal Address </h5>
                                <?php echo $co_address."-".$co_postal;?><br>
                                <?php echo $co_city;?><br>

                                <?php echo $co_location ?>
                                <br>
                                <h5>Industry </h5>
                               <?php  //get industry
                                $industry_query= mysqli_query($connection,"SELECT * FROM sp_industry WHERE id='$co_industry'");
                                $industry_row = mysqli_fetch_array($industry_query);

                                //industry Name
                                echo $industry_name = $industry_row['industry_name'];

                                //select Countries from a CompanyDetails & Country Table,
                               ?>


                            <h5>Operations </h5>

                                <?php
                                $more_details = mysqli_query($connection,"SELECT * FROM company_details WHERE company_id='$get_id'");
                                while($more_row = mysqli_fetch_array($more_details)){
                                    $countr_id = $more_row['country_id'];
                                    $cou_query= mysqli_query($connection,"SELECT * FROM sp_countries WHERE id='$countr_id'");
                                    $row_cou = mysqli_fetch_array($cou_query);
?>

                                 <?php   echo  $co_countries = $row_cou['country_name'];

                                 ?><br>
                                <?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>



                </div>
                <?php
                //get contacts history update profile/password

                ?>
                <!-- /profile links -->
            </div>
            <div class="col-lg-10">
                <!-- Page tabs -->
                <div class="tabbable page-tabs">
                    <ul class="nav nav-pills nav-justified">

                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-paragraph-justify2"></i> Activity</a></li>
                           <li><a href="#tasks" data-toggle="tab"><i class="icon-settings"></i> Tasks <span class="label label-danger"><?php echo   $task_count ?></span></a></li>
                            <li><a href="#contacts" data-toggle="tab"><i class="ico-users"></i> Contacts <span class="label label-primary"><?php echo $contactCount ?></span></a></li>
                            <li><a href="#settings" data-toggle="tab"><i class="icon-cogs"></i> Update Profile</a></li>
                        </ul>

                    </ul>
                    <div class="tab-content">
                        <!-- First tab -->
                        <div class="tab-pane active fade in" id="activity">
                            <!-- Statistics -->
                            <div class="block">
                                <ul class="statistics list-justified">
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a> <strong>
                                                <?php echo $contactCount ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div>
                                        </div>
                                        <span>Contacts Registered</span> </li>
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-warning"><i class="icon-lock"></i></a> <strong>
                                                <?php// echo $history_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                        <span>Total logins</span> </li>


                                </ul>

                                <h6 class="heading-hr"><i class="icon-settings"></i> Activities</h6>
<!-- Activity Listing -->
                                <!-- Contacts (list) -->

                                <div class="" >
                                    <div class="chat">
                                                <?php
                                                //pick all activities from sp_activities
                                                $activity_query = mysqli_query($connection,"SELECT * FROM sp_activities WHERE company='$get_id'");

                                                $activityCount = mysqli_num_rows($activity_query);
                                                if ($activityCount > 0) {
                                                    while ($activity_row = mysqli_fetch_array($activity_query)) {
                                                        //variables
                                                        $activity_name = $activity_row['activity'];
                                                        $activity_owner = $activity_row['owner'];
                                                        $activity_dates = $activity_row['date_created'];


                                                        //get responded
                                                        //pick user names here
                                                        $user_query = mysqli_query($connection, "SELECT * FROM sp_users WHERE id='$activity_owner'");
                                                        $user_row = mysqli_fetch_array($user_query);

                                                        $owner = $user_row['username'];


                                                        ?>
                                                        <div class="message"><a class="message-img" href="#"><i
                                                                        class="fa fa-user fa-3x"></i></a>
                                                            <div class="message-body"><span
                                                                        class="attribution"><?php echo $owner ?></span><br><?php echo $activity_name ?>
                                                                <span class="attribution"><?php echo $activity_dates ?>
                                                                    Hrs</span></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }else{
                                                    echo 'No Activities Yet';
                                                }
                                                ?>


                                    </div>


                                    <?php
                                    //echo $date = date('D , j F Y -  H:i');
                                    //save in DB
                                    if(isset($_POST['activity'])){

                                        $activity_msg = $_POST['enter-message'];
                                        $date = $date = date('D , j F Y -  H:i');
                                        $user_id;

                                        //Insert
                                        $sql= "INSERT INTO `sp_activities`(`id`, `activity`, `owner`,`company`, `date_created`)"
                                            ." VALUES (NULL,'$activity_msg','$user_id','$get_id','$date')";



                                        if(mysqli_query($connection, $sql) === TRUE) {
                                            echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Saved successfully
                                        </div><br>';


                                        } else {
                                            echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Saving
                                        </div><br>';
                                        }



                                    }

                                    //Pick current user ID



                                    ?>
                                    <form method="Post" action="">
                                        <textarea name="enter-message" class="form-control" rows="3" cols="1" placeholder="Enter your Activity..." required></textarea>
                                        <div class="message-controls">
                                            <div class="pull-right">

                                                <button type="submit" name="activity" class="btn btn-danger btn-loading" data-loading-text="<i class='icon-spinner7 spin'></i> Processing">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- /statistics -->


                        </div>
                        <!-- /first tab -->

                        <div class="tab-pane fade" id="tasks">
                            <!-- Profile information -->
                            <div class="block">
                                <ul class="statistics list-justified">
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a> <strong>
                                                <?php echo $contactCount ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div>
                                        </div>
                                        <span>Contacts Registered</span> </li>
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-warning"><i class="icon-lock"></i></a> <strong>
                                                <?php// echo $history_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                        <span>Total logins</span> </li>


                                </ul>

                                <h6 class="heading-hr"><i class="icon-settings"></i> Tasks</h6>

                                <div class="block">
                                    <h6 class="heading-hr"><i class="icon-settings"></i> My Tasks</h6>
                                    <div class="datatable-tasks">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Task Description</th>
                                                <th class="task-priority">Priority</th>
                                                <th class="task-date-added">Date Added</th>
                                                <th class="task-progress">Progress</th>
                                                <th class="task-deadline">Deadline</th>
                                                <th class="task-tools text-center">Tools</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            //all tasks Associated with this contact by all users if user ADMIN


                                            if (mysqli_num_rows($task_res) > 0) {

                                            while($task_row=mysqli_fetch_array($task_res)) {
                                            //variables Here
                                                $task_name = $task_row['task_name'];
                                                $task_desc = $task_row['task_desc'];
                                                $task_priority = $task_row['priority'];
                                                $task_status = $task_row['status'];
                                                $task_progress = $task_row['percentage'];
                                                $task_owner = $task_row['owner'];
                                                $task_start = $task_row['start_date'];
                                                $task_end = $task_row['end_date'];

                                                //pick user names here
                                                $users_query= mysqli_query($connection,"SELECT * FROM sp_users WHERE id='$task_owner'");
                                                $users_row = mysqli_fetch_array($users_query);

                                                $owner_name = $users_row['username'];

                                                //status defination 1-completed, 0- ongoing
                                                if($task_status==1){
                                                  $status ='Completed';
                                                }else{
                                                    $status ='Ongoing';
                                                }


                                                //priority - 0-Low, 1-Normal, 2-Highest
                                                if($task_priority ==0){
                                                    $priority ='<span class="label label-info">Low</span>';
                                                }else if($task_priority ==1){
                                                    $priority ='<span class="label label-success">Normal</span>';
                                                }else{
                                                    $priority ='<span class="label label-danger">High</span>';
                                                }
                                                ?>
<!-- table-->
                                                <tr>
                                                    <td class="task-desc"><a href="view-task"><?php echo $task_name ?></a> <span> <?php echo $task_desc ?></span></td>
                                                    <td class="text-center"><?php echo $priority ?></td>
                                                    <td><?php echo $task_start?></td>
                                                    <td><div class="progress progress-micro">
                                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $task_progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"><span class="sr-only"><?php echo $task_progress ?>% Complete</span></div>
                                                        </div></td>
                                                    <td><i class="icon-clock"></i> <strong class="text-danger"><?php echo  $owner_name ?></strong> </td>
                                                    <td class="text-center"><div class="btn-group">
                                                            <button type="button" class="btn btn-icon btn-success dropdown-toggle" data-toggle="dropdown"><i class="icon-cog4"></i></button>
                                                            <ul class="dropdown-menu icons-right dropdown-menu-right">
                                                                <li><a href="#"><i class="icon-quill2"></i> Edit task</a></li>
                                                                <li><a href="#"><i class="icon-share2"></i> Reassign</a></li>
                                                                <li><a href="#"><i class="icon-checkmark3"></i> Complete</a></li>
                                                                <li><a href="#"><i class="icon-stack"></i> Archive</a></li>
                                                            </ul>
                                                        </div></td>
                                                </tr>


                                            <?php

                                            }
                                            }else{
                                                echo 'No Tasks';
                                            }
                                            ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <!-- /profile information -->
                        </div>
                        <!-- Fourth tab -->
                        <div class="tab-pane fade" id="contacts">
                            <!-- Profile information -->
                            <div class="block">
                                <ul class="statistics list-justified">
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a> <strong>
                                                <?php echo $contactCount ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div>
                                        </div>
                                        <span>Contacts Registered</span> </li>
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-warning"><i class="icon-lock"></i></a> <strong>
                                                <?php// echo $history_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                        <span>Total logins</span> </li>


                                </ul>

                                <h6 class="heading-hr"><i class="icon-settings"></i> Activities</h6>

                                <div class="datatable">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" > </th>

                                            <th>Contact Name</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>

                                            <th>Title / Designation</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <?php
                                        $contacts_query  = "select * from sp_contacts WHERE company='$get_id' ";
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
                                                    <td><input type="checkbox" > </td>
                                                    <td><a href='view-contact?id=<?php echo $contacts_id ?>'><?php echo $contacts_names; ?></a></td>

                                                    <td ><a href="tel:<?php echo $contacts_phone; ?>"> <?php echo $contacts_phone; ?></a></td>
                                                    <td ><a href="mailto:<?php echo $contacts_email; ?>"> <?php echo $contacts_email; ?></a></td>

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
                            <!-- /profile information -->
                        </div>
                        <!-- /fourth tab -->
                        <!-- Fifth tab -->
                        <div class="tab-pane fade" id="settings">
                            <!-- Profile information -->
                            <div class="block">
                                <ul class="statistics list-justified">
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-success"><i class="icon-user-plus"></i></a> <strong>
                                                <?php echo $contactCount ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div>
                                        </div>
                                        <span>Contacts Registered</span> </li>
                                    <li>
                                        <div class="statistics-info"> <a href="#" title="" class="bg-warning"><i class="icon-lock"></i></a> <strong>
                                                <?php// echo $history_count ?>
                                            </strong> </div>
                                        <div class="progress progress-micro">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                        <span>Total logins</span> </li>


                                </ul>

                                <h6 class="heading-hr"><i class="icon-settings"></i> Activities</h6>
                                <form role="form" method="post" action="" enctype="multipart/form-data">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Company Name</label>
                                            <input type="text" name="co_name" class="form-control"  placeholder="Company Name" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">First Name</label>
                                            <select  name="co_industry" class="form-control" required="true">
                                                <option>Select Industry</option>
                                                <?php
                                                //list categories
                                                $industry_query  = "select * from sp_industry ORDER BY id ASC";
                                                $industry_res    = mysqli_query($connection,$industry_query);
                                                $industry_count  =   mysqli_num_rows($industry_res);
                                                if (mysqli_num_rows($industry_res) > 0) {

                                                    while($industry_row=mysqli_fetch_array($industry_res)) {


                                                        $industry_name = $industry_row['industry_name'];
                                                        $industry_id = $industry_row['id'];

                                                        ?>
                                                        <option value="<?php echo $industry_id ?>"><?php echo $industry_name ?></option>
                                                        <?php
                                                    }
                                                }  else {
                                                    echo '<option value=""><a href="create-industry.php">Add Industry</a> </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Country</label>


                                            <select  name="co_country[]" class="form-control selectpicker" required multiple data-live-search="true" >
                                                <option selected disabled>Select Country</option>
                                                <?php
                                                //list categories
                                                $country_query  = "select * from sp_countries ORDER BY id ASC";
                                                $country_res    = mysqli_query($connection,$country_query);
                                                $country_count  =   mysqli_num_rows($country_res);
                                                if (mysqli_num_rows($country_res) > 0) {

                                                    while($country_row=mysqli_fetch_array($country_res)) {


                                                        $country_name = $country_row['country_name'];
                                                        $country_id = $country_row['id'];

                                                        ?>
                                                        <option value="<?php echo $country_id ?>"><?php echo $country_name ?></option>
                                                        <?php
                                                    }
                                                }  else {
                                                    echo '<option>No Countries</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Email Address</label>
                                            <input type="email" name="co_email" class="form-control" id="exampleInputEmail1" placeholder="info@domain.name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Mobile Phone Number</label>
                                            <input type="text" name="co_phone" class="form-control" id="exampleInputEmail1" placeholder="+254 710 000 000">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Landline Number</label>
                                            <input type="text" name="co_landline" class="form-control" id="exampleInputEmail1" placeholder="+254(0) 2000000" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Address</label>
                                            <textarea name="co_address" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Postal Code</label>
                                            <input type="text" name="co_postalcode" class="form-control" id="exampleInputEmail1" placeholder="Postal Code">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">City</label>
                                            <input type="text" name="co_city" class="form-control" id="exampleInputEmail1" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Business Location</label>
                                            <input type="text" name="co_location" class="form-control" id="exampleInputEmail1" placeholder="E-Development House, Muthaiga" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="Slide-title">Website</label>
                                            <input type="url" name="co_website" class="form-control" id="exampleInputEmail1" placeholder="http://www.domain.name">
                                        </div>
                                    </div>








                                    <div class="col-lg-12">
                                        <button type="submit" name="save" class="btn btn-primary  btn-square pull-right">Save</button>
                                    </div>
                                </form>

                            </div>
                            <!-- /profile information -->
                        </div>
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

