<script>
    $(function () {
        $('.btnView').on('click', function () {
            var fqid = $(this).attr('rel');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('order') . '/'; ?>view_freight_quote",
                data: {fq_id: fqid},
                dataType: 'html'
            })
                    .done(function (msg) {
                        //alert( "Data :" + msg );
                        $('.view_freight_quote').html(msg);
                    });
        });
    });
</script>
<?php if (!empty($freight_quotes)) { ?>

    <div class="row">
        <?php
        $count = 1;
        foreach ($freight_quotes as $quote) {
            ?>
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix"><h4 class="badge"><?php echo $count++; ?></h4> <?php echo $quote->freight_forwarder_name; ?>
                        <div class="pull-right"><img src="http://placehold.it/40x40"></div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"> Total Shipment Cost ex.Tax: <strong><?php echo $quote->shipment_total_cost_ex_tax; ?></strong></li>
                        <li class="list-group-item"> Transit Time: <strong><?php echo date("F j, Y g:i a", $quote->transit_time); ?></strong></li>

                        <li class="list-group-item clearfix"> 
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a class="btn btn-blue btnView" rel="<?php echo $quote->fq_id; ?>"  data-toggle="modal" data-target="#freight-quote">View </a>
                                    <?php if ($quote->is_approved == 0) { ?>
                                        <a class="btn btn-success" href="<?php echo base_url() . 'dashboard/order/approve_freight_quote' . '/' . $quote->fq_id . '/' . $quote->job_id; ?>"> Approve </a>
                                    <?php } //else {  ?> 
                             <!--   <a  class="btn btn-danger" href="<?php //echo base_url() . 'dashboard/order/reject_quote' . '/' . $quote->fq_id . '/' . $quote->job_id;  ?>">Reject  </a>-->
                                    <?php //}  ?>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>


            </div>
        <?php } ?>

    </div>
<?php } ?>

<!---- All the supplier quotes will be below and open when clicked on "View Quote: -->
<!-- Supplier Quote -->
<div class="modal fade" id="freight-quote" role="dialog">
    <div class="modal-dialog view_freight_quote">

        <!-- Quote content-->

    </div>
</div>
<!------------End of all supplier quotes----------------->