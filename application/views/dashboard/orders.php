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
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">

                <h5 class="text-muted ">Order ID :<b class="text-primary">#<?php
                        if (!empty($job_details)) {
                            echo $job_details->job_id;
                        }
                        ?> </b></h5>
                <p class="text-muted "> Created  on <b class="text-primary"><?php
                        if (!empty($job_details)) {
                            echo date("F j, Y", $job_details->created_date);
                        }
                        ?></b></p>
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
                    <span id="timer" class="<?php echo $time_class;?>"></span> <br/>
                </h4>
                <h4 class="text-right">Project Status: <b class="text-success"><?php echo $job_status; ?></b></h4>
            </div>
        </div>
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
        <?php if (($user_type_id == 1 || !empty($is_job_submmitted)) && $job_status != 'Cancelled' && $job_status != 'Completed') { ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <a class="btn btn-danger center-block" href="<?php echo base_url('dashboard/job/cancel_job') . '/' . $job_id; ?>">
                            Cancel Order
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if (($user_type_id == 1 || !empty($is_job_submmitted)) && $job_status != 'Completed' && !empty($quote_approved)) { ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <a class="btn btn-success center-block" href="<?php echo base_url('dashboard/order/complete_job') . '/' . $job_id; ?>">
                            Complete Order
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        /* Not being used
         * if ($user_type_id == 2 && !empty($freight_quotes)) {
          // if (!empty($is_freight_already_approved)) {
          include 'common/job_freight_quotes.php';
          // }
          } */
        ?>
        <div class="container">
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Job Details</a></li>
                    <li><a data-toggle="tab" href="#menu1">Shipping Details</a></li>
                    <li><a data-toggle="tab" href="#menu2">Job history</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        
                        <div class="row">
                            <div class="col-md-12 text-center">

                                <!-- Progress Bar-->
                            </div>
                            <div class="col-md-8 ">
                                <h3>Job Details</h3>
                                <?php include 'common/order_details.php'; ?>
                            </div>
                            <div class="col-md-4 ">
                                <?php
                                include 'common/supplier_quote_details.php';
                                if (($user_type_id == 1 || !empty($is_job_submmitted))) {
                                    include 'common/job_supplier_details.php';
                                    /*  if ($job_status == 'Freight Ready') {
                                      ?>

                                      <!---     <div class="form-group">
                                      <a class="btn btn-primary center-block" href="<?php echo base_url('dashboard/order/request_freight_quote') . '/' . $job_id; ?>">Request a quote for Freight</a>
                                      </div> -->
                                      <?php
                                      } */
                                }
                                ?>
                            </div>

                            <div class="col-md-4 ">
                                <?php if (!empty($approved_freight_quote)) { ?>
                                    <table class="table table-bordered ">
                                        <tr>
                                            <th colspan="2">
                                                <p class="text-center"> <img src="http://placehold.it/40x40"> Freight Quote</p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width='40%'>Total Cost of Shipment Ex. Tax </th>
                                            <td ><?php echo $approved_freight_quote->shipment_total_cost_ex_tax; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Cost of Shipment Inc. Tax</th>
                                            <td><?php echo $approved_freight_quote->shipment_total_cost_inc_tax; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping Method</th>
                                            <td><?php echo $approved_freight_quote->shipping_method_name; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Currency</th>
                                            <td><?php echo $approved_freight_quote->currency_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipment Nett Weight</th>
                                            <td><?php echo $approved_freight_quote->shipment_nett_weight; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipment Gross Weight</th>
                                            <td><?php echo $approved_freight_quote->shipment_gross_weight; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Incoterm</th>
                                            <td><?php echo $approved_freight_quote->incoterm_name; ?></td>
                                        </tr>

                                        <tr>
                                            <th>Transit Time</th>
                                            <td><?php echo $approved_freight_quote->transit_time; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Additional Note</th>
                                            <td><?php echo $approved_freight_quote->additional_notes; ?></td>
                                        </tr>

                                    </table>
                                <?php } ?>
                                <?php
                                if ($user_type_id == 1 || !empty($is_job_submmitted)) {
                                    include 'common/job_freight_details.php';
                                    ?>
                                <?php } ?>
                            </div>
                        </div>

                        <?php if (!empty($consumer_job_updates)) { ?>
                            <table class="table table-bordered ">
                                <tr>
                                    <th colspan="2">
                                        <p class="text-center"> Updates</p>
                                    </th>
                                </tr>

                                <?php foreach ($consumer_job_updates as $item) { ?>
                                    <tr>
                                        <td>
                                            <p><b>Submitted By: </b><?php echo $item['user_first_name'] . ' ' . $item['user_last_name']; ?></p>
                                            <p><b>Comment: </b>
                                                <?php echo $item['description']; ?></p>

                                            <?php if (!empty($item['job_file_id'])) { ?>

                                                <?php foreach ($item['job_file_id'] as $file) { ?>
                                                    <b>File Details: </b>

                                                    <p>File Type: <?php echo $file->file_type_name; ?> <br>
                                                        File: <a href="<?php echo base_url('job/download_job_file') . '/' . $file->job_file_id; ?>"><?php echo $file->file_name; ?></a><br>
                                                        Created Time: <?php echo date("F j, Y g:i a", $file->file_created_date); ?></p>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>   
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } ?>
                        <?php include 'common/job_update_form.php' ?>    

                    </div>
                    <div id="menu1" class="tab-pane fade">

                        <?php
                        include 'common/job_shipping.php';
                        ?>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Job history</h3>
                        <?php
                        include 'common/job_history.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- This is order progress page -->


    </div>
</div>
