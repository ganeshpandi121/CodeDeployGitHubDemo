<script>
var freightquoteController = {  
    freightquoteValidation: function () {   
           
            $('#total_shipment_ex_tax').parent().removeClass("has-error has-danger");
            $('#total_shipment_inc_tax').parent().removeClass("has-error has-danger");            
            $('#shipping_method').parent().removeClass("has-error has-danger");
            $('#incoterm_id').parent().removeClass("has-error has-danger");
            $('#net_weight').parent().removeClass("has-error has-danger"); 
            $('#gross_weight').parent().removeClass("has-error has-danger");
            $('#transit_time').parent().removeClass("has-error has-danger");
            
            var error = ""; 
            
            if(isNaN($('#total_shipment_ex_tax').val()) || $('#total_shipment_ex_tax').val() == ""){
                error += "Please enter total shipment excluding tax in number<br/>";
                $('#total_shipment_ex_tax').parent().addClass("has-error has-danger"); 
            }  
            
            if(isNaN($('#total_shipment_inc_tax').val()) || $('#total_shipment_inc_tax').val() == ""){
                error += "Please enter total shipment including tax in number<br/>";
                $('#total_shipment_inc_tax').parent().addClass("has-error has-danger"); 
            } 
            
            if ($('#shipping_method option:selected').val() == "0") {
                error += "Please select shipping method<br/>";
                $('#shipping_method').parent().addClass("has-error has-danger");
            }
            
            if ($('#incoterm_id option:selected').val() == "0") {
                error += "Please select incoterm<br/>";
                $('#incoterm_id').parent().addClass("has-error has-danger");
            }
             
            if ($('#net_weight').val() == ""){
                error += "Please enter net weight<br/>";
                $('#net_weight').parent().addClass("has-error has-danger"); 
            }
            
            if($('#gross_weight').val() == ""){
                error += "Please enter gross weight<br/>";
                $('#gross_weight').parent().addClass("has-error has-danger"); 
            }
            
            if($('#transit_time').val() == ""){
                error += "Please enter transit time<br/>";
                $('#transit_time').parent().addClass("has-error has-danger"); 
            } 
            
            
                        
            if (error) {
                //$("#quote_alert").html(error).show();
                Messages.error(error);
                return false;
            } else {   
                return true;
            }

        }
    }
</script>
    <?php if (!empty($this->session->flashdata('error_msg'))) { ?>
        <div class="alert alert-danger text-center">
            <?php echo $this->session->flashdata('error_msg'); ?>
        </div>
    <?php } ?>
    <?php echo form_open(base_url() . 'dashboard/job/submit_freight_quote', array('id' => 'submit_freight_form', 'onsubmit' => 'return freightquoteController.freightquoteValidation()')); ?> 
    <?php echo form_hidden('job_id', $this->uri->segment(3)) ?>
    <table class="table table-bordered ">
        <tr>
            <th colspan="2">
                <p class="text-center"> <img src="http://placehold.it/40x40"> Freight Quote</p>
            </th>
        </tr>
        <tr>
            <th width='40%'>Total Cost of Shipment excluding Tax <b> *</b></th>
            <td >
                <div class="form-group"> 
                    <?php echo form_input('total_shipment_ex_tax', '', array('id' => 'total_shipment_ex_tax', 'placeHolder' => 'Total Cost of Shipment ex Tax ')); ?>
                </div> 
            </td>
        </tr>
        <tr>
            <th width='40%'>Total Cost of Shipment including Tax <b> *</b></th>
            <td >
                <div class="form-group"> 
                    <?php echo form_input('total_shipment_inc_tax', '', array('id' => 'total_shipment_inc_tax', 'placeHolder' => 'Total Cost of Shipment including Tax ')); ?>
                </div> 
            </td>
        </tr>
        <tr>
            <th>Shipping Method <b> *</b></th>
            <td>
                <div class="form-group"> 

                    <select class="form-control" name="shipping_method" id="shipping_method">
                        <option value="0">-- Select --</option>
                        <?php
                        foreach ($shipping_methods as $shipping_method) {
                            echo "<option value=" . $shipping_method->shipping_method_id . ">" . $shipping_method->shipping_method_name . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <th>Incoterms <b> *</b></th>
            <td><div class="form-group"> 
                    <select class="form-control" name="incoterm_id" id="incoterm_id">
                        <?php
                        foreach ($incoterms as $incoterm) {
                            echo "<option value=" . $incoterm->incoterm_id . ">" . $incoterm->incoterm_name . "</option>";
                        }
                        ?>
                    </select>
                </div></div></td>
        </tr>
        <tr>
            <th>Net Weight of Shipment <b> *</b></th>
            <td>
                <div class="form-group"> 
                    <?php echo form_input('net_weight', '', array('id' => 'net_weight', 'placeHolder' => 'Net Weight of Shipment')); ?>
                </div>
            </td>
        </tr>
        <tr>
            <th>Gross Weight of Shipment <b> *</b></th>
            <td>
                <div class="form-group"> 
                    <?php echo form_input('gross_weight', '', array('id' => 'gross_weight', 'placeHolder' => 'Gross Weight of Shipment')); ?>
                </div>
            </td>
        </tr>  
        <tr>
            <th>Transit Time (From collection to delivery) <b> *</b></th>
            <td>
                <div class="form-group"> 
                    <?php echo form_input('transit_time', '', array('id' => 'transit_time', 'placeHolder' => 'Transit Time (From collection to delivery)')); ?>
                </div>
            </td>
        </tr>  
        ·         									<tr>
            <th>Additional Notes </th>
            <td>
                <div class="form-group"> 
                    <?php echo form_textarea(array('id' => 'additional__notes', 'rows' => '2', 'placeHolder' => 'Additional Notes ', 'name' => 'additional_notes'), '');
                    ?>
                </div>
            </td>
        </tr>

    </table> 
    <div class="row">
        <div class="col-md-12 ">  
            <div class="form-group">
                <?php echo form_submit('submit_button', 'Submit Quote', array('class' => 'btn btn-warning', 'type' => 'submit')); ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
