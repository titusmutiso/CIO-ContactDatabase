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
//industry ID
$get_id = $_GET['id'];
//db config
require 'includes/config.php';
require 'user_profile.php';


//functions
    require 'includes/functions.php';
//page name
$mainpage = 'customers';
$page = 'customers';


?>
<?php
$company_query  = "select * from sp_company WHERE WHERE status !=0 AND industry_id='$get_id' ORDER BY id ASC";
$company_res    = mysqli_query($connection,$company_query);
$company_count  =   mysqli_num_rows($company_res);


$industry_query  = "select * from sp_industry WHERE  WHERE status !=0 AND id ='$get_id'";
$industry_res    = mysqli_query($connection,$industry_query);
$industry_row=mysqli_fetch_array($industry_res);

$industry_names = $industry_row['industry_name'];
$industry_id = $industry_row['id'];
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
        <h6 class="panel-title"><?php echo  $company_count ?> Results in <?php echo  $industry_names ?></h6>
      </div>
      <div class="panel-body">
          <div class="table-responsive">

                  <table id="example-table" class="table table-striped">
                      <thead>
                      <tr>
                          <th><input type="checkbox" > </th>

                          <th>Company Name</th>
                          <th>Phone Number</th>
                          <th>Email</th>
                          <th>Industry</th>
                          <th>Location</th>
                          <th>Country</th>
                          <th>Actions</th>
                      </tr>
                      </thead>


                      <?php
                      if (mysqli_num_rows($company_res) > 0) {

                          while($company_row=mysqli_fetch_array($company_res)) {


                              $company_names = $company_row['company_name'];
                              //$contacts_role = $contacts_row['role'];
                              //$contacts_status = $contacts_row['status'];
                              $company_phone = $company_row['phone_number'];
                              $company_email = $company_row['email_address'];
                              $company_industry = $company_row['industry_id'];
                              $company_location = $company_row['location'];
                              $company_country = $company_row['country_id'];

                              $company_id = $company_row['id'];
                              //choose industry name
                              $industry_query  = "select * from sp_industry WHERE id ='$company_industry'";
                              $industry_res    = mysqli_query($connection,$industry_query);
                              $industry_row=mysqli_fetch_array($industry_res);

                              $industry_names = $industry_row['industry_name'];
                              $industry_id = $industry_row['id'];

                              //choose Country name
                              $country_query  = "select * from  sp_countries WHERE id='$company_country'";
                              $country_res    = mysqli_query($connection,$country_query);
                              $country_row=mysqli_fetch_array($country_res);
                              $country_names = $country_row['country_name'];
                              $count_id = $country_row['id'];


                              ?>
                              <tr>
                                  <td><input type="checkbox"></td>
                                  <td>
                                      <a href='view-compnany?id=<?php echo $company_id ?>'><?php echo $company_names; ?></a>
                                  </td>

                                  <td><a href="tel:<?php echo $company_phone; ?>"> <?php echo $company_phone; ?></a>
                                  </td>
                                  <td><a href="mailto:<?php echo $company_email; ?>"> <?php echo $company_email; ?></a>
                                  </td>
                                  <td><a href="industry?id=<?php echo  $industry_id ?>"><?php echo $industry_names; ?></a> </td>
                                  <td><?php echo $company_location; ?></td>
                                  <td><a href="country?id=<?php echo $count_id ?>"><?php echo $country_names; ?></a></td>

                                  <td width="15%">
                                      <div class="btn-group"><a href='edit-contact?id=<?php echo $company_id ?>'
                                                                data-toggle="tooltip" title="Edit" data-placement="top"
                                                                class="btn btn-success btn-xs"><i
                                                      class="fa fa-edit"></i> </a>
                                          &nbsp; <?php if ($_SESSION['user'] == "admin") { ?> <a
                                                  href='delete?id=<?php echo $company_id ?>&type=company'
                                                  data-toggle="tooltip" title="Delete" data-placement="top"
                                                  onclick="return confirm('Are you sure you wish to move this record to trash?');"
                                                  class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                          <?php } ?>
                                          <a href='view-contact?id=<?php echo $company_id ?>'
                                             class="btn btn-success btn-xs" data-toggle="tooltip" title="View Project"
                                             data-placement="top"><i class="fa fa-eye"></i></a>
                                      </div>
                                  </td>
                              </tr>


                              <?php

                          }
                      }
                      else {
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

