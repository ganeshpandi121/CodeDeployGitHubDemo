<div class="modal" id="edit-job" role="dialog">
    <div class="modal-dialog edit_job">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit Job Details</h4>
            </div>
            <?php
            echo form_open(base_url() . "dashboard/edit_job", array('method' => 'post', "class" => "form-horizontal", 'onsubmit' => 'return editjobController.editjobValidation()'));
            echo form_hidden('job_id', $job_id);
            echo form_hidden('consumer_id', $job_details->cd_id);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Category", "category_name"); ?>
                            <select class="form-control" name="category" id="category" onchange="getSubcategories()">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($categories as $category) {
                                    $selected = ($category->cat_id == $job_details->cat_id) ? 'selected="selected"' : "";
                                    echo '<option value="' . $category->cat_id . '" ' . $selected . ' >' . $category->category_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">   
                            <?php echo form_label('Sub Category', 'sub_categrory'); ?>
                            <select class="form-control" name="sub-category" id="sub-category">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($sub_categories as $sub_category) {
                                    $selected = ($sub_category->sub_cat_id == $job_details->sub_cat_id) ? 'selected="selected"' : "";
                                    echo '<option value="' . $sub_category->sub_cat_id . '" ' . $selected . '>' . $sub_category->sub_category_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">   
                            <?php
                            echo form_label("Project Name", "job_name");
                            echo form_input('job_name', $job_details->job_name, array('class' => 'form-control', 'id' => 'job_name', 'placeHolder' => 'Project Name', 'max-length' => '100'));
                            ?>

                        </div>
                        <div class="col-md-6"> 
                            <?php
                            echo form_label("Product Quantity", "product_quantity");
                            echo form_number('product_quantity', $job_details->product_quantity, array('id' => 'product_quantity', 'placeHolder' => 'Quantity', 'min' => '1', 'max' => '100000000'));
                            ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">   
                            <?php
                            echo form_label('Project Overview ', 'job_overview');
                            echo form_textarea(array('name' => 'job_overview', 'id' => 'job_overview', 'value' => $job_details->job_overview, 'rows' => '2', 'placeHolder' => 'Project Overview '));
                            ?>

                        </div>
                        <div class="col-md-6">   
                            <?php
                            echo form_label('Project Details ', 'description');
                            echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $job_details->note, 'rows' => '2', 'placeHolder' => 'Project Details '));
                            ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <?php echo form_label("Project Lead Time", "post_code"); ?>
                            <div class=" has-feedback">
                                <input  type="text" id="product_lead_time" value="<?php echo date('Y-m-d', $job_details->product_lead_time); ?>" name="product_lead_time" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
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
                                <input  type="text" id="sla_milestone" value="<?php echo date('Y-m-d', $job_details->sla_milestone); ?>" name="sla_milestone" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
                                <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                            </div>
                            <script type="text/javascript">
                                var dateNow = new Date();
                                $("#sla_milestone").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month', daysOfWeekDisabled: '0,6'});
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <?php
                            echo form_label("Budget", "expected_amount");
                            echo form_number('expected_amount', $job_details->budget, array('id' => 'expected_amount', 'placeHolder' => 'Budget', 'min' => '0', 'max' => '100000000'));
                            ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Maximize Your Project", "maximize_your_budget"); ?>
                            <br>
                            <?php
                            $chk_sealed = ($job_details->is_sealed == 1) ? 'checked' : '';
                            $chk_sample = ($job_details->is_sample_required == 1) ? 'checked' : '';
                            ?>
                            <input type="checkbox" name="is_sealed" id="is_sealed" value="1" <?php echo $chk_sealed; ?>>   Sealed/Tender
                            <br>
                            <input type="checkbox" name="is_sample_required" id="is_sample_required" value="1" <?php echo $chk_sample; ?>>  Sample required
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo form_label("Special Requirements", "post_code");
                            echo form_textarea(array('id' => 'special_requirement', 'name' => 'special_requirement', 'value' => $job_details->special_requirement, 'rows' => '3', 'placeHolder' => 'Please add special requirements.'));
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save" />
            </div>
            <?php echo form_close(); ?>
        </div>


    </div>
</div>