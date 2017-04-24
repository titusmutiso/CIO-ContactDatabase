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

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Industries</h6>
                    </div>
                    <div class="panel-body">
                        <div class="datatable">
                            <table class="table table-bordered table-condensed table-stripped" >
                                <thead>
                                <tr>
                                    <th><input type="checkbox" > </th>

                                    <th>Designation /Role Name</th>

                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <?php
                                $role_query  = "select * from sp_designation WHERE status !=0 AND ORDER BY id ASC";
                                $role_res    = mysqli_query($connection,$role_query);
                                $role_count  =   mysqli_num_rows($role_res);

                                ?>
                                <?php
                                if (mysqli_num_rows($role_res) > 0) {

                                    while($role_row=mysqli_fetch_array($role_res)) {

                                        $role_names = $role_row['role'];

                                        $role_id = $role_row['id'];?>
                                        <tr>
                                            <td><input type="checkbox" > </td>
                                            <td><?php echo $role_names; ?></td>

                                            <td ><div class="btn-group"><a href='edit-designation?id=<?php echo $role_id?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                                                    &nbsp;<a href='delete?id=<?php echo $role_id ?>&type=role' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
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
            </div>
            <div class="col-md-6 well">
                <?php
                if (isset($_POST['save'])) {
                    // get the form data

                    $role_name = $_POST['role'];
                    $sql= "INSERT INTO `sp_designation`(`id`, `role`, `date_created`) VALUES (NULL,'$role_name',NOW())";
                    if(mysqli_query($connection, $sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        echo $role_name ;
                        echo' &nbsp; &nbsp;created successfully
                  </div>';
                        //update Log
                        $today = date("F j, Y, g:i a");
                        $ip=$_SERVER['REMOTE_ADDR'];
                        $activity = " Created New Designation".$role_name;
                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                        $last_id = mysqli_insert_id($connection);
                        $status = 0;
                        //notification Count
                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                    } else {
                        echo '<div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Error while Adding  &nbsp; &nbsp;';
                        echo $role_name ;
                        echo'
                  </div>';
                    }
                }
                ?>
                <!--add form without refresh-->
                <form class="" method="POST" action="">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Slide-title">Designation /Role</label>
                            <input class="form-control" name="role" type="text" placeholder="Designation /Role Name" id="role" required>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" name="save" id="send" class="btn btn-primary  btn-square pull-right">Submit</button>
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
<!-- end Page container -->
<!--JS-->
<?php require 'includes/js.php';?>

</body>
</html>

