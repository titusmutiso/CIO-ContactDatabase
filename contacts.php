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
$mainpage = 'customers';
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
             <!-- Default panel -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h6 class="panel-title">Default panel</h6>
      </div>
      <div class="panel-body">
          <div class="table-responsive">

              <?php if($_SESSION['user']=="admin") { ?>
              <div class="datatable">
                  <table class="table table-striped table-bordered">
                      <thead>
                      <tr>
                          <th><input type="checkbox" > </th>

                          <th>Contact Name</th>
                          <th>Phone Number</th>
                          <th>Email</th>
                          <th>Company</th>
                          <th>Title / Designation</th>
                          <th>Actions</th>
                      </tr>
                      </thead>

                      <?php
                      $contacts_query  = "select * from sp_contacts WHERE status !=0  ORDER BY id ASC";
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

              <?php }else {?>
              <div class="datatable">
                  <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                      <th><input type="checkbox" > </th>

                      <th>Contact Name</th>
                      <th>Phone Number</th>
                      <th>Email</th>
                      <th>Company</th>
                      <th>Title / Designation</th>
                      <th>Actions</th>
                  </tr>
                  </thead>

                  <?php
                  $contacts_query  = "select * from sp_contacts WHERE owner='$user_id' ORDER BY id ASC";
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

                          $contacts_id = $contacts_row['id'];?>
                          <tr>
                              <td><input type="checkbox" > </td>
                              <td><a href='view-contact?id=<?php echo $contacts_id ?>'><?php echo $contacts_names; ?></a></td>

                              <td ><a href="tel:<?php echo $contacts_phone; ?>"> <?php echo $contacts_phone; ?></a></td>
                              <td ><a href="mailto:<?php echo $contacts_email; ?>"> <?php echo $contacts_email; ?></a></td>
                              <td ><?php echo $contacts_company; ?></td>
                              <td ><?php echo $contacts_designation; ?></td>

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
              <?php } ?>
          </div>


      </div>
    </div>
    <!-- /default panel -->
            
      <!--footer-->
<?php require 'includes/footer.php'; ?>      
  </div>      
  </div>
        
        <!-- end Page container -->
        <!--JS-->
        <!-- end Page container -->
        <!--JS-->
        <?php require 'includes/js.php';?>
        <script>
            //DataTables Initialization
            $(document).ready(function() {
                $('#example-table').dataTable();
            });
            $(document).ready(function() {
                $('#ongoing-table').dataTable();
            });
            $(document).ready(function() {
                $('#completed-table').dataTable();
            });

        </script>
    </body>
</html>

