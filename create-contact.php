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
$mainpage = 'contacts';
$page = 'create-contact';


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
              $company_id = htmlentities($_POST['company'], ENT_QUOTES);
              $rank= htmlentities($_POST['designation'], ENT_QUOTES);
              $linked_in = htmlentities($_POST['linkedin'], ENT_QUOTES);
              $fb = htmlentities($_POST['fbaccount'], ENT_QUOTES);
              $twitter = htmlentities($_POST['twitteracc'], ENT_QUOTES);
              $membership =$_POST['member'];
              $subscription= $_POST['subscription'];
              $date_subscribed= date("Y-m-d",strtotime($_POST['date-subscribed']));
              $status = 1;
              $today = date("F j, Y, g:i a");



              $sql ="INSERT INTO `sp_contacts`(`id`, `first_name`, `last_name`, `email_address`, `phone_no`, `company`, `designation`, `owner`,   `status`, `date_created`, `date_updated`, `modified_by`)".
                                    " VALUES (NULL,'$fname','$lname','$user_email','$user_number','$company_id','$rank','$user_id','$status','$today','$today','$user_id')";
              //posting to DB
              //posting to DB

              if(mysqli_query($connection, $sql) === TRUE) {
                  echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New contact created successfully
                                        </div>';
                  //insert to membership table

                  mysqli_query($connection,"INSERT INTO `contact_details`(`id`, `user_id`, `subscription`, `date_subscribed`, `membership`, `facebook`, `twitter`, `linkedin`) VALUES (NULL,LAST_INSERT_ID,'$subscription','$date_subscribed','$membership','$fb','$twitter','$linked_in')");
                   //update Log
                  $today = date("F j, Y, g:i a");
                  $ip=$_SERVER['REMOTE_ADDR'];
                  $activity = " Created New Contact".$fname." ".$lname;
                  mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                  $last_id = mysqli_insert_id($connection);
                  $status = 0;
                  //notification Count
                  //pick History ID / User Role / status =0 unread 1 - read / update on read
                  mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




              } else {
                  echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Adding New customer
                                        </div>';
              }
          }

          ?>


          <form role="form" method="post" action="" enctype="multipart/form-data">

              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">First Name</label>
                      <input type="text" name="f_name" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Lats Name</label>
                      <input type="text" name="l_name" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Designation / Rank</label>
                      <select name="designation" class="form-control select2">
                          <option selected disabled>Select Designation</option>
                          <?php
                          $role_query  = "select * from sp_designation ORDER BY id ASC";
                          $role_res    = mysqli_query($connection,$role_query);
                          $role_count  =   mysqli_num_rows($role_res);
                          while($role_row=mysqli_fetch_array($role_res)) {

                          $role_names = $role_row['role'];

                          $role_id = $role_row['id'];
                          ?>
                          <option value="<?php echo $role_id?>"><?php echo $role_names ?></option>
                          <?php }
                          ?>
                      </select>

                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Phone Number</label>
                      <input type="tel" name="phone_number" class="form-control" id="exampleInputEmail1" placeholder="+254700000000">
                  </div>
              </div>
              <div class="col-lg-4">

                  <div class="form-group">
                      <label for="Slide-title">Email Address</label>

                      <input class="form-control" type="email" name="email_add" placeholder="email@domain.com"/>

                  </div>
              </div>
              <div class="col-lg-4">

                  <div class="form-group">
                      <label for="Slide-title">Select Company</label>

                      <select class="form-control" name="company">
                          <option disabled selected>Select Company</option>
                          <?php
                          //select companies from DB
                          $company_query  = "select * from sp_company ORDER BY id ASC";
                          $company_res    = mysqli_query($connection,$company_query);
                          $company_count  =   mysqli_num_rows($company_res);
                          if (mysqli_num_rows($company_res) > 0) {

                          while($company_row=mysqli_fetch_array($company_res)) {


                          $company_names = $company_row['company_name'];
                          $company_id = $company_row['id'];
                          ?>
                          <option value="<?php echo $company_id ?>"><?php echo $company_names ?></option>

                              <?php

                          }
                          }
                          else {
                              echo '<option>No Records</option>';
                          }

                          ?>
                      </select>

                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="Slide-title">LinkedIn Account</label>
                      <input type="text" name="linkedin" class="form-control" id="exampleInputEmail1" placeholder="First & Last Name">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="Slide-title">Facebook Account</label>
                      <input type="text" name="fbaccount" class="form-control" id="exampleInputEmail1" placeholder="First & Last Name">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="Slide-title">Twitter Account</label>
                      <input type="text" name="twitteracc" class="form-control" id="exampleInputEmail1" placeholder="@twitter_username">
                  </div>
              </div>
               <div class="col-lg-4">
                   <div class="form-group">
                <label>Membership:</label>
                <div>
                  <label class="radio-inline">
                    <input type="radio" name="member" class="styled" checked="checked" value="1">
                    Member</label>
                  <label class="radio-inline">
                    <input type="radio" name="member" class="styled" value="0">
                    Not Member </label>
                </div>
              </div>
             
                   </div>
              
             
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Subscriptions</label>
                      <br>
                      <input type="checkbox" name="subscription" value="1">&nbsp;&nbsp;Yearly Subscription
                      
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Date Subscribed</label>
                      <div class="input-group date" data-provide="datepicker">
                          <input type="text" class="form-control" name="date-subscribed">
                          <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                          </div>
                      </div>

                  </div>
              </div>












              <div class="col-lg-12">
                  <button type="submit" name="save" class="btn btn-primary  btn-square pull-right">Submit</button>
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
        <script src="js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script>
            $('.datepicker').datepicker();
        </script>
    </body>
</html>

