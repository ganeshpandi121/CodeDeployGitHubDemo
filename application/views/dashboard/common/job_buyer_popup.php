<!---- All the supplier details will be below and open when 
         clicked on "View Supplier Details in order progress page: -->
<!-- Supplier Quote -->
<?php
$target_div_id = 'buyer-short-details';
if ($user_type_id == 1 || (!empty($seller_quoted_job))) {

    $target_div_id = 'buyer-full-details';
} 
if (empty($seller_quoted_job)) {
    
    $logo = "<img src=" . base_url() . "styles/images/default.png width='50px' style='padding:10px'/>";
    
    $title = "<div class='row'><div class='col-md-6 text-center'>"
            . "<span class='text-muted'>Company name: </span><br>"
            . "<span class='text-primary'> --- </span></div>"
            . "<div class='col-md-6 text-center'>"
            . "<span class='text-muted' >Company logo:</span><br>" . $logo . "</div></div>";
  
    $content = "<div class='row border-bottom'><div class='col-md-6 text-center'>"
            . "<span class='text-muted'>User Name: </span><br> "
            . "<span class='text-primary'> --- </span></div>"
            . "<div class='col-md-6 text-center'>"
            . "<span class='text-muted'>Location:</span><br> "
            . "<span class='text-primary'> --- </span> </div></div>";
    $content .= "<div class='row'><div class='col-md-12'>"
             . "<span class='text-muted'><br/>Please Quote To reveal Full contact Details</div></div>";
}
if($this->session->userdata('is_vetted') == 0){
    $user_id = $this->session->userdata('user_id');
    $url = base_url('dashboard/job/notify_demo_seller') . '/' . $user_id . '/' . $job_id;
    $content = "You are currently logged in as Demo mode. 
                        To place a bid and start winning orders, 
                        as well as receiving advanced functionality. 
                        Request a package from our sales to begin by clicking 
                        <a  href='" . $url . "'>here</a>.";
    $title = "You are a demo user";
}
?>
<div class="col-md-4 text-right">
    <a class="btn btn-blue center-block" 
       data-toggle="modal" data-target="#<?php echo $target_div_id; ?>">
        Buyer Details 
    </a>
</div>
<!--Buyer Details Modal-->
<div class="modal fade" id="buyer-short-details" role="dialog" >
    <div class="modal-dialog" style="width: 350px">
        <!-- Quote content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br>
                <p class="modal-title"> 
                    <?php echo $title; ?></p>
            </div>
            <div class="modal-body">
                <?php echo $content; ?>
            </div>
        </div>
    </div>

</div>

<?php if (!empty($job_user_data)) { ?>
    <div class="modal fade" id="buyer-full-details" role="dialog">
        <div class="modal-dialog">
            <!-- Quote content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <?php
                    if (!empty($job_user_data->company_logo_path)) {
                        $logo = base_url() . "uploads/company/" . $job_user_data->company_logo_path;
                    } else {
                        $logo = base_url() . "styles/images/default.png";
                    }
                    ?>
                    <h4 class="modal-title"> 
                        <img src="<?php echo $logo; ?>" width="40px" height="40px"> 
                        <?php echo $job_user_data->user_first_name . ' ', $job_user_data->user_last_name; ?> 
                    </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered clearfix">

                        <tr>
                            <th width='50%'>Name </th>
                            <td ><?php echo $job_user_data->user_first_name . ' ', $job_user_data->user_last_name; ?> </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $job_user_data->email; ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>
                                <?php echo $job_user_data->telephone_code . '' . $job_user_data->telephone_no; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Fax Number</th>
                            <td><?php
                                $fax_number = !empty($job_user_data->fax_no) ? $job_user_data->fax_no : '---';
                                echo $fax_number;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php
                            if (!empty($job_user_data->street_address)) {
                                echo $job_user_data->address_name . ',<br> ' . $job_user_data->street_address . '.';
                            } else {
                                echo "---";
                            }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?php echo!empty($job_user_data->city) ? $job_user_data->city : '---'; ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo!empty($job_user_data->state) ? $job_user_data->state : '---'; ?></td>
                        </tr>

                        <tr>
                            <th>Country</th>
                            <td>
                                <?php echo!empty($job_user_data->country_name) ? $job_user_data->country_name : '---'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>ZIP code</th>
                            <td>
                                <?php echo!empty($job_user_data->post_code) ? $job_user_data->post_code : '---'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Additional Information</th>
                            <td>Company: <?php echo!empty($job_user_data->company_name) ? $job_user_data->company_name : '---' ?>
                                <br>Website:  <?php echo!empty($job_user_data->website) ? $job_user_data->website : '---' ?>
                                <br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!------------End of all supplier details----------------->


<?php } ?>