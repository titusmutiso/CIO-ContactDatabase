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
              <table id="example-table" class="table table-striped">
                  <thead>
                  <tr>
                      <th><input type="checkbox" > </th>

                      <th>Customer Name</th>
                      <th>Customer Logo</th>
                      <th>Phone Number</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Actions</th>
                  </tr>
                  </thead>

                  <?php
                  $clients_query  = "select * from sp_clients WHERE status !=0";
                  $clients_res    = mysqli_query($connection,$clients_query);
                  $clients_count  =   mysqli_num_rows($clients_res);

                  ?>
                  <?php
                  if (mysqli_num_rows($clients_res) > 0) {

                      while($clients_row=mysqli_fetch_array($clients_res)) {

                          $clients_image = $clients_row['logo'];
                          $clients_names = $clients_row['client_names'];
                          //$clients_role = $clients_row['role'];
                          $clients_status = $clients_row['status'];
                          $clients_phone= $clients_row['clients_phone'];
                          $clients_email= $clients_row['clients_email'];

                          $clients_id = $clients_row['id'];?>
                          <tr>
                              <td><input type="checkbox" > </td>
                              <td><a href='view-customer?id=<?php echo $clients_id ?>'><?php echo $clients_names; ?></a></td>
                              <td><a href='view-customer?id=<?php echo $clients_id ?>'><img src="<?php echo $clients_image; ?>" class="responsive" width="100" height="100"/></a></td>
                              <td ><a href="tel:<?php echo $clients_phone; ?>"> <?php echo $clients_phone; ?></a></td>
                              <td ><a href="mailto:<?php echo $clients_email; ?>"> <?php echo $clients_email; ?></a></td>
                              <td ><?php if($clients_status==1){
                                      echo'<span class="label label-success">Active</span>';

                                  }else{
                                      echo'<span class="label label-danger">suspended</span>';
                                  } ?></td>
                              <td width="15%"><div class="btn-group"><a href='edit-customer?id=<?php echo $clients_id ?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                                      &nbsp;<a href='delete?id=<?php echo $clients_id ?>&type=customers' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                      <a href='view-customer?id=<?php echo $clients_id ?>' class="btn btn-success btn-xs" data-toggle="tooltip" title="View Project" data-placement="top" ><i class="fa fa-eye"></i></a>
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

