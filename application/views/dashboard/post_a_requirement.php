<script>
    var baseurl = "<?php echo base_url(); ?>";
    function getSubcategories() {
        //$('#detailed-quote').hide();
        $catID = $('#category').val();
        if (($catID >= 1) && ($catID <= 4))
        {
            $('#show-detailed-quote-option').show();
            <?php if(!empty($job_additional_details)){ ?>
            $('#detailed-quote').show();           
            <?php }?>
        } else
        {
            $('#show-detailed-quote-option').hide();
            $('#detailed-quote').hide();
        }
        $.ajax({
            type: "POST",
            url: baseurl + "ajax/get_sub_categories ",
            data: {
                "categoryID": $catID,
                "isAjax": true
            },
            dataType: 'json',
            success: function (data) {

                var select = $("#sub-category"), options = '';
                select.empty();

                for (var i = 0; i < data.length; i++)
                {
                    options += "<option value='" + data[i].sub_cat_id + "'>" + data[i].sub_category_name + "</option>";
                }

                select.append(options);
            }
        });
    }
    $(function () {
        $('#is_urgent').on('click', function () {
            if ($('#is_urgent').prop('checked') == true) {
                $('#sla_milestone').val(24);
                $('#sla_milestone_new').val(24);
                $('#sla_milestone').prop('disabled', true);
            } else {
                $('#sla_milestone').val(24);
                $('#sla_milestone_new').val(24);
                $('#sla_milestone').prop('disabled', false);
            }
        });
        $('#product_lead_time').on('blur', function () {
            var re = /^\d{4}\-\d{1,2}\-\d{1,2} ?$/;
            var thisVal = $(this).val();
            var curDate = new Date();
            //var testDate = new Date(thisVal);
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
        $('#sla_milestone1').on('blur', function () {
            var re = /^\d{4}\-\d{1,2}\-\d{1,2} ?$/;
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
    $(function () {
        $("#add_special_requirement_button").click(function () {
            if ($("#special_requirement_box").attr("class") == 'hidden')
            {
                $("#special_requirement_box").removeClass('hidden');
            } else
            {
                $("#special_requirement_box").addClass('hidden');
            }
            return false;
        });
    });
</script>
<script src="<?php echo $this->config->base_url(); ?>styles/js/projectvalidation.js"></script>
<div class="container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2><?php echo $page_title; ?></h2>
                    </div>
                </div>
                <?php echo !empty($error_msg) ? $error_msg : ''; ?>

                <?php
                $show_alert = 'style="display:none;"';
                if ($this->session->flashdata('error_msg') == true) {
                    $show_alert = 'style="display:block;"';
                }
                ?>
                <div class="alert alert-danger" id="postproject_alert" <?php echo $show_alert; ?>>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo form_open_multipart(base_url() . 'dashboard/submit_requirement', array('id' => 'requirement_form', 'onsubmit' => 'return postprojectController.postprojectValidation()')); ?> 
                <?php
                $job_id = (!empty($job_id)) ? $job_id : "";
                $cd_id = (!empty($job_details->cd_id)) ? $job_details->cd_id : "";
                echo form_hidden('job_id', $job_id);
                echo form_hidden('consumer_id', $cd_id);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <label>Category</label>

                        <select class="form-control" name="category" id="category" onchange="getSubcategories()">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($categories as $category) {
                                $selected = (!empty($job_details->cat_id) && ($category->cat_id == $job_details->cat_id)) ? 'selected="selected"' : "";
                                echo "<option value=" . $category->cat_id . " " . $selected . ">" . $category->category_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Sub Category</label>
                        <select class="form-control" name="sub-category" id="sub-category">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($sub_categories as $sub_category) {
                                $selected = (!empty($job_details->sub_cat_id) && ($sub_category->sub_cat_id == $job_details->sub_cat_id)) ? 'selected="selected"' : "";
                                echo "<option value=" . $sub_category->sub_cat_id . " " . $selected . ">" . $sub_category->sub_category_name . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_label("Project Name", "job_name"); ?>
                        <?php
                        $job_name = (!empty($job_details->job_name)) ? $job_details->job_name : "";
                        echo form_input('job_name', $job_name, array('class' => 'form-control', 'id' => 'job_name', 'placeHolder' => 'Project Name', 'max-length' => '100'));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Project Overview ', 'job_overview');
                        $job_overview = (!empty($job_details->job_overview)) ? $job_details->job_overview : "";
                        echo form_textarea(array('name' => 'job_overview', 'id' => 'job_overview', 'value' => $job_overview, 'rows' => '3', 'placeHolder' => 'Project Overview '));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php
                            echo form_label("Product Quantity", "product_quantity");
                            $product_quantity = (!empty($job_details->product_quantity)) ? $job_details->product_quantity : "";
                            echo form_number('product_quantity', $product_quantity, array('id' => 'product_quantity', 'placeHolder' => 'Quantity', 'min' => '1', 'max' => '100000000'));
                            ?>
                        </div> 
                    </div>
                </div>
                <?php $flagQuote = (!empty($job_details) && (($job_details->cat_id >= 1) && ($job_details->cat_id <= 4)))? "block" : "none";?>
                <div id="show-detailed-quote-option" style="display: <?php echo $flagQuote;?>">
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <div class="form-group text-center">
                                <?php
                                if (empty($job_additional_details)) {
                                    $chkquick = "checked";
                                    $chkdetailed = "";
                                } else {
                                    $chkquick = "";
                                    $chkdetailed = "checked";
                                }
                                ?>
                                <label class="radio-inline">
                                    <input type="radio" name="quote_type" id="quote_type_1" value="1" 

                                           onchange="$('#detailed-quote').hide();$('#detailed-quote').css({border: 'none'});"     <?php echo $chkquick; ?>> 
                                    Quick Quote
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="quote_type" id="quote_type_2" value="2" <?php echo $chkdetailed; ?> onchange="$('#detailed-quote').show(); $('#detailed-quote').css({border: '1px solid #47abe6'}).animate({padding: '10px'}, 500);">  Detailed Quote
                                </label>
                                <?php $jad_id = (!empty($job_additional_details) && $job_additional_details->jad_id) ? $job_additional_details->jad_id : ""; ?>
                                <input type="hidden" name="additional_id" value="<?php echo $jad_id; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <?php $flagquick = (!empty($job_additional_details) ) ? "block;border: 1px solid #47abe6;padding: 10px" : "none"; ?>
                <div id="detailed-quote" style="display: <?php echo $flagquick; ?>;">
                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("DETAILED QUOTE", "detailed_quote"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("PRODUCT", "product"); ?>
                        </div>
                    </div>

                    <label>Plastic</label>
                    <div class="row">

                        <div class="col-md-6">
                            <?php $plastic_id = (!empty($job_additional_details->plastic_id)) ? $job_additional_details->plastic_id : ""; ?>
                            <select class="form-control" name="plastic_id" id="plastic_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($plastic as $plastics) {
                                    $selected = ($plastic_id == $plastics->plastic_id) ? "selected" : "";
                                    echo "<option value=" . $plastics->plastic_id . " $selected>" . $plastics->plastic_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php $plastic_other = (!empty($job_additional_details->plastic_other)) ? $job_additional_details->plastic_other : ""; ?>
                            <?php echo form_input('plastic_other', $plastic_other, array('id' => 'plastic_other', 'placeHolder' => 'Others', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <label>Thickness</label>
                    <div class="row">
                        <div class="col-md-6">
                            <?php $thickness_id = (!empty($job_additional_details->thickness_id)) ? $job_additional_details->thickness_id : ""; ?>
                            <select class="form-control" name="thickness_id" id="thickness_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($thickness as $individual_thickness) {
                                    $selected = ($thickness_id == $individual_thickness->thickness_id) ? "selected" : "";
                                    echo "<option value=" . $individual_thickness->thickness_id . " $selected>" . $individual_thickness->thickness_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php $thickness_other = (!empty($job_additional_details->thickness_other)) ? $job_additional_details->thickness_other : ""; ?>
                            <?php echo form_input('thickness_other', $thickness_other, array('id' => 'thickness_other', 'placeHolder' => 'Others', 'max-length' => '100')); ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("PRINTING", "printing"); ?><br>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("CMYK", "cmyk_id"); ?>
                            <?php $cmyk_id = (!empty($job_additional_details->cmyk_id)) ? $job_additional_details->cmyk_id : ""; ?>
                            <select class="form-control" name="cmyk_id" id="cmyk_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($cmyk as $individual_cmyk) {
                                    $selected = ($cmyk_id == $individual_cmyk->cmyk_id) ? "selected" : "";
                                    echo "<option value=" . $individual_cmyk->cmyk_id . " $selected>" . $individual_cmyk->cmyk_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Metalic Ink", "metallic_ink_id"); ?>
                            <?php $metallic_ink_id = (!empty($job_additional_details->metallic_ink_id)) ? $job_additional_details->metallic_ink_id : ""; ?>
                            <select class="form-control" name="metallic_ink_id" id="metallic_ink_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($metallic_ink as $individual_metallic_ink) {
                                    $selected = ($metallic_ink_id == $individual_metallic_ink->metallic_ink_id) ? "selected" : "";
                                    echo "<option value=" . $individual_metallic_ink->metallic_ink_id . " $selected>" . $individual_metallic_ink->metallic_ink_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <?php echo form_label("Pantone Colours", "pantone_colours"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php $pantone_front_color = (!empty($job_additional_details->pantone_front_color)) ? $job_additional_details->pantone_front_color : ""; ?>
                            <?php echo form_input('pantone_front_color', $pantone_front_color, array('id' => 'pantone_front_color', 'placeHolder' => 'Add Pantone Front Colour', 'max-length' => '100')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php $pantone_reverse_color = (!empty($job_additional_details->pantone_reverse_color)) ? $job_additional_details->pantone_reverse_color : ""; ?>
                            <?php echo form_input('pantone_reverse_color', $pantone_reverse_color, array('id' => 'pantone_reverse_color', 'placeHolder' => 'Add Pantone Reverse Colour', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <div class="form-group form-inline"> 
                                <?php echo form_label("Special Finish", "special_finish"); ?>
                                <br>
                                <?php
                                $scented_ink = (!empty($job_additional_details->scented_ink)) ? "checked" : "";
                                $uv_link = (!empty($job_additional_details->uv_ink)) ? "checked" : "";
                                $raised_surface = (!empty($job_additional_details->raised_surface)) ? "checked" : "";
                                ?> 
                                <input type="checkbox" id="scented_ink" name="scented_ink" value="1" <?php echo $scented_ink; ?>> Scented Ink
                                <input type="checkbox" id="uv_ink" name="uv_ink" value="1" <?php echo $uv_link; ?>>  UV Ink
                                <input type="checkbox" id="raised_surface" name="raised_surface" value="1" <?php echo $raised_surface; ?>> Raised Surface
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("ADDITIONAL FEATURES", "additional_features"); ?><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Magnetic Tape", "magnetic_tape_id"); ?>
                            <br><br>
                            <?php $magnetic_tape_id = (!empty($job_additional_details->magnetic_tape_id)) ? $job_additional_details->magnetic_tape_id : ""; ?>
                            <select class="form-control" name="magnetic_tape_id" id="magnetic_tape_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($magnetic_tape as $individual_magnetic_tape) {
                                    $selected = ($magnetic_tape_id == $individual_magnetic_tape->magnetic_tape_id) ? "selected" : "";
                                    echo "<option value=" . $individual_magnetic_tape->magnetic_tape_id . " $selected>" . $individual_magnetic_tape->magnetic_tape_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Personalization (Thermal or Drop On Demand)", "personalization_id"); ?>
                            <?php $personalization_id = (!empty($job_additional_details->personalization_id)) ? $job_additional_details->personalization_id : ""; ?>
                            <select class="form-control" name="personalization_id" id="personalization_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($personalization as $individual_personalization) {
                                    $selected = ($personalization_id == $individual_personalization->personalization_id) ? "selected" : "";
                                    echo "<option value=" . $individual_personalization->personalization_id . " $selected>" . $individual_personalization->personalization_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-inline"> 
                                <?php $chk = (!empty($job_additional_details->magnetic_strip_encoding)) ? "checked" : ""; ?>
                                <input type="checkbox" id="magnetic_strip_encoding" name="magnetic_strip_encoding" value="1" <?php echo $chk; ?>> Magnetic Strip Encoding<br>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-inline"> 
                                <?php $chk = (!empty($job_additional_details->scratch_off_panel)) ? "checked" : ""; ?>
                                <input type="checkbox" id="scratch_off_panel" name="scratch_off_panel" value="1" <?php echo $chk; ?>> Scratch-Off Panel<br>

                            </div>
                        </div>
                    </div>
                    <?php echo form_label("Signature Panel", "signature_panel"); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Front Signature Panel", "front_signature_panel_id"); ?>
                            <?php $personalization_id = (!empty($job_additional_details->personalization_id)) ? $job_additional_details->personalization_id : ""; ?>
                            <select class="form-control" name="front_signature_panel_id" id="front_signature_panel_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($front_signature_panel as $individual_front) {
                                    $selected = ($personalization_id == $individual_front->front_signature_panel_id) ? "selected" : "";
                                    echo "<option value=" . $individual_front->front_signature_panel_id . " $selected>" . $individual_front->front_signature_panel_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Reverse Signature Panel ", "reverse_signature_panel_id"); ?>
                            <?php $reverse_signature_panel_id = (!empty($job_additional_details->reverse_signature_panel_id)) ? $job_additional_details->reverse_signature_panel_id : ""; ?>
                            <select class="form-control" name="reverse_signature_panel_id" id="reverse_signature_panel_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($reverse_signature_panel as $individual_reverse) {
                                    $selected = ($reverse_signature_panel_id == $individual_reverse->reverse_signature_panel_id) ? "selected" : "";
                                    echo "<option value=" . $individual_reverse->reverse_signature_panel_id . " $selected>" . $individual_reverse->reverse_signature_panel_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Embossing", "embossing_id"); ?>
                            <?php $embossing_id = (!empty($job_additional_details->embossing_id)) ? $job_additional_details->embossing_id : ""; ?>
                            <select class="form-control" name="embossing_id" id="embossing_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($embossing as $individual_embossing) {
                                    $selected = ($embossing_id == $individual_embossing->embossing_id) ? "selected" : "";
                                    echo "<option value=" . $individual_embossing->embossing_id . ">" . $individual_embossing->embossing_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Hotstamping", "hotstamping_id"); ?>
                            <?php $hotstamping_id = (!empty($job_additional_details->hotstamping_id)) ? $job_additional_details->hotstamping_id : ""; ?>
                            <select class="form-control" name="hotstamping_id" id="hotstamping_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($hotstamping as $individual_hotstamping) {
                                    $selected = ($hotstamping_id == $individual_hotstamping->hotstamping_id) ? "selected" : "";
                                    echo "<option value=" . $individual_hotstamping->hotstamping_id . " $selected>" . $individual_hotstamping->hotstamping_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Hologram", "hologram_id"); ?>
                            <?php $hologram_id = (!empty($job_additional_details->hologram_id)) ? $job_additional_details->hologram_id : ""; ?>
                            <select class="form-control" name="hologram_id" id="hologram_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($hologram as $individual_hologram) {
                                    $selected = ($hologram_id == $individual_hologram->hologram_id) ? "selected" : "";
                                    echo "<option value=" . $individual_hologram->hologram_id . " $selected>" . $individual_hologram->hologram_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Hologram - Others", "hologram_other"); ?>
                            <?php $hologram_other = (!empty($job_additional_details->hologram_other)) ? $job_additional_details->hologram_other : ""; ?>
                            <?php echo form_input('hologram_other', $hologram_other, array('id' => 'hologram_other', 'placeHolder' => 'Add Other Hologram types', 'max-length' => '100')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-inline padding-10"> 
                                <?php $chk = (!empty($job_additional_details->fulfillment_service_required)) ? "checked" : ""; ?>
                                <input type="checkbox" id="fulfillment_service_required" name="fulfillment_service_required" value="1" <?php echo $chk; ?>> Fulfillment Service Required <br>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center ">
                            <?php echo form_label("CARD HOLDER", "card_holder"); ?><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <?php $chk = (!empty($job_additional_details->card_holder)) ? "checked" : ""; ?>
                            <input  type="checkbox" id="card_holder" name="card_holder" value="1" <?php echo $chk; ?>> Card Holder<br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Dimensions", "dimensions"); ?>
                            <?php $dimensions = (!empty($job_additional_details->dimensions)) ? $job_additional_details->dimensions : ""; ?>
                            <?php echo form_input('dimensions', $dimensions, array('id' => 'dimensions', 'placeHolder' => 'Add Dimesnion', 'max-length' => '100')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("GSM", "gsm"); ?>
                            <?php $gsm = (!empty($job_additional_details->gsm)) ? $job_additional_details->gsm : ""; ?>
                            <?php echo form_input('gsm', $gsm, array('id' => 'gsm', 'placeHolder' => 'Add GSM', 'max-length' => '100')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Finish", "finish_id"); ?>
                            <?php $finish_id = (!empty($job_additional_details->finish_id)) ? $job_additional_details->finish_id : ""; ?>
                            <select class="form-control" name="finish_id" id="finish_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($finish as $individual_finish) {
                                    $selected = ($finish_id == $individual_finish->finish_id) ? "selected" : "";
                                    echo "<option value=" . $individual_finish->finish_id . " $selected>" . $individual_finish->finish_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <br><br>
                            <?php $chk = (!empty($job_additional_details->attach_card_with_glue)) ? "checked" : ""; ?>
                            <input type="checkbox" id="attach_card_with_glue" name="attach_card_with_glue" value="1" <?php echo $chk; ?>> Attach Card with Glue<br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Bundling Required", "bundling_required_id"); ?>
                            <?php $bundling_required_id = (!empty($job_additional_details->bundling_required_id)) ? $job_additional_details->bundling_required_id : ""; ?>
                            <select class="form-control" name="bundling_required_id" id="bundling_required_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($bundling_required as $individual_bundling_required) {
                                    $selected = ($bundling_required_id == $individual_bundling_required->bundling_required_id) ? "selected" : "";
                                    echo "<option value=" . $individual_bundling_required->bundling_required_id . " $selected>" . $individual_bundling_required->bundling_required_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "bundling_required_other"); ?>
                            <?php $bundling_required_other = (!empty($job_additional_details->bundling_required_other)) ? $job_additional_details->bundling_required_other : ""; ?>
                            <?php echo form_input('bundling_required_other', $bundling_required_other, array('id' => 'bundling_required_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("MODULE TYPE / CHIPSET", "module_chipset"); ?><br>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Contactless Chip", "contactless_chip_id"); ?>
                            <?php $contactless_chip_id = (!empty($job_additional_details->contactless_chip_id)) ? $job_additional_details->contactless_chip_id : ""; ?>
                            <select class="form-control" name="contactless_chip_id" id="contactless_chip_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($contactless_chip as $individual_contactless_chip) {
                                    $selected = ($contactless_chip_id == $individual_contactless_chip->contactless_chip_id) ? "selected" : "";
                                    echo "<option value=" . $individual_contactless_chip->contactless_chip_id . " $selected>" . $individual_contactless_chip->contactless_chip_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "contactless_chip_other"); ?>
                            <?php $contactless_chip_other = (!empty($job_additional_details->contactless_chip_other)) ? $job_additional_details->contactless_chip_other : ""; ?>
                            <?php echo form_input('contactless_chip_other', $contactless_chip_other, array('id' => 'contactless_chip_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Contact Chip", "contact_chip_id"); ?>
                            <?php $contact_chip_id = (!empty($job_additional_details->contact_chip_id)) ? $job_additional_details->contact_chip_id : ""; ?>
                            <select class="form-control" name="contact_chip_id" id="contact_chip_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($contact_chip as $individual_contact_chip) {
                                    $selected = ($contact_chip_id == $individual_contact_chip->contact_chip_id) ? "selected" : "";
                                    echo "<option value=" . $individual_contact_chip->contact_chip_id . " $selected>" . $individual_contact_chip->contact_chip_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "contact_chip_other"); ?>
                            <?php $contact_chip_other = (!empty($job_additional_details->contact_chip_other)) ? $job_additional_details->contact_chip_other : ""; ?>
                            <?php echo form_input('contact_chip_other', $contact_chip_other, array('id' => 'contact_chip_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center padding-10">
                            <?php echo form_label("PUNCHING", "punching"); ?><br>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Key Tag", "key_tag_id"); ?>
                            <?php $key_tag_id = (!empty($job_additional_details->key_tag_id)) ? $job_additional_details->key_tag_id : ""; ?>
                            <select class="form-control" name="key_tag_id" id="key_tag_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($key_tag as $individual_key_tag) {
                                    $selected = ($key_tag_id == $individual_key_tag->key_tag_id) ? "selected" : "";
                                    echo "<option value=" . $individual_key_tag->key_tag_id . " $selected>" . $individual_key_tag->key_tag_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <br>
                            <?php $chk = (!empty($job_additional_details->key_hole_punching)) ? "checked" : ""; ?>
                            <input type="checkbox" id="key_hole_punching" name="key_hole_punching" value="1" <?php echo $chk; ?>> Key Hole Punching<br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_label("Unique Card Size", "unique_card_size"); ?>
                            <?php $unique_card_size = (!empty($job_additional_details->unique_card_size)) ? $job_additional_details->unique_card_size : ""; ?>
                            <?php echo form_input('unique_card_size', $unique_card_size, array('id' => 'unique_card_size', 'placeHolder' => 'Add unique card size', 'max-length' => '100')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Project Lead Time</label>
                        <div class="form-group has-feedback">
                            <?php $product_lead_time = (!empty($job_details->product_lead_time)) ? date('Y-m-d', $job_details->product_lead_time) : ""; ?>
                            <input  type="text" id="product_lead_time" name="product_lead_time" value="<?php echo $product_lead_time; ?>" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
                            <i class="glyphicon glyphicon-calendar form-control-feedback"></i>

                        </div>
                        <script type="text/javascript">
                            var dateNow = new Date();
                            $("#product_lead_time").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month'});
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Project Details ', 'description');
                        $note = (!empty($job_details->note)) ? $job_details->note : "";
                        echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $note, 'rows' => '3', 'placeHolder' => 'Project Details '));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><br>
                        <a href="#" id="add_special_requirement_button">Click to add special requirements</a>
                        <div class="hidden" id="special_requirement_box">
                            <?php
                            $special_requirement = (!empty($job_details->special_requirement)) ? $job_details->special_requirement : "";
                            echo form_textarea(array('id' => 'special_requirement', 'name' => 'special_requirement', 'value' => $special_requirement, 'rows' => '3', 'placeHolder' => 'Please add special requirements.'));
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="position: inline-block">
                        <br>
                        <?php echo form_label("Upload Files", "job_file"); ?>
                        <?php echo form_upload('job_file', '', array('id' => 'job_file', 'onchange' => 'return ValidateFileUpload(this)')); ?>
                    </div>
                </div>
                <div class="row"  style="display:none;">
                    <div class="col-md-12">
                        <label>File Type</label>
                        <select class="form-control" name="file_type">
                            <option value="1">General</option>
                            <option value="2">Sample</option>
                        </select>
                    </div>
                </div>
                <div clarr="row" >
                    <div class="col-md-12">
                        <b>Do you require delivery</b>
                        <div class="form-group">

                            <label class="radio-inline">
                                <?php
                                if (!empty($shipping_details) && $shipping_details->is_require_delivery == 1) {
                                    $chk_req = 'checked';
                                    $chk_notreq = "";
                                } else {
                                    $chk_req = "";
                                    $chk_notreq = 'checked';
                                }
                                ?>

                                <input type="radio" name="delivery_required" id="delivery_required_1" value="1" <?php echo $chk_req; ?> onchange="$('#shipping_forms').show();" > 
                                Yes 
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="delivery_required" id="delivery_required_2" value="2" <?php echo $chk_notreq; ?> onchange="$('#shipping_forms').hide();" >  No
                            </label>
                        </div>
                    </div>    
                </div>
                <?php $flag = ($chk_req != "") ? "block" : "none"; ?>
                <div class="row" id="shipping_forms" style="display: <?php echo $flag; ?> ;">
                    <div class="col-md-12">
                        Do you require delivery via
                        <div class="checkbox">
                            <?php $chk = (!empty($shipping_details->is_courier)) ? 'checked' : ''; ?>
                            <label><input type="checkbox" name="is_courier" value="1" <?php echo $chk; ?>>Courier</label>
                        </div>
                        <div class="checkbox">
                            <?php $chk = (!empty($shipping_details->is_air_freight)) ? 'checked' : ''; ?>
                            <label><input type="checkbox" name="is_air_freight" value="1" <?php echo $chk; ?>>Air Freight</label>
                        </div>
                        <div class="checkbox disabled">
                            <?php $chk = (!empty($shipping_details->is_sea_freight)) ? 'checked' : ''; ?>
                            <label><input type="checkbox" name="is_sea_freight" value="1" <?php echo $chk; ?>>Sea Freight</label>
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <?php
                        if (!empty($shipping_details->to_address_id)) {
                            $other_address = 'checked';
                            $my_address = "";
                        } else {
                            $other_address = "";
                            $my_address = 'checked';
                        }
                        ?>
                        <label class="radio-inline">
                            <input type="radio" name="my_address" id="my_address_1" value="1" <?php echo $my_address; ?>  onchange="$('#shipping_address').hide();" checked> 
                            Ship to my Address
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="my_address" id="my_address_other" value="2" <?php echo $other_address; ?>  onchange="$('#shipping_address').show();">   Ship to other Address
                        </label>
                        <?php $address_id = (!empty($shipping_details->to_address_id)) ? $shipping_details->to_address_id : ''; ?>
                        <input type="hidden" id="addressid" name="addressid" value="<?php echo $address_id; ?>"/>
                    </div>
                    <?php $address_flag = (!empty($shipping_details->to_address_id)) ? "block" : "none"; ?>
                    <div class="col-md-12" id="shipping_address" style="display: <?php echo $address_flag; ?>;">
                        <div class="form-group"> 
                            <h5><b>Shipping Address Details</b></h5>
                            <?php
                            echo form_label("Address Title", "address_name");
                            $address_name = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->address_name)) ? $get_shipping_to_address->address_name : '';
                            echo form_input('address_name', $address_name, array('id' => 'address_name', 'placeHolder' => 'Add Name'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php
                            echo form_label('Street Address', 'street_address');
                            $street_address = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->street_address)) ? $get_shipping_to_address->street_address : '';
                            echo form_textarea(array('id' => 'street_address', 'rows' => '3', 'placeHolder' => 'Add Street Address', 'name' => 'street_address'), $street_address);
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php
                            echo form_label("City", "city");
                            $city = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->city)) ? $get_shipping_to_address->city : '';
                            echo form_input('city', $city, array('id' => 'city', 'placeHolder' => 'Add City'));
                            ?>
                        </div> 
                        <div class="form-group"> 
                            <?php
                            echo form_label("State", "state");
                            $state = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->state)) ? $get_shipping_to_address->state : '';
                            echo form_input('state', $state, array('id' => 'state', 'placeHolder' => 'Add State'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <label>Country</label>
                            <?php
                            ?>
                            <select class="form-control" name="country_id" id="country">
                                <?php
                                usort($countries, function($a, $b) {
                                    return $a->country_name > $b->country_name;
                                });
                                foreach ($countries as $country) {
                                    if ($get_shipping_to_address->country_id == $country->country_id) {
                                        $selected = "selected='selected'";
                                    } else {
                                        $selected = "";
                                    }
                                    $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : '';
                                    if ($address->country_id == $country->country_id) {
                                        echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "' $selected>$country->country_name</option>";
                                    } else {
                                        echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "' $selected>$country->country_name</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            echo form_label("Phone Code", "telephone_code");
                            usort($countries, function($a, $b) {
                                return $a->telephone_code - $b->telephone_code;
                            });
                            ?>
                            <select class="form-control" name="telephone_code" id="telephone_code">
                                <?php
                                echo "<option value=''>None</option>";

                                foreach ($countries as $country) {
                                    $next = $country->telephone_code;
                                    if ($next == $prev)
                                        continue;
                                    if (!empty($country->telephone_code)) {
                                        $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : NULL;
                                        $address_telephone_code = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->telephone_code)) ? $get_shipping_to_address->telephone_code : '';
                                        if ($address_telephone_code == $country->telephone_code) {
                                            $selected = "selected='selected'";
                                        } else {
                                            $selected = "";
                                        }

                                        echo '<option value="' . $telephone_code . '" ' . $selected . '>' . $telephone_code . '</option>';
                                    }
                                    $prev = $country->telephone_code;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            echo form_label("Phone Number", "telephone_no");
                            $telephone_no = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address->telephone_no)) ? $get_shipping_to_address->telephone_no : '';
                            echo form_input('telephone_no', $telephone_no, array('id' => 'telephone_no', 'placeHolder' => 'Add Phone Number'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php
                            echo form_label("Zip Code", "post_code");
                            $post_code = (!empty($shipping_details->to_address_id) && !empty($get_shipping_to_address)) ? $get_shipping_to_address->post_code : '';
                            echo form_input('post_code', $post_code, array('id' => 'post_code', 'placeHolder' => 'Add Zip Code'));
                            ?>
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_label("Budget", "expected_amount"); ?>
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <?php
                                $budget = (!empty($job_details->budget)) ? $job_details->budget : "";
                                echo form_number('expected_amount', $budget, array('id' => 'expected_amount', 'placeHolder' => 'Budget', 'min' => '0', 'max' => '100000000'));
                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php
                            echo form_label("Maximize Your Project", "maximize_your_budget");
                            $chk_sealed = (!empty($job_details) && $job_details->is_sealed == 1) ? 'checked' : '';
                            $chk_sample = (!empty($job_details) && $job_details->is_sample_required == 1) ? 'checked' : '';
                            ?>
                            <br>
                            <?php if (empty($job_details)) { ?>
                                <input type="checkbox" name="is_urgent" id="is_urgent" value="1">   Urgent: Requires 24 hour start time, quotes need Immediately<br>
                            <?php } ?>
                            <div style="display:none" ><input type="checkbox" name="is_sealed" id="is_sealed" value="1" <?php echo $chk_sealed; ?> >   Sealed/Tender
                                <br></div>
                            <input type="checkbox" name="is_sample_required" id="is_sample_required" value="1" <?php echo $chk_sample; ?> >  Sample required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_label("I want my project start in", "sla_milestone"); ?>
                            <?php if (empty($job_details)) { ?>
                                <select class="form-control" name="sla_milestone_1" id="sla_milestone" onchange="$('#sla_milestone_new').val($(this).val())">
                                    <option value="24">24 hours</option>
                                    <option value="48">48 hours</option>
                                </select>
                                <input type="hidden" name="sla_milestone" id="sla_milestone_new" value="24">
                                <?php
                            } else {
                                $sla_milestone = (!empty($job_details->sla_milestone)) ? $job_details->sla_milestone : "";
                                ?>
                                <div class=" has-feedback">
                                    <input  type="text" id="sla_milestone1" value="<?php echo date('Y-m-d', $sla_milestone); ?>" name="sla_milestone" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
                                    <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                </div>
                                <script type="text/javascript">
                                    var dateNow = new Date();
                                    $("#sla_milestone1").datetimepicker({startDate: dateNow, autoclose: true, showMeridian: false, format: 'yyyy-mm-dd', minView: 'month', daysOfWeekDisabled: '0,6'});
                                </script>
                            <?php } ?>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php 
                            $button_label = (!empty($job_id))? "Save" : "Post Requirement";
                            echo form_submit('submit_button', $button_label, array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>  
        </div> 
    </div>
</div>
