<script>
    $(function(){
        $('#timer').countdown("<?php echo date('Y/m/d H:i:s', $job_details->sla_milestone); ?>")
                    .on('update.countdown', function (event) {
                        var format = '%H Hours: %M Minutes: %S Seconds';
                        if (event.offset.days > 0) {
                            format = '%-d day%!d : ' + format;
                        }
                        if (event.offset.weeks > 0) {
                            format = '%-w week%!w ' + format;
                        }
                        $(this).html(event.strftime(format));
                    })
                    .on('finish.countdown', function (event) {
                        $(this).html('CLOSED')
                                .parent().addClass('disabled');
                        $('#submit_quote').attr('disabled','disabled');
                    });
    });
</script>

<?php if (!empty($this->session->flashdata('success_msg'))) { ?>
    <div class="alert alert-success text-center">
        <?php echo $this->session->flashdata('success_msg'); ?>
    </div>
<?php } ?>
<?php if (!empty($this->session->flashdata('error_msg'))) { ?>
    <div class="alert alert-danger text-center">
        <?php echo $this->session->flashdata('error_msg'); ?>
    </div>
<?php } ?>

<?php if (!empty($job_details)) { ?>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">             
                    <h5 class="text-muted ">Order Id: <b class="text-primary">#<?php
                            echo $job_details->job_id;
                            ?> </b></h5>
                    <p class="text-muted ">Created On: <b class="text-primary"><?php
                            echo date("F j, Y g:i a", $job_details->created_date);
                            ?></b></p>
                    <?php if ($user_type_id == 1) { ?>
                        <p class="text-muted ">
                            Created By: 
                            <?php if (!empty($job_user_data)) { ?>
                                <a href="<?php echo base_url('admin/view_user') . '/' . $job_user_data->user_id; ?>">
                                    <b class="text-primary">
                                        <?php
                                        echo $job_user_data->user_first_name . ' ' . $job_user_data->user_last_name;
                                        ?>
                                    </b>
                                </a>

                            <?php }
                            ?> 
                        </p>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <h4 class="text-right">Project Lead Time left:
                        <?php $time_class = (time() < $job_details->product_lead_time) ? "text-success" : "text-danger" ?>
                        <b class="<?php echo $time_class; ?>"> 
                            <script>
                                document.write(moment('<?php echo date("Y-m-d H:i", $job_details->product_lead_time); ?>').endOf('minutes').fromNow())
                            </script>
                        </b> <br/>
                    </h4>
                    
                    <h4 class="text-right">Auction Time left:
                        <?php $time_class = (time() < $job_details->sla_milestone) ? "text-success" : "text-danger" ?>
                        <span id="timer" class="<?php echo $time_class;?>"></span>
                         
                        <!--<b class="<?php echo $time_class; ?>"> 
                            <script>
                                document.write(moment('<?php echo date("Y-m-d H:i", $job_details->sla_milestone); ?>').endOf('minutes').fromNow())
                            </script>
                        </b>--> <br/>
                    </h4>
                    <h4 class="text-right">Project Status: <b class="text-success"><?php echo $job_status; ?></b></h4>
                </div>
            </div>
            <?php if(($user_type_id == 1 || !empty($is_job_submmitted)) && $job_status != 'Cancelled') { ?>
                <div class="row">
                    <div class="col-md-3 col-md-offset-9">
                        <div class="form-group">
                            <a class="btn btn-danger center-block" href="<?php echo base_url('dashboard/job/cancel_job') . '/' . $job_id; ?>">
                                Cancel Order
                            </a>
                        </div>
                    </div>

                </div>
                <hr>
            <?php } ?>
            <?php
            if (($user_type_id == 1 || !empty($is_job_submmitted)) && empty($approved_quote)) {
                include 'common/job_supplier_quotes.php';
            }
            ?>
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Job Details</a></li>
                    <?php if (($user_type_id == 1 || !empty($is_job_submmitted))) { ?>
                        <li><a data-toggle="tab" href="#menu1">Shipping Details</a></li>
                    <?php } ?>
                    <li><a data-toggle="tab" href="#menu2">Job History</a></li>

                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-8 ">
                                <h3>Job Details</h3> 
                                <?php include 'common/job_details.php'; ?>
                            </div>

                            <?php if (!empty($is_job_allocated)) { ?>
                                <div class="col-md-4 ">
                                    <?php include 'common/supplier_quote_form.php'; ?>
                                </div>
                            <?php } ?>
                            <?php if ($user_type_id == 4) { ?>
                                <div class="col-md-4 ">
                                    <?php include 'common/freight_quote_form.php' ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php include 'common/job_update_form.php' ?>
                    </div>
                    <?php if (($user_type_id == 1 || !empty($is_job_submmitted))) { ?>
                        <div id="menu1" class="tab-pane fade">              
                            <?php include 'common/job_shipping.php'; ?>
                        </div>
                    <?php } ?>
                        <div id="menu2" class="tab-pane fade">
                            <h3>Job History</h3>
                            <?php include 'common/job_history.php'; ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>