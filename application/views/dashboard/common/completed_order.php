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
                <?php if (!empty($job_details->completed_time)) { ?>
                    <h4 class="text-right">Completed Time:
                        <?php echo date("F j, Y", $job_details->completed_time); ?>
                    </h4>
                <?php } ?>
                <h4 class="text-right">
                    Project Status: <b class="text-success"> <?php echo $job_status; ?></b>
                </h4>
            </div>
        </div>
        <?php if (!empty($this->session->flashdata('success_msg'))) { ?>
            <div class="alert alert-success text-center">
                <?php echo $this->session->flashdata('success_msg'); ?>
            </div>
        <?php } else if (!empty($this->session->flashdata('error_msg'))) { ?>

            <div class="alert alert-danger text-center">
                <?php echo $this->session->flashdata('error_msg'); ?>
            </div>

        <?php } ?>
        <?php if (($user_type_id == 1 || !empty($is_job_submmitted)) && $job_status == 'Cancelled') { ?>
            <div class="row">
                <div class="col-md-3 col-md-offset-10">
                    <a class="btn btn-blue" data-toggle="modal" data-target="#re-do-job">
                        Reactivate Order
                    </a>
                </div>
                <br/>
            </div>
            <?php include 're_do_job_popup.php'; ?>
        <?php } ?>
        <?php if (($user_type_id == 1 || !empty($is_job_submmitted)) && $job_status == 'Completed') { ?>
            <div class="row">
                <div class="col-md-3 col-md-offset-10">
                    <a class="btn btn-blue" data-toggle="modal" data-target="#re-do-job">
                        Reorder
                    </a>
                </div>
                <br/>
            </div>
            <?php include 're_do_job_popup.php'; ?>
        <?php } ?>
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
                            <?php include 'order_details.php'; ?>
                        </div>
                        <div class="col-md-4 ">

                            <?php
                            include 'supplier_quote_details.php';
                            if (($user_type_id == 1 || !empty($is_job_submmitted))) {
                                include 'job_supplier_details.php';
                            }
                            ?>
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


                </div>
                <div id="menu1" class="tab-pane fade">

                    <?php
                    include 'job_shipping.php';
                    ?>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Job history</h3>
                    <?php include 'job_history.php'; ?>
                </div>
            </div>
        </div>

        <!-- This is completed order page -->

    </div>
</div>
