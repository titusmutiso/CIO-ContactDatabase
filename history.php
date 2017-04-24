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
          <div class="datatable">
              <table class="table table-striped table-bordered">
                  <thead>
                  <tr>

                      <th>Username</th>
                      <th>Activity</th>
                      <th>Activity Time</th>
                      <th>IP Address</th>

                  </tr>
                  </thead>

                  <?php
                  $history_query  = "select * from sp_log ORDER BY id DESC";
                  $history_res    = mysqli_query($connection,$history_query);
                  $history_count  =   mysqli_num_rows($history_res);

                  ?>
                  <?php
                  if (mysqli_num_rows($history_res) > 0) {

                      while($history_row=mysqli_fetch_array($history_res)) {

                          $last_login = $history_row['last_login'];
                          $user = $history_row['user_id'];
                          $activity= $history_row['activity'];
                          $ip = $history_row['ip_address'];

                          //select Username from Users table
                          $user_query  = "select * from sp_users WHERE id = '$user'";
                          $user_res    = mysqli_query($connection,$user_query);
                          $user_row=mysqli_fetch_array($user_res);


                          $user_username= $user_row['username'];


                          $history_id = $history_row['id'];?>
                          <tr>
                              <td><a href='view_user?id=<?php echo $user ?>'><?php echo $user_username; ?></a></td>
                              <td><?php echo $activity; ?></td>
                              <td > <?php echo $last_login; ?></td>
                              <td > <?php echo $ip; ?></td>


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

