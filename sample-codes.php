<table id="example-table" class="table table-striped">
    <thead>


    VALUES (NULL,'$fname','$lname','$user_email','$user_number','$company_id','$rank','$user_id','$user_role','$membership','$subscription','$linked_in','$fb','$twitter','$status',2,2,'$user_id')
    <tr>
        <th><input type="checkbox" > </th>

        <th>Country Name</th>

        <th>Actions</th>
    </tr>
    </thead>

    <?php
    $country_query  = "select * from sp_countries ORDER BY id ASC";
    $country_res    = mysqli_query($connection,$country_query);
    $country_count  =   mysqli_num_rows($country_res);

    ?>
    <?php
    if (mysqli_num_rows($country_res) > 0) {

        while($country_row=mysqli_fetch_array($country_res)) {

            $country_names = $country_row['country_name'];

            $country_id = $country_row['id'];?>
            <tr>
                <td><input type="checkbox" > </td>
                <td><?php echo $country_names; ?></td>

                <td ><div class="btn-group"><a href='edit-industry?id=<?php echo $country_id?>' data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> </a>
                        &nbsp;<a href='delete?id=<?php echo $country_id ?>&type=contact' data-toggle="tooltip" title="Delete" data-placement="top" onclick="return confirm('Are you sure you wish to move this record to trash?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
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