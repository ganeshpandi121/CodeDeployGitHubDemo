<script>
    var freightcostValidator = {
        frieghtcostValidation: function () {
            $('#freight_quote_cost').parent().removeClass("has-error has-danger");
            var error = "";
            if ($('#freight_quote_cost').val() == '') {
                error += "Please enter Freight Quote Cost.<br/>";
                $('#freight_quote_cost').parent().addClass("has-error has-danger");

            }


            if (error) {
                Messages.error(error);
                return false;
            } else {
                return true;
            }
        }
    }
    $(function () {
        $('.btnView').on('click', function () {
            var jqid = $(this).attr('rel');
            var jobid = $(this).attr('data');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('job') . '/'; ?>view_supplier_quote",
                data: {
                    jq_id: jqid,
                    job_id: jobid
                },
                dataType: 'html'
            })
                    .done(function (msg) {
                        //alert( "Data :" + msg );
                        $('.view_supplier_quote').html(msg);
                    });
        });
        $('.show_seller_info').on('click', function () {
            var sellerid = $(this).attr('data');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('job') . '/'; ?>seller_info_popup",
                data: {
                    sellerid: sellerid
                },
                dataType: 'html',
                success: function (response) {
                    $('.view_supplier_info').html(response);
                }
            })

        });
    });

</script>

<?php if (!empty($job_quotes)) { ?>

    <div class="row">
        <?php
        $count = 1;
        foreach ($job_quotes as $quote) {
            ?>
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <h4 class="badge"><?php echo $quote->rank; ?></h4> 
                        <?php echo $quote->supplier_name; ?> 
                        <div class="pull-right">
                            <?php
                            if ($user_type_id == 1 || !empty($is_job_submmitted)) {?>
                                <a class="btn center-block show_seller_info" data-toggle="modal" 
                                   data-target="#supplier-info" data="<?php echo $quote->user_id ?>" >
                                    <span style="color: #fff; font-size: 24px" 
                                          class="glyphicon glyphicon-info-sign" 
                                          aria-hidden="true"></span> </a>
                                <?php } ?>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"> Price per unit: 
                            <strong>$<?php echo $quote->price_per_unit; ?></strong></li>
                        <li class="list-group-item">Project Lead Time: 
                            <strong><?php echo date("F j, Y", $quote->lead_time); ?></strong></li>
                        <li class="list-group-item"> Total value (ex Tax): 
                            <strong>$<?php echo $quote->total_order; ?></strong></li>
                        <?php if ($shipping_details->is_require_delivery != 0) {
                            ?>
                            <li class="list-group-item"> Freight Cost: 
                                <strong>$<?php echo ($quote->freight_quote_cost != 0) ? $quote->freight_quote_cost : "0"; ?></strong></li>
                            <?php
                        } else {
                            echo '<li class="list-group-item">Ex works Only</li>';
                        }
                        ?>

                        <li class="list-group-item text-info text-center"><b> Total Cost: <strong>$<?php echo $quote->total_cost; ?></b></strong></li>
                        <li class="list-group-item clearfix"> 
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a class="btn btn-warning btnView" data="<?php echo $quote->job_id; ?>" rel="<?php echo $quote->jq_id; ?>"  data-toggle="modal" data-target="#supplier-quote">View </a>
                                    <?php
                                    if ($quote->is_approved == 0) {

                                        $disable = (time() < $job_details->sla_milestone) ? "disabled" : "";
                                        $disable_till = (time() < $job_details->sla_milestone) ? "Approve button Disabled till " . date("F j, Y g:i a", $job_details->sla_milestone) : "Approve Button is Enabled";
                                        $approve_button_url = base_url() . 'dashboard/job/approve_quote' . '/' . $quote->jq_id . '/' . $quote->job_id;
                                        ?>


                                        <a class="btn btn-success <?php echo $disable ?>" href="#" onclick="return Messages.confirm('Are you sure that you want to confirm?', '<?php echo $approve_button_url; ?>')"> Approve </a>
                                    <?php } //else {     ?> 
                                    <!-- Removing reject button for time being -->
                                   <!-- <a  class="btn btn-danger" href="<?php // echo base_url() . 'dashboard/job/reject_quote' . '/' . $quote->jq_id . '/' . $quote->job_id;                                                            ?>">Reject  </a>-->
                                    <?php //}    ?>
                                    <?php //echo $disable_till;  ?>

                                    <a class="btn btn-success chat" onclick="Chat.chatBoxOpen(<?php echo $quote->jq_id ?>, <?php echo $this->session->userdata('user_id'); ?>, '<?php echo $quote->supplier_name; ?> ', '<?php echo $quote->user_id; ?>')" data-value="<?php echo $quote->jq_id ?>">chat</a>
                                </div>
                            </div>
                        </li>
                        <?php
                        if ($user_type_id == 1) {

                            if ($shipping_details->is_require_delivery != 0) {
                                ?>
                                <li class="list-group-item">Freight Quote Cost
                                    <form action= "<?php echo base_url(); ?>dashboard/job/freight_cost_submit" method="post" onsubmit="return freightcostValidator.frieghtcostValidation();">
                                        <input type="hidden" name="job_id" value='<?php echo $quote->job_id; ?>' />
                                        <input type="hidden" name="jq_id" value='<?php echo $quote->jq_id; ?> ' />
                                        <input type="hidden" name="total_order" value='<?php echo $quote->total_order; ?> ' />
                                        <div class="form-group">
                                            <input type="number" min="1" max="10000000" class="form-control" placeHolder ="Freight Quote Cost" value="" id ="freight_quote_cost" name="freight_quote_cost" />
                                        </div>
                                        <input type="submit" value="Save" class="btn btn-primary" name="save" />

                                    </form></li>
                                <?php
                            } else {
                                echo '<li class="list-group-item">Shipping not required</li>';
                            }
                        }
                        ?>
                    </ul>
                    <div class="panel-heading clearfix">
                        <?php if (!empty($quote->total_cost_rank)) { ?> 
                            <h4 class="badge"><?php echo $quote->total_cost_rank; ?></h4>
                            Overall Rank
                        <?php } ?>

                    </div>
                </div>


            </div>
        <?php } ?>

    </div>
<?php } ?>

<!---- All the supplier quotes will be below and open when clicked on "View Quote: -->
<!-- Supplier Quote -->
<div class="modal fade" id="supplier-quote" role="dialog">
    <div class="modal-dialog view_supplier_quote">

        <!-- Quote content-->

    </div>
</div>

<!-- Supplier Quote -->
<div class="modal fade" id="supplier-info" role="dialog">
    <div class="modal-dialog view_supplier_info">

        <!-- seller data -->

    </div>
</div>
<!------------End of all supplier quotes----------------->
