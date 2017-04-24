<?php

/* 
 * To change this license header, choose License Headers in customerect Properties.
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
$mainpage = 'customers';
   $page = 'add-customer';


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
        <h6 class="panel-title">Add Customer</h6>
      </div>
      <div class="panel-body">
          <!--content here -->
          <?php
          //script to save
          if (isset($_POST['save'])) {
              // get the form data

              $customer_title = htmlentities($_POST['customer_name'], ENT_QUOTES);
              $customer_number = htmlentities($_POST['phone_number'], ENT_QUOTES);
              $customer_email = htmlentities($_POST['email_add'], ENT_QUOTES);
              $customer_postal = htmlentities($_POST['postal_code'], ENT_QUOTES);
              $customer_desc = htmlentities($_POST['comp_desc'], ENT_QUOTES);
              $customer_status = htmlentities($_POST['status'], ENT_QUOTES);
              $customer_address = htmlentities($_POST['address'], ENT_QUOTES);
              //$customer_logo = $_POST['company_logo'];
              //Images
              //new code to upload image 1
              if($_FILES["company_logo"]["name"]!=''){
                  //image extensions
                  $allowed_extension = array("jpg","png");
                  $ext =end(explode('.',$_FILES["company_logo"]["name"]));
                  if(in_array($ext,$allowed_extension)){

                      //check image size 10mb
                      if($_FILES["company_logo"]["size"]<10000000){
                          $name = substr($customer_title, 0, 5).'-1'.'.'.$ext; //rename image
                          $customer_logo= "uploads/customers/".$name; //image path
                          move_uploaded_file($_FILES["company_logo"]["tmp_name"],$customer_logo);
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
              $sql= "INSERT INTO `sp_clients`(`id`, `client_names`,`client_desc`,`clients_email`,`clients_phone`,`postal_code`,`address`,`logo`,`status`,`date_created`)"
                  ."VALUES (NULL,'$customer_title','$customer_desc','$customer_email','$customer_number','$customer_postal','$customer_address','$customer_logo','$customer_status',NOW())";




              if(mysqli_query($connection, $sql) === TRUE) {
                  echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New customer created successfully
                                        </div>';
                  //update Log
                  $today = date("F j, Y, g:i a");
                  $ip=$_SERVER['REMOTE_ADDR'];
                  $activity = " Edited <strong>".$customer_name."s</strong> to <strong>".$customer_title."</strong>";
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

              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="Slide-title">Customer Name</label>
                      <input type="text" name="customer_name" class="form-control" id="exampleInputEmail1" placeholder="Customer Title">
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="form-group">
                      <label for="Slide-title">Phone Number</label>
                      <input type="text" name="phone_number" class="form-control" id="exampleInputEmail1" placeholder="+254700000000">
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
                      <label for="Slide-title">Postal Code</label>

                          <input class="form-control" type="text" name="postal_code" placeholder="00100"/>

                  </div>
              </div>

              <div class="col-lg-6">


                  <div class="form-group">
                      <label for="Slide-desc">Company Address</label>
                      <textarea name="address" class="form-control" ></textarea>
                  </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                      <label>Company Description</label>
                      <textarea rows="5" cols="5" class="form-control" name="comp_desc"></textarea>
                  </div>
              </div>

              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                      <label for="Slide-desc">Status</label>
                      <select name="status" class="form-control">

                          <option value="1">Active</option>
                          <option value="0">Inactive</option>

                      </select>
                  </div>
              </div>

              <div class="col-lg-6">
                  <div class="form-group">
                      <label for="exampleInputFile">Company Logo</label>
                      <input type="file" id="exampleInputFile" name="company_logo" class="form-control">
                      <p class="help-block">Image Size Here (0 x 0)</p>
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
    </body>
</html>

