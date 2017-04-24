<?php
include('includes/config.php');
//$check = mysql_query("SELECT * FROM comment order by id desc");
?>
<div class="table-responsive">

                            <table id="example-table" class="table table-striped">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" > </th>

                                    <th>Industry Name</th>

                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <?php
                                $industry_query  = "select * from sp_industry ORDER BY id ASC";
                                $industry_res    = mysqli_query($connection,$industry_query);
                                $industry_count  =   mysqli_num_rows($industry_res);

                                ?>
<?php
if (mysqli_num_rows($industry_res) > 0) {

    while($industry_row=mysqli_fetch_array($industry_res)) {

        $industry_names = $industry_row['industry_name'];

        $industry_id = $industry_row['id'];?>
        <tr>
            <td><input type="checkbox" > </td>
            <td><?php echo $industry_names; ?></td>

            <td ><div class="btn-group"><a href='edit-industry?id=<?php echo $industry_id?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                    &nbsp;<a href='delete?id=<?php echo $industry_id ?>&type=contact' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                </div>
            </td>
        </tr>


    <?php }
}  else {
    echo 'No Records';
}

?>


</tbody>
</table>


</div>
<?php
if(isset($_POST['save']))
{
    $industry_name = $_POST['industry_name'];
    $sql= "INSERT INTO `sp_industry`(`id`, `industry_name`,`date_created`) VALUES (NULL,'$industry_name',NOW())";
    $fetch= mysqli_query($connection,"select * from sp_industry ORDER BY id ASC");
    $row=mysqli_fetch_array($fetch);
}
?>

<div class="showbox"> <?php echo $row['industry_name']; ?> </div>