<?php
$profile_query  = "select * from sp_users WHERE id = '$user_id'";
$profile_res    = mysqli_query($connection,$profile_query);
$profile_row=mysqli_fetch_array($profile_res);

$profile_image = $profile_row['user_img'];
$profile_names = $profile_row['first_name']." ". $profile_row['last_name'];
$first_name = $profile_row['first_name'];
$last_name = $profile_row['last_name'];
$profile_role = $profile_row['role'];
$profile_status = $profile_row['status'];
$profile_phone= $profile_row['phone_no'];
$profile_email= $profile_row['email_add'];
$profile_username= $profile_row['username'];
//Website
$site_id = 1;
$result = mysqli_query($connection,"SELECT * FROM sp_settings WHERE id ='$site_id'");

// display records if there are records to display

$row=mysqli_fetch_array($result);

$site_title = $row['site_title'];
$site_desc= $row['site_desc'];
$site_logo = $row['site_logo'];
$site_name = $row['site_name'];
$site_mobile = $row['site_phone_number'];
$site_email = $row['site_email'];
$site_add = $row['site_address'];
$site_url = $row['site_url'];
$site_fb = $row['facebook_acc'];
$site_twitter = $row['twitter_acc'];
$site_gplus= $row['gplus_acc'];
$site_ig= $row['instagram'];
$site_linkedin= $row['linkedin'];
// $site_link = $row['site_link'];
?>