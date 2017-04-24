<?php
//fetch.php
require 'includes/config.php';
$output = '';
if(isset($_POST["query"]))
{
    $search = mysqli_real_escape_string($connection, $_POST["query"]);
    $query = "
  SELECT * FROM sp_countries 
  WHERE country_name LIKE '%".$search."%'
 ";
}
else
{
    $query = "
  SELECT * FROM sp_countries ORDER BY id ASC
 ";
}
$result = mysqli_query($connection, $query);
if(mysqli_num_rows($result) > 0)
{
    $output .= '
  <div class="table-responsive">
   <table class="table table-bordered table-stripped">
    <tr>
     <th>Country Name</th>
    
    </tr>
 ';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '
   <tr>
    <td><a href="country.php?id='.$row["id"].'"> '.$row["country_name"].'</a></td>
   </tr>
   
  ';
    }
    echo $output;
}
else
{
    echo 'Data Not Found';
}
