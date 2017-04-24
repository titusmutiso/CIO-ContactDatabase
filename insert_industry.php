<?php
/**
 * Created by PhpStorm.
 * User: SparkWorld
 * Date: 3/8/2017
 * Time: 3:37 PM
 */
require 'includes/config.php';

if(isset($_POST['send'])){
    if($_POST["industry_name"] !="")
    {
    $industry_name = $_POST['industry_name'];
        $sql= "INSERT INTO `sp_industry`(`id`, `industry_name`) VALUES (NULL,'$industry_name')";

    }

}


?>