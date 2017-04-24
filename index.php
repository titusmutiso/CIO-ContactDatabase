<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//session
error_reporting(0);
ob_start();
session_start();
//db config
   require 'includes/config.php';

//functions
   require 'includes/functions.php';
//page name
   $page = '';


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
    <body class="full-width page-condensed">
<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>
    </div>
  
</div>
<!-- /navbar -->
<!-- Login wrapper -->
<div class="login-wrapper">
    <?php

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
    // username and password received from loginform
    $username=stripslashes(mysqli_real_escape_string($connection,$_POST['username']));
    $password=stripslashes(mysqli_real_escape_string($connection,md5($_POST['password'])));

    $sql_query="SELECT * FROM sp_users WHERE username='$username' and password='$password' and status='1' and trash !=0";

    $result=mysqli_query($connection,$sql_query);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count=mysqli_num_rows($result);
    $user_id = $row['id'];
    $user_role = $row['role'];





    // If result matched $username and $password, table row must be 1 row
    if($count==1)
    {
        if($row['role']==1){
            $_SESSION['login_user']=$username;
            $_SESSION['id']=$user_id;
            $_SESSION['user']="admin";
            $_SESSION['user']=$user_role;
            $today = date("F j, Y, g:i a");
            $ip=$_SERVER['REMOTE_ADDR'];
            $activity = 'LoggedIn';
           mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");

            header("location: dashboard");
        }else{
            $_SESSION['login_user']=$username;
            $_SESSION['id']=$user_id;
            $_SESSION['user']="manager";

            $today = date("F j, Y, g:i a");
            $ip=$_SERVER['REMOTE_ADDR'];
            mysqli_query($connection,"INSERT INTO sp_log (user_id,last_login,ip_address) VALUES('$user_id','$today','$ip')");

            header("location: dashboard");
        }





    }
    else
    {?>
        <?php echo "<script language='JavaScript'>
        swal('Good job!',
        'You clicked the button!',
            'success');
    </script>";
        ?>
        <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>

                <?php
                echo $error="Username or Password is invalid";?>
            </div>


            <?php
            }
            }
    ?>
            <div class="clearfix"></div>
            <br>
  <form action="" role="form" method="POST">
    <div class="popup-header"><a href="#" class="pull-left"><i class="icon-user-plus"></i></a><span class="text-semibold">User Login</span>
      <div class="btn-group pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
       
      </div>
    </div>
    <div class="well">
      <div class="form-group has-feedback">
        <label>Username</label>
        <input type="text" class="form-control" placeholder="Username" name="username">
        <i class="icon-users form-control-feedback"></i></div>
      <div class="form-group has-feedback">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Password" name="password">
        <i class="icon-lock form-control-feedback"></i></div>
      <div class="row form-actions">
        <div class="col-xs-6">
          <div class="checkbox checkbox-success">
            <label> <a href="recover-password">Forgot password?</a></label>
          </div>
        </div>
        <div class="col-xs-6">
          <button type="submit" class="btn btn-warning pull-right"><i class="icon-menu2"></i> Sign in</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- /login wrapper -->
<!-- Footer -->
<?php require 'includes/footer.php'; ?>   
<!-- /footer -->
<?php require 'includes/js.php';?>

</body>

</html>

