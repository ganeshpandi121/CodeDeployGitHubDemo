<script>
    var supplierquoteController = {
        supplierquoteValidation: function () {

            $('#unit_volume').parent().removeClass("has-error has-danger");
            $('#price_per_unit').parent().removeClass("has-error has-danger");
            $('#total_order').parent().removeClass("has-error has-danger");
            $('#currency').parent().removeClass("has-error has-danger");
            $('#payment_term').parent().removeClass("has-error has-danger");
            $('#incoterm_id').parent().removeClass("has-error has-danger");
            $('#lead_time').parent().removeClass("has-error has-danger");
            $('#sample_lead_time').parent().removeClass("has-error has-danger");

            var error = "";

            if (isNaN($('#unit_volume').val()) || $('#unit_volume').val() == "") {
                error += "Please enter unit volume in number<br/>";
                $('#unit_volume').parent().addClass("has-error has-danger");
            }

            if (isNaN($('#price_per_unit').val()) || $('#price_per_unit').val() == "") {
                error += "Please enter price per unit in number<br/>";
                $('#price_per_unit').parent().addClass("has-error has-danger");
            }

            if (isNaN($('#total_order').val()) || $('#total_order').val() == "") {
                error += "Please enter total order in number<br/>";
                $('#total_order').parent().addClass("has-error has-danger");
            }

            if ($('#currency option:selected').val() == "0") {
                error += "Please select currency<br/>";
                $('#currency').parent().addClass("has-error has-danger");
            }

            if ($('#payment_term').val() == "") {
                error += "Please enter payment term<br/>";
                $('#payment_term').parent().addClass("has-error has-danger");
            }

            if ($('#incoterm_id option:selected').val() == "0") {
                error += "Please select incoterm<br/>";
                $('#incoterm_id').parent().addClass("has-error has-danger");
            }

            if ($('#lead_time').val() == "") {
                error += "Please enter lead time<br/>";
                $('#lead_time').parent().addClass("has-error has-danger");
            }

            if ($('#pre_approved_sample_checkbox').val() == "1") {
                if ($('#sample_lead_time').val() == "") {
                    error += "Please enter sample lead time<br/>";
                    $('#sample_lead_time').parent().addClass("has-error has-danger");
                }
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

    $(function () {
        $('#price_per_unit,#unit_volume').on('change', function () {
            var unit = $('#unit_volume').val();
            var price_per_unit = $('#price_per_unit').val();
            var res, total_amount;
            if (unit != "" && price_per_unit != "") {
                if ((!isNaN(unit)) && (!isNaN(price_per_unit))) {
                    res = unit * price_per_unit;
                    tot = Math.round(res * 100) / 100;
                    total_amount = tot.toFixed(2);
                    $('#total_order').val(total_amount);
                } else {
                    Messages.error("Please enter number only!");
                }
            }
        });

        $('#lead_time').on('blur', function () {
            var re = /^\d{4}\-\d{1,2}\-\d{1,2}?$/;
            var thisVal = $(this).val();
            var curDate = new Date();
            var curr_date = ((curDate.getDate().length+1) === 1)? (curDate.getDate()+1) : '0' + (curDate.getDate());
            var curr_month = ((curDate.getMonth().length+1) === 1)? (curDate.getMonth()+1) : '0' + (curDate.getMonth()+1);
            var curr_year = curDate.getFullYear();
            var dd = curr_year+"-"+curr_month+"-"+curr_date;
            var error = "";
            if (thisVal != "") {
               if (!re.test(thisVal)) {
                error +="Please enter date format in <b> YYYY-mm-dd </b><br/>";
               }
               if (thisVal < dd) {
                error += "Project Lead Time cannot be less than current date <br/>";
               }
            }

            if (error) {
                Messages.error(error);
                $(this).val("");
            }
        });
        $('#sample_lead_time').on('blur', function () {
            var re = /^\d{4}\-\d{1,2}\-\d{1,2}?$/;
            var thisVal = $(this).val();
            var curDate = new Date();
            var curr_date = ((curDate.getDate().length+1) === 1)? (curDate.getDate()+1) : '0' + (curDate.getDate());
            var curr_month = ((curDate.getMonth().length+1) === 1)? (curDate.getMonth()+1) : '0' + (curDate.getMonth()+1);
            var curr_year = curDate.getFullYear();
            var dd = curr_year+"-"+curr_month+"-"+curr_date;
            var error = "";
            if (thisVal != "") {
               if (!re.test(thisVal)) {
                error +="Please enter date format in <b> YYYY-mm-dd </b><br/>";
               }
               if (thisVal < dd) {
                error += "Sample Lead Time cannot be less than current date <br/>";
               }
            }
            if (error) {
                Messages.error(error);
                $(this).val("");
            }
        });

    });
</script>

<?php
$show_alert = 'style="display:none;"';
if ($this->session->flashdata('error_msg') == true) {
    $show_alert = 'style="display:block;"';
}
?>

<?php
echo form_open(base_url() . 'dashboard/job/submit_quote', array('id' => 'submit_quote_form', 'method' => 'post', 'onsubmit' => 'return supplierquoteController.supplierquoteValidation()'));
$jq_id = !empty($supplier_quote_for_job[0]->jq_id) ? $supplier_quote_for_job[0]->jq_id : '';
$job_id = $job_details->job_id;
echo form_hidden('jq_id', $jq_id);
echo form_hidden('job_id', $job_id);
?>

<table class="table table-bordered ">
    <tr>
        <th colspan="2">
            <div class="row">
                <div class="col-md-12 text-center center-block">
                    <h4 class="badge" style="font-size: 20px">
                        <?php echo!empty($supplier_quote_for_job[0]->rank) ? $supplier_quote_for_job[0]->rank : ''; ?>
                    </h4>

                    <img width="40px" height="40px" src = '<?php echo base_url() . "styles/images/default.png"; ?>'>
                </div>
            </div>

            </p>
        </th>
    </tr>
    <tr class="alert alert-danger" >
        <td colspan="2" id="quote_alert"  <?php echo $show_alert; ?>>
            <?php echo $this->session->flashdata('error_msg'); ?>
        </td>
    </tr>
    <tr>
        <th width='40%'>Unit Volume <b class="text-danger">*</b></th>
        <td >
            <div class="form-group"> 
                <?php
                $unit_volume = !empty($supplier_quote_for_job[0]->unit_volume) ? $supplier_quote_for_job[0]->unit_volume : '';
                echo form_number('unit_volume', $unit_volume, array('id' => 'unit_volume', 'placeHolder' => 'Add Unit Volume ', 'min' => '1', 'max' => '999999999'));
                ?>
            </div> 
        </td>
    </tr>
    <tr>
        <th>Price Per Unit <b class="text-danger">*</b></th>
        <td>
            <div class="form-group"> 
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <?php
                    $price_per_unit = !empty($supplier_quote_for_job[0]->price_per_unit) ? $supplier_quote_for_job[0]->price_per_unit : '';

                    echo form_number('price_per_unit', $price_per_unit, array('id' => 'price_per_unit', 'placeHolder' => 'Add Price Per Unit', 'min' => '0', 'max' => '999999999', 'step' => 'any'));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Total Order (ex Tax) <b class="text-danger">*</b></th>
        <td>
            <div class="form-group"> 
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <?php
                    $total_order = !empty($supplier_quote_for_job[0]->total_order) ? $supplier_quote_for_job[0]->total_order . ".00" : '';
                    echo form_input('total_order', $total_order, array('id' => 'total_order', 'placeHolder' => 'Add Total Order ', 'readonly' => 'true'));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Currency <b class="text-danger">*</b></th>
        <td>
            <div class="form-group"> 
                <input type="hidden" name="currency" id="currency" value="142">
                <select class="form-control" name="currency_veiw" id="currency_view" disabled="true">
                    <option value="0">-- Select --</option>
                    <?php
                    $supplier_currency_id = !empty($supplier_quote_for_job[0]->currency_id) ? $supplier_quote_for_job[0]->currency_id : '142';
                    foreach ($currencies as $currency) {
                        if ($currency->currency_id == $supplier_currency_id) {
                            echo "<option value=" . $currency->currency_id . " selected>" . $currency->currency_name . "</option>";
                        } else {
                            echo "<option value=" . $currency->currency_id . ">" . $currency->currency_name . "</option>";
                        }
                    }
                    ?>

                </select>
            </div>
        </td>
    </tr>
    <tr>
        <th>Payment Terms <b class="text-danger">*</b></th>
        <td>
            <div class="form-group"> 
                <?php
                $payment_term = !empty($supplier_quote_for_job[0]->payment_term) ? $supplier_quote_for_job[0]->payment_term : '';
                echo form_textarea(array('id' => 'payment_term', 'rows' => '2', 'placeHolder' => 'Add Payment Terms ', 'name' => 'payment_term'), $payment_term);
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <th>Incoterms <b class="text-danger">*</b></th>
        <td><div class="form-group">
                <input type="hidden" name="incoterm_id" id="incoterm_id" value="1">
                <select class="form-control" name="incoterm_id_view" id="incoterm_id_view" disabled="true">
                    <?php
                    $supplier_incoterm_id = !empty($supplier_quote_for_job[0]->incoterm_id) ? $supplier_quote_for_job[0]->incoterm_id : '';
                    foreach ($incoterms as $incoterm) {
                        if ($incoterm->incoterm_id == $supplier_incoterm_id) {
                            echo "<option value=" . $incoterm->incoterm_id . " selected>" . $incoterm->incoterm_name . "</option>";
                        } else {
                            echo "<option value=" . $incoterm->incoterm_id . ">" . $incoterm->incoterm_name . "</option>";
                        }
                    }
                    ?>
                </select>
            </div></div></td>
    </tr>
    <tr>
        <th>Project Lead Time <b class="text-danger">*</b></th>
        <td>
            <?php
            $lead_time = NULL;
            if (!empty($supplier_quote_for_job[0]->lead_time)) {

                $lead_time = date('Y-m-d', $supplier_quote_for_job[0]->lead_time);
            }
            ?>
            <div class="form-group has-feedback">                     
                <input size="16" type="text" name="lead_time" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" value="<?php echo $lead_time; ?>" id = "lead_time" placeHolder = "Add Lead Time" class="form_datetime form-control">
                <i class = " glyphicon glyphicon-calendar form-control-feedback"></i>


            </div>
            <script type="text/javascript">
                var dateNow = new Date();
                $(".form_datetime").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month'});
            </script>

        </td>
    </tr>
    <?php
    if ($job_details->is_sample_required == 1) {
        ?>

        <tr>
            <th>Pre-Approved

                Samples <b class="text-danger">*</b></th>
            <td>
                <div class="form-group"> 
                    <?php
                    echo form_hidden('pre_approved_sample', "1");
                    $check = TRUE;
                    echo bootstrap_checkbox('pre_approved_sample_checkbox', "checkbox-inline no-indent text-capitalize", 1, "Select checkbox to confirm", $check, array("disabled" => "true", "id" => "pre_approved_sample_checkbox"));
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <th>Samples Lead Time <b class="text-danger">*</b></th>
            <td>
                <?php
                $sample_lead_time = NULL;

                if (!empty($supplier_quote_for_job[0]->sample_lead_time)) {

                    $sample_lead_time = date('Y-m-d', $supplier_quote_for_job[0]->sample_lead_time);
                }
                ?>

                <div class="form-group has-feedback">                     
                    <input name="sample_lead_time" size="16" type="datetime" name="sample_lead_time" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" value="<?php echo $sample_lead_time ?>" id = "sample_lead_time" placeHolder = "Add sample lead time" class="form_datetime form-control">
                    <i class = "glyphicon glyphicon-calendar form-control-feedback"></i>

                    <script type="text/javascript">
                        var dateNow = new Date();
                        $(".form_datetime").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month'});
                    </script>      
                </div>

                </div>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <th>Additional Information</th>
        <td>
            <div class="form-group"> 
                <?php
                $additional_information = !empty($supplier_quote_for_job[0]->additional_information) ? $supplier_quote_for_job[0]->additional_information : '';
                echo form_textarea(array('id' => 'additional_information', 'rows' => '2', 'placeHolder' => 'Add Addition Information', 'name' => 'additional_information'), $additional_information);
                ?>
            </div>
        </td>
    </tr>



</table>
<div class="row">
    <div class="col-md-12 ">  
        <div class="form-group">
            <?php
            if (isset($supplier_quote_for_job[0])) {
                $jq_id = !empty($supplier_quote_for_job[0]->jq_id) ? : '';
                $button_label = "Edit Quote";
            } else {
                $button_label = "Submit Quote";
            }
            ?>
            <?php
            if ($this->session->userdata('is_vetted') == 0) {
                $user_id = $this->session->userdata('user_id');
                $url = base_url('dashboard/job/notify_demo_seller') . '/' . $user_id . '/' . $job_id;
                ?>
                <a href="javascript:void(0);" class="btn btn-warning" data-toggle="popover" 
                   title="You are a demo user" 
                   data-html="true" 
                   data-trigger="focus"
                   data-content="You are currently logged in as Demo mode. 
                   To place a bid and start winning orders, as well as receiving advanced functionality. 
                   Request a package from our sales to begin by clicking 
                   <a href='<?php echo $url; ?>'>here</a>.">
                    Submit Quote
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </a>

            <?php } else { ?>
            <input type="submit" id="submit_quote" name="submit_button" class="btn btn-warning" value="<?php echo $button_label; ?>" />

            <?php } ?>


            <?php if (isset($supplier_quote_for_job[0]) && $this->session->userdata('is_vetted') == 1) { ?>
                <a class="btn btn-success chat" onclick="Chat.chatBoxOpen(<?php echo $supplier_quote_for_job[0]->jq_id ?>, <?php echo $this->session->userdata('user_id'); ?>, '<?php echo $job_user_data->user_first_name. ' '.$job_user_data->user_last_name; ?>',<?php echo $job_user_data->user_id; ?>)" data-value="<?php echo $supplier_quote_for_job[0]->jq_id ?>">chat</a>
<?php } ?>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

    <?php if (!empty($this->session->flashdata('error_msg'))) { ?>
    <div class="alert alert-danger text-center">
    <?php echo $this->session->flashdata('error_msg'); ?>
    </div>
    <?php
}
?>
