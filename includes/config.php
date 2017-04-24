<?php
/**
 * Created by PhpStorm.
 * User: SparkWorld
 * Date: 12/4/2016
 * Time: 3:54 PM
 */
//connect to db
error_reporting(0);
//local db
$connection = mysqli_connect("localhost", "root", "", "cio_contacts");

if(!$connection){
    echo "Cannot connect to the server: (" . mysqli_connect_errno(). ")";
    exit();
}

/*//remote
$connection = mysqli_connect("localhost", "demoafri_cio", "27679054@@", "demoafri_contacts");

if(!$connection){
    echo "Cannot connect to the server: (" . mysqli_connect_errno(). ")";
    exit();

}*/