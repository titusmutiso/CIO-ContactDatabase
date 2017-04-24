<?php
/**
 * Created by PhpStorm.
 * User: SparkWorld
 * Date: 4/21/2017
 * Time: 10:01 AM
 */
//db connection
if(!isset($_SESSION['login_user']))
{
    header("Location: index");
}
$login_session=$_SESSION['login_user'];
$user_id = $_SESSION['id'];
$user_role =$_SESSION['user'];
require 'includes/config.php';

if(isset($_POST['f_name']) && isset($_POST['l_name']) && isset($_POST['phone_number']))
{
    // include Database connection file


    $fname = htmlentities($_POST['f_name'], ENT_QUOTES);
    $lname= htmlentities($_POST['l_name'], ENT_QUOTES);
    $user_number = htmlentities($_POST['phone_number'], ENT_QUOTES);
    $user_email = htmlentities($_POST['email_add'], ENT_QUOTES);
    $company_id = htmlentities($_POST['company'], ENT_QUOTES);
    $rank= htmlentities($_POST['designation'], ENT_QUOTES);
    $linked_in = htmlentities($_POST['linkedin'], ENT_QUOTES);
    $fb = htmlentities($_POST['fbaccount'], ENT_QUOTES);
    $twitter = htmlentities($_POST['twitteracc'], ENT_QUOTES);
    $membership = htmlentities($_POST['member'], ENT_QUOTES);
    $subscription= htmlentities($_POST['subscription'], ENT_QUOTES);
    $status = 1;

    $query ="INSERT INTO `sp_contacts`(`id`, `first_name`, `last_name`, `email_address`, `phone_no`, `company`, `designation`, `owner`, `user_role`, `membership`, `subscription`, `linkedin`, `facebook`, `twitter`, `status`, `date_created`, `date_updated`, `modified_by`)"
        ." VALUES (NULL,'$fname','$lname','$user_email','$user_number','$company_id','$rank','$user_id','$user_role','$membership','$subscription','$linked_in','$fb','$twitter','$status',NOW(),NOW(),'$owner')";
    //posting to DB

if(mysqli_query($connection, $query) === TRUE) {
    echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New contact created successfully
                                        </div>';
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