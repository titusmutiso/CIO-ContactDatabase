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
    if(isset($_POST['reset'])){
        $email = $_POST['email-address'];
        //check whether matches whats in db if not echo error
        if(empty($email)){
            echo'Please input email Address';
        }else{
            //compare to db
            $sql ="SELECT * FROM sp_users WHERE email_add='$email'";
            $result =mysqli_query($connection,$sql);
            $count = mysqli_num_rows($result);
            if($count==1){
                echo'Send email check your Inbox : email found';
                //get names from result
                $email_row=mysqli_fetch_array($result);
                 $username = $email_row['username'];
                 $fname = $email_row['first_name'];
                 //randomize minimum character of 6
                function randomPassword() {
                    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 6; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }
                    return implode($pass); //turn the array into a string
                }
                //
               $pass=randomPassword();
                $from="kamba.nation@gmail.com";
                $headers = "From:" . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                //$headers = "From: Simpay Kenya <$email>";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $subject ="Your New Password is";
                $message ="Hello <strong>";
                $message .=$fname;
                $message .="</strong> </br>";
                $message .="Your New password is : <strong>";
                $message .=$pass;
                $message .="</strong> <br> Thanks<br> <strong>CIO Team</strong>";

                echo $password = md5($pass);

                //update db with a new password
                $password_update ="UPDATE sp_users SET password ='$password' WHERE email_add='$email'";
                mysqli_query($connection,$password_update);

                mail($email,$subject,$message,$headers);


            }else{
                echo'account not found please contact Admin';
            }
        }

        //if yes send an email to $email with new password

        //update user password in db md5()

        //echo message check mail for your new password
    }
    ?>
    <div class="clearfix"></div>
    <br>
    <form action="" role="form" method="POST">
        <div class="popup-header"><a href="#" class="pull-left"><i class="icon-user-plus"></i></a><span class="text-semibold">Recover Password</span>
            <div class="btn-group pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>

            </div>
        </div>
        <div class="well">
            <div class="form-group has-feedback">
                <label>Email Address</label>
                <input type="text" class="form-control" placeholder="Please Enter email Address" name="email-address">
                <i class="icon-users form-control-feedback"></i></div>

            <div class="row form-actions">
                <div class="col-xs-6">
                    <div class="checkbox checkbox-success">
                        <a href="index">Login Here</a>

                    </div>
                </div>
                <div class="col-xs-6">
                    <button type="submit" name="reset" class="btn btn-warning pull-right text-center"><i class="fa fa-paper-plane" aria-hidden="true"></i> Recover</button>
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

</body>
</html>

