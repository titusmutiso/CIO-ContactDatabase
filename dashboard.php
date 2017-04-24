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
   $page = 'dashboard';


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
             <!--get counts-->
             <?php 
             //get number of contacts
             $contacts_query  = "SELECT * FROM `sp_contacts` WHERE status !=0";
                  $contacts_res    = mysqli_query($connection,$contacts_query);
                  $contacts_count  =   mysqli_num_rows($contacts_res);
                  
                  //number registers today
                  $day_sql="SELECT * FROM sp_contacts WHERE status !=0 AND  date_created > DATE_SUB(NOW(), INTERVAL 1 DAY)";
                  $day_results = mysqli_query($connection, $day_sql);
                  $day_count = mysqli_num_rows($day_results);
                  
                  //this week
                  $week_sql="SELECT * FROM sp_contacts WHERE status !=0 AND date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
                  $week_results = mysqli_query($connection, $week_sql);
                  $week_count = mysqli_num_rows($week_results);
                  
                  //this Month
                   $month_sql="SELECT * FROM sp_contacts WHERE status !=0 AND date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                  $month_results = mysqli_query($connection, $month_sql);
                  $month_count = mysqli_num_rows($month_results);
             
             //get number of contacts per designation
                  //cio                 
                
                 
             
             //Weekly Contacts
             
             ?>
             <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                     <?php echo $contacts_count ?>
                                    </h3>
                                    <p>
                                        Contacts
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo  $day_count ?>
                                        <!--53<sup style="font-size: 20px">%</sup>-->
                                    </h3>
                                    <p>
                                        Registered Today
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        
                                        <?php echo $week_count ?>
                                    </h3>
                                    <p>
                                        Registered This Week
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                       <?php echo $month_count ?>
                                    </h3>
                                    <p>
                                        <?php echo date('Y-m-d',strtotime("-30 days")); ?>
                                        Registered this Month
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Monthly Growth</h2>
                            <div id="lineChart"></div>
                        </div>
                        <div class="col-md-4">
                            <h2>Contact Growth(all time)</h2>
                            <div id="barChart"></div>
                        </div>
                        <div class="col-md-4">
                            <h2>Percentage per Designation</h2>
                            <div id="piechart"></div>
                            
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
        <?php
        //piechart Date
        $sth = mysqli_query($connection,"SELECT designation FROM sp_contacts");

while($r = mysqli_fetch_assoc($sth)) {
$arr2=array_keys($r);
$arr1=array_values($r);

}

for($i=0;$i<count($arr1);$i++)
{
    $chart_array[$i]=array((string)$arr2[$i],intval($arr1[$i]));
}
echo "<pre>";
$data=json_encode($chart_array);
        ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
   
  function drawChart() {
      /*var data = new google.visualization.DataTable();
        data.addColumn("ROLE", "Number");
        data.addColumn("number", "NO of record");

        data.addRows(<?php //$data ?>);

        ]);*/
 
    var data = google.visualization.arrayToDataTable([
      ['Role', 'Number'],
      ['CEOs',     11],
      ['CIOs',      2],
      ['IT Directors',  2],
      ['CISOs', 2]
    ]);
 
    var options = {
      title: 'Designation/Titles'
    };
 
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
 
    chart.draw(data, options);
    
    var barChart = new google.visualization.ColumnChart(document.getElementById('barChart'));
 
    barChart.draw(data, options);
    
     var lineChart = new google.visualization.LineChart(document.getElementById('lineChart'));
 
    lineChart.draw(data, options);
  }
</script>
    </body>
</html>

