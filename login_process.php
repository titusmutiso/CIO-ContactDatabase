<?php
/**
 * Created by PhpStorm.
 * User: SparkWorld
 * Date: 2/9/2017
 * Time: 11:53 PM
 */
require 'includes/config.php';


//compare user name & Password
$username = $_POST["username"];
$password = $_POST["password"];

// protect from mysql injection
$username = stripslashes($username);
$password = stripslashes($password);

$username = mysqli_real_escape_string($connection,$username);
$password = mysqli_real_escape_string($connection,$password);

//execute username and password
$cariuserpass = mysqli_query($connection,"SELECT * FROM users WHERE username='$username' AND password='$password'");
$count = mysqli_num_rows($cariuserpass);
$role = mysqli_fetch_array($cariuserpass);
if($count==1){
    //parent login
    if($role['role']=="parent"){
        $_SESSION['username'] = $username;
        header("location:parent/");}
    //teacher Login
    if($role['role']=="teacher"){
        $_SESSION['username'] = $username;
        header("location:teacher/");}
    //headtecher Login
    if($role['role']=="headmaster"){
        $_SESSION['username'] = $username;
        header("location:headmaster/");}
    //administrator login
    if($role['role']=="admin"){
        $_SESSION['username'] = $username;
        header("location:admin/");}
}

else{
    $error=' Wrong username or password
                <span>x</span>';
}
?>
<li class="first<?php if ($page=="dashboard"){ ?> page-active<?php }?>">
    <a href="dashboard"><span class="home-16 plix-16"></span>Dashboard</a>

</li>
<?php if($_SESSION['user']=="admin"){  ?>
    <li <?php if ($page=="settings"){ ?>class="page-active"<?php }?>>
        <a href="settings"><span class="settings-16 plix-16"></span>General Settings</a>

    </li>
<?php }?>
<?php if($_SESSION['user']=="admin"){  ?>
    <li <?php if ($page=="batch_course"){ ?>class="page-active"<?php }?>>
        <a href="batch_course"><span class="clipboard-16 plix-16"></span>Batch/Course</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="employee"){  ?>
    <li class="last <?php if ($page=="myprofile"){ ?> page-active<?php }?>">
        <a href="employee_info"><span class="vcard-16 plix-16"></span>My Profile</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="student"){  ?>
    <li class="last <?php if ($page=="myprofile"){ ?> page-active<?php }?>">
        <a href="student_info"><span class="vcard-16 plix-16"></span>My Profile</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="employee" || $_SESSION['user']=="admin" ){  ?>
    <li class="last <?php if ($page=="admission"){ ?> page-active<?php }?>">
        <a href="admission"><span class="grid-16 plix-16"></span>Students</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="admin"){  ?>
    <li <?php if ($page=="employee"){ ?>class="page-active"<?php }?>>
        <a href="employee"><span class="imagelist-16 plix-16"></span>Teachers</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="admin"){  ?>
    <li <?php if ($page=="subjectmanagement"){ ?>class="page-active"<?php }?>>
        <a href="courselist"><span class="document-tranparent2-16 plix-16"></span> Subjects</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="admin"||$_SESSION['user']=="employee"){  ?>
    <li <?php if($page=="exammanagement"){ ?> class="page-active"<?php } ?>>
        <a href="exam_management"><span class="note-16 plix-16"></span> Exam Management</a>
    </li>
<?php }?>
<?php if($_SESSION['user']=="student"){  ?>
    <li <?php if($page=="exammanagement"){ ?> class="page-active"<?php } ?>>
        <a href="student_exam_list?type=Written"><span class="note-16 plix-16"></span>Exams</a>
    </li>
<?php }?>
<li <?php if ($page=="marklist"){ ?>class="page-active"<?php }?>>
    <a href="<?php if($_SESSION['user']=="employee"||$_SESSION['user']=="admin"){?>sel_course<?php }else{?>student_view?q=mark<?php }?>">
        <span class="postcard-16 plix-16"></span>Mark List</a>
</li>
<li <?php if ($page=="assignments"){ ?>class="page-active"<?php }?>>
    <a href="<?php if($_SESSION['user']=="employee"||$_SESSION['user']=="admin"){?>assignments<?php }else{?>student_view?q=assign<?php }?>">
        <span class="document-tranparent-16 plix-16"></span>Assignments</a>
</li>
<li <?php if ($page=="notesmanagement"){ ?>class="page-active"<?php }?>>
    <a href="<?php if($_SESSION['user']=="employee"||$_SESSION['user']=="admin"){?>
                                                                notesmanagement<?php }else{?>student_view?q=notes<?php }?>"><span class="pencil-16 plix-16"></span> Notes</a>

</li>
<?php if($_SESSION['user']=="admin"){  ?>
    <li <?php if ($page=="feedback"){ ?>class="page-active"<?php }?>>
        <a href="feedback"><span class="mail-16 plix-16"></span>Feedback</a>

    </li>
<?php }?>
<?php if($_SESSION['user']=="student" || $_SESSION['user']=="employee"){  ?>
    <li <?php if ($page=="feedback"){ ?>class="page-active"<?php }?>>
        <a href="feedback"><span class="mail-16 plix-16"></span>Feedback</a>

    </li>
<?php }?>

<?php echo $_SESSION['uname']; ?>
<?php echo $_SESSION['photo'] ?>
