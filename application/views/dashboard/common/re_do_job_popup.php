<script>
    var reactivateController = {
        reactivateValidation: function () {

            $('#product_lead_time').parent().removeClass("has-error has-danger");
            $('#sla_milestone').parent().removeClass("has-error has-danger");
            var error = "";

            if ($('#product_lead_time').val() == "") {
                error += "Please enter project lead time<br/>";
                $('#product_lead_time').parent().addClass("has-error has-danger");
            }

            if ($('#sla_milestone').val() == "") {
                error += "Please select SLA<br/>";
                $('#sla_milestone').parent().addClass("has-error has-danger");
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
        $('#product_lead_time').on('blur', function () {
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
        $('#sla_milestone').on('blur', function () {
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
                error += "SLA Date cannot be less than current date <br/>";
               }
            }
            if (error) {
                Messages.error(error);
                $(this).val("");
            }
        });
    });
</script>
<div class="modal" id="re-do-job" role="dialog">
    <div class="modal-dialog re-do-job">

        <div class="modal-content">
            <?php
            $action = '';
            if ($job_status == 'Completed') {
                $url = base_url() . "dashboard/order/re-order";
                $action = 'Reorder';
            } else if ($job_status == 'Cancelled') {
                $url = base_url() . "dashboard/order/re-activate";
                $action = 'Reactivate Order';
            }
            ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $action; ?> - Edit Details</h4>
            </div>
            <?php
            echo form_open($url, array('method' => 'post', "class" => "form-horizontal", 'onsubmit' => 'return reactivateController.reactivateValidation()'));
            echo form_hidden('job_id', $job_id);
            echo form_hidden('consumer_id', $job_details->cd_id);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6"> 
                            <?php
                            echo form_label("Project Lead Time", "product_lead_time");
                            ?>
                            <div class=" has-feedback">
                                <input  type="text" id="product_lead_time" value="" name="product_lead_time" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
                                <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                            </div>
                            <script type="text/javascript">
                                var dateNow = new Date();
                                $("#product_lead_time").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month'});
                            </script>

                        </div>
                        <div class="col-md-6"> 
                            <?php echo form_label("I want my project to start on", "sla_milestone"); ?>
                            <div class=" has-feedback">
                                <input  type="text" id="sla_milestone" value="" name="sla_milestone" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add SLA Time" class="form-control" />
                                <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                            </div>
                            <script type="text/javascript">
                                var dateNow = new Date();
                                $("#sla_milestone").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month', daysOfWeekDisabled: '0,6'});
                            </script>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="<?php echo $action; ?>" />
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>