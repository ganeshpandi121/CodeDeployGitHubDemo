<?php if (!empty($approved_quote)) { ?>
    <h3>Commercial Terms</h3>
    <table class="table table-bordered ">
        <tr>
            <th colspan="2">
                <div class="row">
                    <?php 
                    if (!empty($approved_quote->company_logo_path)) {
                        $logo = base_url() . "uploads/company/" . $approved_quote->company_logo_path;
                    } else {
                        $logo = base_url() . "styles/images/default.png";
                    }?>
                    
                    <div class="col-md-2">
                        <img width="40px" height="40px" src = '<?php echo $logo; ?>'>
                    </div>
                    <?php if (!empty($is_job_allocated)) {?>
                        <div class="col-md-10">
                            <p class="text-left">   <?php echo $approved_quote->supplier_name; ?></p>
                        </div>

                    <?php }  if (($user_type_id == 1 || !empty($is_job_submmitted))){ ?>
                        <div class="col-md-5">
                            <p class="text-center">   <?php echo $approved_quote->supplier_name; ?></p>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="btn btn-blue center-block" data-toggle="modal" data-target="#supplier-details">Seller Details </a>
                            </div>
                        </div>
                    <?php }  ?>
                </div>
            </th>
        </tr>
        <tr>
            <th width='40%'>Unit Volume  </th>
            <td ><?php echo $approved_quote->unit_volume; ?></td>
        </tr>
        <tr>
            <th>Price Per Unit</th>
            <td>$<?php echo $approved_quote->price_per_unit; ?></td>
        </tr>
        <tr>
            <th>Total Order (ex Tax)</th>
            <td>$<?php echo $approved_quote->total_order; ?>
            </td>
        </tr>
        <tr>
            <th>Currency</th>
            <td><?php echo $approved_quote->currency_name; ?></td>
        </tr>
        <tr>
            <th>Payment Terms</th>
            <td><?php echo $approved_quote->payment_term; ?></td>
        </tr>
        <tr>
            <th>Incoterms </th>
            <td><a href='javascript:void(0);' data-toggle='popover' 
                   title="Incoterm - Ex Works" 
                   data-html="true" 
                   data-trigger="focus"
                   data-content="Ex works means that the seller fulfils his 
                   obligation to deliver when he has made the goods available at 
                   his premises (i.e. works, factory, warehouse, etc) to the buyer. 
                   <a href='https://en.wikipedia.org/wiki/Incoterms#EXW_.E2.80.93_Ex_Works_.28named_place_of_delivery.29' target='_blank'>Click here to know more.</a>"
                   <span style="font-size: 14px" class="glyphicon glyphicon-info-sign text-primary" aria-hidden="true"></span>
                </a> <?php echo $approved_quote->incoterm_name; ?></td>
        </tr>
        <tr>
            <th>Project Lead Time</th>
            <td><?php echo date("F j, Y", $approved_quote->lead_time); ?></td>
        </tr>
        <?php if (!empty(($approved_quote->pre_approved_sample))) {
            ?>
            <tr>
                <th>Pre-Approved Samples</th>
                <td><?php echo ($approved_quote->pre_approved_sample) ? "Yes" : "No"; ?></td>
            </tr>
            <tr>
                <th>Samples Lead Time</th>
                <td><?php echo date("F j, Y", $approved_quote->sample_lead_time); ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th>Additional Information</th>
            <td><?php echo $approved_quote->additional_information; ?></td>
        </tr>

    </table>
<?php } ?>