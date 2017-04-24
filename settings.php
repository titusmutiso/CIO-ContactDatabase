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
$mainpage ='';
$page = 'settings';


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
	                <div class="panel-heading"><h6 class="panel-title"><i class="icon-page-break"></i> Default form</h6></div>
	                <div class="panel-body">
                        <?php

                        ?>
                        <div class="tabbable page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a href="#overview" data-toggle="tab">General</a>
                                </li>
                                <li><a href="#drafts" data-toggle="tab">Address</a>
                                </li>
                                <li><a href="#trash" data-toggle="tab">Social media</a>
                                </li>

                            </ul>

                        <div id="userTabContent" class="tab-content">

                            <div class="tab-pane fade in active" id="overview">

                                <?php

                                if (isset($_POST['site-update'])) {
// get the form data
                                    $site_title = htmlentities($_POST['site-title'], ENT_QUOTES);
                                    $site_desc = htmlentities($_POST['site-desc'], ENT_QUOTES);
                                    $site_name = htmlentities($_POST['site-name'], ENT_QUOTES);
                                    //$site_logo= htmlentities($_POST['site-logo'], ENT_QUOTES);
                                    if($_FILES['site-logo']['size'] == 0) {
                                        $site_logo = $row['site_logo'];
// No file was selected for upload, your (re)action goes here
                                    }  else {
                                        $image = addslashes(file_get_contents($_FILES['site-logo']['tmp_name']));
                                        $image_name = addslashes($_FILES['site-logo']['name']);
                                        //$image_size = getimagesize($_FILES['image']['tmp_name']);

                                        move_uploaded_file($_FILES["site-image"]["tmp_name"], "uploads/" . $_FILES["site-logo"]["name"]);
                                        $site_logo = "uploads/" . $_FILES["site-logo"]["name"];
                                    }




                                    //$site_image= htmlentities($_POST['site-image'], ENT_QUOTES);


// insert the new record into the database
                                    //$mysqli ->query("INSERT INTO INSERT sp_sites (`site_id`, `site_title`, `site_desc`, `site_image`, `site_link`, `date_created`, `date_modified`, `site_status`, `modified_by`) VALUES (NULL,$site_title, $site_desc, $site_image, $site_link, $site_image, $site_image, $site_image, $site_status, $site_status)");
                                    //$sql = "UPDATE sp_sites (`site_id`, `site_title`, `site_desc`, `site_image`, `site_link`,`site_status`)
//VALUES (NULL,'$site_title', '$site_desc', '$site_image', '$site_link', '$site_status')";
                                    $sql = "UPDATE `sp_settings` SET `site_title` = '$site_title', `site_desc` = '$site_desc', `site_logo` = '$site_logo', `site_name` = '$site_name'  WHERE `id` = 1";

                                    if(mysqli_query($connection, $sql) === TRUE) {
                                        echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New updated created successfully
                                        </div>';
                                        //update Log
                                        $today = date("F j, Y, g:i a");
                                        $ip=$_SERVER['REMOTE_ADDR'];
                                        $activity = " General Settings Were Updated";
                                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                                        $last_id = mysqli_insert_id($connection);
                                        $status = 0;
                                        //notification Count
                                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Updating
                                        </div>';
                                    }



// redirect the user


                                }
                                ?>
                                <form role="form" method="post" action="" enctype="multipart/form-data">
                                    <input type="text" hidden name="site-id" value="<?php echo $site_id; ?>">
                                    <div class="form-group ">
                                        <label for="Slide-title">Website Name</label>
                                        <input type="text" required="required" name="site-name" value="<?php echo $site_name; ?>" class="form-control"  placeholder="Website Name">
                                    </div>

                                    <div class="form-group ">
                                        <label for="Slide-title">SEO Website Title</label>
                                        <input type="text" required="required" name="site-title" value="<?php echo $site_title; ?>" class="form-control"  placeholder="Website Title">
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="form-group ">
                                        <label for="Slide-desc">SEO Meta Description</label>
                                        <textarea name="site-desc" class="form-control" ><?php echo html_entity_decode($site_desc); ?></textarea>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Logo Here</label>
                                            <input type="file"  name="site-logo"  value="<?php echo $site_logo; ?>">
                                            <p class="help-block">Image Size Here (100 x 95)</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <img src="<?php echo $site_logo; ?>" alt="<?php echo $site_name; ?>" class="img-responsive thumbnail">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <button type="submit" name="site-update" class="btn btn-default  btn-square pull-right">Submit</button>
                                    </div><br><div class="clearfix"></div>
                                </form>
                                <!-- /.table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="drafts">
                                <?php
                                //contact address
                                if (isset($_POST['update-address'])) {
                                    // get the form data

                                    $site_email2 = htmlentities($_POST['biz-email'], ENT_QUOTES);
                                    $site_phone2 = htmlentities($_POST['biz-phone'], ENT_QUOTES);
                                    $site_address2= htmlentities($_POST['biz-address'], ENT_QUOTES);

                                    $sql = "UPDATE `sp_settings` SET `site_phone_number` = '$site_phone2', `site_email` = '$site_email2', `site_address` = '$site_address2'  WHERE `id` = 1";

                                    if(mysqli_query($connection, $sql) === TRUE) {
                                        echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New updated created successfully
                                        </div>';
                                        //update Log
                                        $today = date("F j, Y, g:i a");
                                        $ip=$_SERVER['REMOTE_ADDR'];
                                        $activity = "Business Address Were Updated";
                                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                                        $last_id = mysqli_insert_id($connection);
                                        $status = 0;
                                        //notification Count
                                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Updating
                                        </div>';
                                    }



// redirect the user


                                }
                                ?>
                                <form role="form" method="post" action="" enctype="multipart/form-data">
                                    <input type="text" hidden name="site-id" value="<?php echo $site_id; ?>">

                                    <div class="form-group ">
                                        <label for="Slide-title">Business Name</label>
                                        <input disabled="" type="text" name="site-name" value="<?php echo $site_name; ?>"class="form-control"  placeholder="Business Name">
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="form-group ">
                                        <label for="Slide-desc">Business Address</label>
                                        <textarea name="biz-address"class="form-control" ><?php echo $site_add; ?></textarea>
                                    </div>

                                    <div class="form-group ">
                                        <label for="Slide-title">Business phone Number</label>
                                        <input type="text" required="required" name="biz-phone" value="<?php echo $site_mobile; ?>"class="form-control"  placeholder="Phone Number">
                                    </div>
                                    <div class="form-group ">
                                        <label for="Slide-title">Business Email Address</label>
                                        <input type="text" required="required" name="biz-email" value="<?php echo $site_email; ?>"class="form-control"  placeholder="Email Address">
                                    </div>

                                    <!--<div class="col-lg-6">
                                        <img src="pick Image b4 Upload" alt="pick Image b4 Upload" class="img-responsive thumbnail">
                                    </div>-->
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <button type="submit" name="update-address" class="btn btn-default  btn-square pull-right">Submit</button>
                                    </div><br><div class="clearfix"></div>
                                </form>
                                <!-- /.table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="trash">

                                <?php
                                //contact address
                                if (isset($_POST['update-socialmedia'])) {
                                    // get the form data

                                    $site_fb = htmlentities($_POST['fb-name'], ENT_QUOTES);
                                    $site_twitter = htmlentities($_POST['twitter-name'], ENT_QUOTES);
                                    $site_gplus= htmlentities($_POST['gplus-name'], ENT_QUOTES);
                                    $site_ig= htmlentities($_POST['site-ig'], ENT_QUOTES);
                                    $site_linkedin= htmlentities($_POST['site-linkedin'], ENT_QUOTES);


                                    $sql = "UPDATE `sp_settings` SET `facebook_acc` = '$site_fb', `twitter_acc` = '$site_twitter', `gplus_acc` = '$site_gplus', `linkedin` = '$site_linkedin', `instagram` = '$site_ig'  WHERE `id` = 1";

                                    if(mysqli_query($connection, $sql) === TRUE) {
                                        echo '<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            New updated created successfully
                                        </div>';
                                        //update Log
                                        $today = date("F j, Y, g:i a");
                                        $ip=$_SERVER['REMOTE_ADDR'];
                                        $activity = " Social Media Setting Were Updated";
                                        mysqli_query($connection,"INSERT INTO sp_log (user_id,activity, last_login,ip_address) VALUES('$user_id','$activity','$today','$ip')");
                                        $last_id = mysqli_insert_id($connection);
                                        $status = 0;
                                        //notification Count
                                        //pick History ID / User Role / status =0 unread 1 - read / update on read
                                        mysqli_query($connection,"INSERT INTO sp_notifications (id,user_id,activity,history_id, date_created,status) VALUES(NULL,'$user_id','$activity','$last_id',NOW(),'$status')");




                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Error while Updating
                                        </div>';
                                    }



// redirect the user


                                }
                                ?>
                                <form role="form" method="post" action="" enctype="multipart/form-data" id="validate">
                                    <input type="text" hidden name="site-id" value="<?php echo $site_id; ?>">

                                    <div class="form-group ">
                                        <label for="Slide-title">Facebook URL</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                            <input type="text"  name="fb-name" value="<?php echo $site_fb; ?>"class="form-control"  placeholder="Website Name">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="Slide-title">Twitter URL</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                            <input type="text"  name="twitter-name" value="<?php echo $site_twitter; ?>"class="form-control"  placeholder="Website Name">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="Slide-title">Google Plus URL</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                                            <input type="text" name="gplus-name" value="<?php echo $site_gplus; ?>"class="form-control"  placeholder="Website Name">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="Slide-title">Instagram URL</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                            <input type="text" name="site-ig" value="<?php echo $site_ig; ?>"class="form-control"  placeholder="Website Name">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="Slide-title">LinkedIn URL</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                            <input type="text" name="site-linkedin" value="<?php echo $site_linkedin; ?>"class="form-control"  placeholder="Website Name">
                                        </div>
                                    </div>






                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <button type="submit" name="update-socialmedia" class="btn btn-default  btn-square pull-right">Submit</button>
                                    </div>
                                    <br><div class="clearfix"></div>
                                </form>
                                <!-- /.table-responsive -->


                            </div>
                        </div>

				        

				        

                       
				 
			
                                                 
                                                 
                                       
                                            
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
    </body>
</html>

