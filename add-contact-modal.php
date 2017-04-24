
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" enctype="multipart/form-data">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">First Name</label>
                            <input type="text" name="f_name" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Lats Name</label>
                            <input type="text" name="l_name" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Designation / Rank</label>
                            <select name="designation" class="form-control select2">
                                <option selected disabled>Select Designation</option>
                                <?php
                                $role_query  = "select * from sp_designation ORDER BY id ASC";
                                $role_res    = mysqli_query($connection,$role_query);
                                $role_count  =   mysqli_num_rows($role_res);
                                while($role_row=mysqli_fetch_array($role_res)) {

                                    $role_names = $role_row['role'];

                                    $role_id = $role_row['id'];
                                    ?>
                                    <option value="<?php echo $role_id?>"><?php echo $role_names ?></option>
                                <?php }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" id="exampleInputEmail1" placeholder="+254700000000">
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label for="Slide-title">Email Address</label>

                            <input class="form-control" type="email" name="email_add" placeholder="email@domain.com"/>

                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label for="Slide-title">Select Company</label>

                            <select class="form-control" name="company">
                                <?php
                                $selected_query  = "select * from sp_company WHERE id='$get_id'";
                                $selected_res    = mysqli_query($connection,$selected_query);
                                $selected_row=mysqli_fetch_array($selected_res);

                                $co_id = $selected_row['id'];
                                $co_name = $selected_row['company_name'];
                                ?>
                                <option value="<?php echo  $get_id ?>" selected><?php echo $co_name ?></option>
                                <?php
                                //select companies from DB
                                $company_query  = "select * from sp_company WHERE id != '$get_id' ORDER BY id ASC";
                                $company_res    = mysqli_query($connection,$company_query);
                                $company_count  =   mysqli_num_rows($company_res);
                                if (mysqli_num_rows($company_res) > 0) {

                                    while($company_row=mysqli_fetch_array($company_res)) {


                                        $company_names = $company_row['company_name'];
                                        $company_id = $company_row['id'];
                                        ?>
                                        <option value="<?php echo $company_id ?>"><?php echo $company_names ?></option>

                                        <?php

                                    }
                                }
                                else {
                                    echo '<option>No Records</option>';
                                }

                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Slide-title">LinkedIn Account</label>
                            <input type="text" name="linked-in" class="form-control" id="exampleInputEmail1" placeholder="First & Last Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Slide-title">Facebook Account</label>
                            <input type="text" name="fb-account" class="form-control" id="exampleInputEmail1" placeholder="First & Last Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Slide-title">Twitter Account</label>
                            <input type="text" name="twitter-acc" class="form-control" id="exampleInputEmail1" placeholder="@twitter_username">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Membership:</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="member" class="styled" checked="checked">
                                    Member</label>
                                <label class="radio-inline">
                                    <input type="radio" name="member" class="styled">
                                    Not Member </label>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Slide-title">Subscriptions</label>
                            <br>
                            <input type="checkbox" name="subscrition" value="1">&nbsp;&nbsp;Yearly Subscription

                        </div>
                    </div>










                    <div class="col-lg-12">
                        <button type="submit" name="save" class="btn btn-primary  btn-square pull-right">Submit</button>
                    </div>
                </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Add Record</button>
            </div>
        </div>
    </div>
</div>