<?php
session_start();
if(!isset($_SESSION['login_user']))
{
    header("Location: index");
}
$login_session=$_SESSION['login_user'];
$user_id = $_SESSION['id'];

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//database
require 'includes/config.php';
//login - sessions

//functions
require 'includes/functions.php';

$id=$_REQUEST['id'];
$type=$_REQUEST['type'];
switch($type)
{
    //delete User
    case 'user':
        $user_query = mysqli_query($connection,"UPDATE `sp_users` SET `trash`=0 WHERE id=$id");
        //get username
        $show_name =mysqli_query($connection,"SELECT * FROM `sp_users` WHERE id=$id");
        $user_row = mysqli_fetch_array($show_name);
        $username = $user_row['username'];
        header("location:users.php");
        //log
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Deleted <strong>".$username ."</strong> ";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
    case 'contact':
//delete contact
        mysqli_query($connection,"UPDATE `sp_contacts` SET `status`=0 WHERE id=$id");
        header("location:contacts.php");
        //get Contact Name
        $contact_name =mysqli_query($connection,"SELECT * FROM `sp_contacts` WHERE id=$id");
        $contact_row = mysqli_fetch_array($contact_name);
        $contact_names = $contact_row['first_name']." ".$contact_row['last_name'];
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Deleted <strong>". $contact_names."</strong>";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
    case 'company':
//delete company
        mysqli_query($connection,"UPDATE `sp_company` SET `status`=0 WHERE id=$id");
        header("location:company.php");
        //company Delete
        $co_name =mysqli_query($connection,"SELECT * FROM `sp_company` WHERE id=$id");
        $co_row = mysqli_fetch_array($co_name);
        $company_names = $co_row['company_name'];
        //log
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Deleted <strong>".$company_names."</strong>";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
    case 'industry':
//delete industry
        mysqli_query($connection,"UPDATE `sp_industry` SET `status`=0 WHERE id=$id");
        header("location:industries.php");
        $indu_name =mysqli_query($connection,"SELECT * FROM `sp_industry` WHERE id=$id");
        $indu_row = mysqli_fetch_array($indu_name);
        $indus_name= $indu_row['industry_name'];
        //update Log
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Deleted <strong>".$indus_name."</strong>";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
    case 'country':
//delete country
        mysqli_query($connection,"UPDATE `sp_country` SET `status`=0 WHERE id=$id");
        header("location:country.php");
        $countr_name =mysqli_query($connection,"SELECT * FROM `sp_country` WHERE id=$id");
        $countr_row = mysqli_fetch_array($countr_name);
        $count_name= $countr_row['country_name'];
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Delete <strong>".$count_name."</strong>";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
    case 'role':
//delete country
        mysqli_query($connection,"UPDATE `sp_designation` SET `status`=0 WHERE id=$id");
        header("location:designation.php");
        $role_name =mysqli_query($connection,"SELECT * FROM `sp_designation` WHERE id=$id");
        $role_row = mysqli_fetch_array($role_name);
        $designation_name= $role_row['role_name'];
        $today = date("F j, Y, g:i a");
        $ip=$_SERVER['REMOTE_ADDR'];
        $activity = "Deleted <strong>".$designation_name."</strong>";
        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
        $last_id = mysqli_insert_id($connection);
        $status = 0;
        //notification Count
        //pick History ID / User Role / status =0 unread 1 - read / update on read
        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");

        break;
}



?>
