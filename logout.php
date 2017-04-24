<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//session
session_start();
//db config
   require 'includes/config.php';

session_destroy();
//redirects to login page
header("location:index")


?>