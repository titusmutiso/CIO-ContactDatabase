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
$mainpage ='users';
$page = 'users';


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
                    <table class="table table-condensed table-bordered table-stripped" >
                        <thead>
                        <tr>
                            <th><input type="checkbox" > </th>

                            <th>User Name</th>
                            <th>Project Image</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <?php
                        $users_query  = "select * from sp_users WHERE id !='$user_id'";
                        $users_res    = mysqli_query($connection,$users_query);
                        $users_count  =   mysqli_num_rows($users_res);

                        ?>
                        <?php
                        if (mysqli_num_rows($users_res) > 0) {

                            while($users_row=mysqli_fetch_array($users_res)) {

                                $users_image = $users_row['user_img'];
                                $users_names = $users_row['first_name']." ". $users_row['last_name'];
                                $users_role = $users_row['role'];
                                $users_status = $users_row['status'];
                                $users_phone= $users_row['phone_no'];

                                $users_id = $users_row['id'];?>
                                <tr>
                                    <td><input type="checkbox" > </td>
                                    <td><a href='view_user?id=<?php echo $users_id ?>'><?php echo $users_names; ?></a></td>
                                    <td><a href='view_user?id=<?php echo $users_id ?>'><img src="<?php echo $users_image; ?>" class="responsive" width="100" height="100"/></a></td>
                                    <td ><a href="tel:<?php echo $users_phone; ?>"> <?php echo $users_phone; ?></a></td>
                                    <td ><?php
                                        if($users_role==1){
                                            echo'<span class="label label-info">Admin</span>';

                                        }else{
                                            echo'<span class="label label-primary">Project Manager</span>';
                                        }

                                        ?></td>
                                    <td ><?php if($users_status==1){
                                            echo'<span class="label label-success">Active</span>';

                                        }else{
                                            echo'<span class="label label-danger">suspended</span>';
                                        } ?></td>
                                    <td width="20%"><div class="btn-group"><a href='edit-user?id=<?php echo $users_id ?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                                            <a href='view_user?id=<?php echo $users_id ?>' class="btn btn-success btn-xs" data-toggle="tooltip" title="View Project" data-placement="top" ><i class="fa fa-eye"></i>
                                                <a href='update-password?id=<?php echo $users_id ?>' data-toggle="tooltip" title="update Password" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-lock"></i> </a>
                                                &nbsp;<a href='delete?id=<?php echo $users_id ?>&type=user' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                            </a>
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

