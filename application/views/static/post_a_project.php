<script>
    var baseurl = "<?php echo base_url(); ?>";
    function getSubcategories() {
        $catID = $('#category').val();
        if (($catID >= 1) && ($catID <= 4))
        {
            $('#show-detailed-quote-option').show();
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
    });
</script>
<script src="<?php echo $this->config->base_url(); ?>styles/js/projectvalidation.js"></script>
<div class="container-fluid">
    <div class="container">
        <div class="row ">

            <?php
            $show_alert = 'style="display:none;"';
            if ($this->session->flashdata('error_msg') == true) {
                $show_alert = 'style="display:block;"';
            }
            ?>

            <?php echo form_open_multipart(base_url() . 'registration/post_a_project', array('id' => 'post_project_form', 'onsubmit' => 'return postprojectController.postprojectValidation()')); ?> 

            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-danger" id="postproject_alert" <?php echo $show_alert; ?>>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <h2>Post a Project</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <label class="radio-inline">
                                <input type="radio" name="user_type" id="user_type_1" value="1" 
                                       onchange="$('#new-user').show();
        $('#old-user').hide();
        $('#shipping_address').show();" 
                                       checked> 
                                New User 
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="user_type" id="user_type_2" value="2" onchange="$('#new-user').hide();$('#old-user').show();" >  Returning User
                            </label>
                        </div>
                    </div>
                </div>
                <div id="new-user">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <?php echo form_label("Email", "sign_up_email"); ?>
                                <?php echo form_email('sign_up_email', '', array('id' => 'sign_up_email', 'placeHolder' => 'Enter Email')); ?>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <?php echo form_label("Company Name", "company_name"); ?>
                                <?php echo form_input('company_name', '', array('id' => 'company_name', 'placeHolder' => 'Company Name')); ?>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo form_label("Password", "sign_up_password"); ?>
                                <?php echo form_password('sign_up_password', '', array('id' => 'sign_up_password', 'placeHolder' => 'New Password')); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <?php echo form_label("Confirm Password", "confirm_password"); ?>
                                <?php echo form_password('confirm_password', '', array('id' => 'sign_up_confirm_password', 'placeHolder' => 'Confirm Password')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <?php echo form_label("First Name", "user_first_name"); ?>
                                <?php echo form_input('user_first_name', '', array('id' => 'user_first_name', 'placeHolder' => 'First Name', 'max-length' => '100')); ?>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">  
                                <?php echo form_label("Last Name", "user_last_name"); ?>
                                <?php echo form_input('user_last_name', '', array('id' => 'user_last_name', 'placeHolder' => 'Last Name', 'max-length' => '100')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <?php
                                echo form_label("Phone Code", "telephone_code");
                                usort($telephone_codes, function($a, $b) {
                                    return $a->country_name > $b->country_name;
                                });
                                ?>
                                <select class="form-control" name="telephone_code_11" id="telephone_code_11" onChange="$('#country_id_1').val($('option:selected', this).attr('data-countryid'));$('#telephone_code_1').val($('option:selected', this).val());">
                                    <?php
                                    echo "<option value=''>None</option>";
                                    foreach ($telephone_codes as $country) {
                                        echo '<option data-countryid = "' . $country->country_id . '" value="' . $country->telephone_code . '">' . $country->country_name . " " . $country->telephone_code . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="country_id_1" id="country_id_1" />
                                <input type="hidden" name="telephone_code_1" id="telephone_code_1" />
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">  
                                <?php echo form_label("Phone Number", "telephone_no_1"); ?>
                                <?php echo form_input('telephone_no_1', '', array('id' => 'telephone_no_1', 'placeHolder' => 'Enter Phone Number')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox">

                                <?php
                                echo bootstrap_checkbox('terms_conditions', "checkbox-inline", '1', 'By signing up, you agree to our <a href="' . base_url() . 'terms">Terms & Conditions</a> and <a href="' . base_url() . 'privacy_policy">Privacy Policy</a>')
                                ?>

                            </div>
                        </div>

                    </div>
                </div>
                <div id="old-user" style="display: none;">
                    <div class="form-group">  
                        <?php echo form_email('email', '', array('id' => 'login_email', 'placeHolder' => 'Enter Email')); ?>
                    </div>
                    <div class="form-group">  
                        <?php echo form_password('password', '', array('id' => 'login_password', 'placeHolder' => 'Enter Password')); ?>
                    </div>
                    <div class="form-group text-right">
                        <a href="<?php echo $this->config->base_url() ?>forgot_password">Forgot your password?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Category</label>

                        <select class="form-control" name="category" id="category" onchange="getSubcategories()">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value=" . $category->cat_id . ">" . $category->category_name . "</option>";
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
                                echo "<option value=" . $sub_category->sub_cat_id . ">" . $sub_category->sub_category_name . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div id="show-detailed-quote-option" style="display: none">
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <div class="form-group text-center"> 
                                <label class="radio-inline">
                                    <input type="radio" name="quote_type" id="quote_type_1" value="1" 

                                           onchange="$('#detailed-quote').hide();
                                                   $('#detailed-quote').css({border: 'none'});"     checked> 
                                    Quick Quote
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="quote_type" id="quote_type_2" value="2" onchange="$('#detailed-quote').show(); $('#detailed-quote').css({border: '1px solid #47abe6'}).animate({padding: '10px'}, 500);">  Detailed Quote
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_label("Project Name", "job_name"); ?>
                        <?php echo form_input('job_name', '', array('id' => 'job_name', 'placeHolder' => 'Project Name', 'max-length' => '100')); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Project Overview ', 'job_overview');
                        echo form_textarea(array('id' => 'job_overview', 'name' => 'job_overview', 'rows' => '3', 'placeHolder' => 'Project Overview '));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_label("Product Quantity", "product_quantity"); ?>
                            <?php echo form_number('product_quantity', '', array('id' => 'product_quantity', 'placeHolder' => 'Quantity', 'min' => '0', 'max' => '100000000')); ?>
                        </div> 
                    </div>
                </div>
                <div id="detailed-quote" style="display: none;">
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
                            <select class="form-control" name="plastic_id" id="plastic_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($plastic as $plastics) {
                                    echo "<option value=" . $plastics->plastic_id . ">" . $plastics->plastic_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_input('plastic_other', '', array('id' => 'plastic_other', 'placeHolder' => 'Others', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <label>Thickness</label>
                    <div class="row">
                        <div class="col-md-6">

                            <select class="form-control" name="thickness_id" id="thickness_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($thickness as $individual_thickness) {
                                    echo "<option value=" . $individual_thickness->thickness_id . ">" . $individual_thickness->thickness_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_input('thickness_other', '', array('id' => 'thickness_other', 'placeHolder' => 'Others', 'max-length' => '100')); ?>
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
                            <select class="form-control" name="cmyk_id" id="cmyk_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($cmyk as $individual_cmyk) {
                                    echo "<option value=" . $individual_cmyk->cmyk_id . ">" . $individual_cmyk->cmyk_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Metalic Ink", "metallic_ink_id"); ?>
                            <select class="form-control" name="metallic_ink_id" id="metallic_ink_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($metallic_ink as $individual_metallic_ink) {
                                    echo "<option value=" . $individual_metallic_ink->metallic_ink_id . ">" . $individual_metallic_ink->metallic_ink_name . "</option>";
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
                            <?php echo form_input('pantone_front_color', '', array('id' => 'pantone_front_color', 'placeHolder' => 'Add Pantone Front Colour', 'max-length' => '100')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_input('pantone_reverse_color', '', array('id' => 'pantone_reverse_color', 'placeHolder' => 'Add Pantone Reverse Colour', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-10">
                            <div class="form-group form-inline"> 
                                <?php echo form_label("Special Finish", "special_finish"); ?>
                                <br>
                                <input type="checkbox" id="scented_ink" name="scented_ink" value="1"> Scented Ink
                                <input type="checkbox" id="uv_ink" name="uv_ink" value="1">  UV Ink
                                <input type="checkbox" id="raised_surface" name="raised_surface" value="1"> Raised Surface
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

                            <select class="form-control" name="magnetic_tape_id" id="magnetic_tape_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($magnetic_tape as $individual_magnetic_tape) {
                                    echo "<option value=" . $individual_magnetic_tape->magnetic_tape_id . ">" . $individual_magnetic_tape->magnetic_tape_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Personalization (Thermal or Drop On Demand)", "personalization_id"); ?>
                            <select class="form-control" name="personalization_id" id="personalization_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($personalization as $individual_personalization) {
                                    echo "<option value=" . $individual_personalization->personalization_id . ">" . $individual_personalization->personalization_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-inline"> 

                                <input type="checkbox" id="magnetic_strip_encoding" name="magnetic_strip_encoding" value="1"> Magnetic Strip Encoding<br>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-inline"> 

                                <input type="checkbox" id="scratch_off_panel" name="scratch_off_panel" value="1"> Scratch-Off Panel<br>

                            </div>
                        </div>
                    </div>
                    <?php echo form_label("Signature Panel", "signature_panel"); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Front Signature Panel", "front_signature_panel_id"); ?>
                            <select class="form-control" name="front_signature_panel_id" id="front_signature_panel_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($front_signature_panel as $individual_front) {
                                    echo "<option value=" . $individual_front->front_signature_panel_id . ">" . $individual_front->front_signature_panel_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Reverse Signature Panel ", "reverse_signature_panel_id"); ?>

                            <select class="form-control" name="reverse_signature_panel_id" id="reverse_signature_panel_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($reverse_signature_panel as $individual_reverse) {
                                    echo "<option value=" . $individual_reverse->reverse_signature_panel_id . ">" . $individual_reverse->reverse_signature_panel_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Embossing", "embossing_id"); ?>
                            <select class="form-control" name="embossing_id" id="embossing_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($embossing as $individual_embossing) {
                                    echo "<option value=" . $individual_embossing->embossing_id . ">" . $individual_embossing->embossing_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Hotstamping", "hotstamping_id"); ?>

                            <select class="form-control" name="hotstamping_id" id="hotstamping_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($hotstamping as $individual_hotstamping) {
                                    echo "<option value=" . $individual_hotstamping->hotstamping_id . ">" . $individual_hotstamping->hotstamping_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Hologram", "hologram_id"); ?>
                            <select class="form-control" name="hologram_id" id="hologram_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($hologram as $individual_hologram) {
                                    echo "<option value=" . $individual_hologram->hologram_id . ">" . $individual_hologram->hologram_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Hologram - Others", "hologram_other"); ?>
                            <?php echo form_input('hologram_other', '', array('id' => 'hologram_other', 'placeHolder' => 'Add Other Hologram types', 'max-length' => '100')); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-inline padding-10"> 

                                <input type="checkbox" id="fulfillment_service_required" name="fulfillment_service_required" value="1"> Fulfillment Service Required <br>

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
                            <input  type="checkbox" id="card_holder" name="card_holder" value="1"> Card Holder<br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Dimensions", "dimensions"); ?>
                            <?php echo form_input('dimensions', '', array('id' => 'dimensions', 'placeHolder' => 'Add Dimesnion', 'max-length' => '100')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("GSM", "gsm"); ?>
                            <?php echo form_input('gsm', '', array('id' => 'gsm', 'placeHolder' => 'Add GSM', 'max-length' => '100')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Finish", "finish_id"); ?>
                            <select class="form-control" name="finish_id" id="finish_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($finish as $individual_finish) {
                                    echo "<option value=" . $individual_finish->finish_id . ">" . $individual_finish->finish_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <br><br>
                            <input type="checkbox" id="attach_card_with_glue" name="attach_card_with_glue" value="1"> Attach Card with Glue<br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Bundling Required", "bundling_required_id"); ?>

                            <select class="form-control" name="bundling_required_id" id="bundling_required_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($bundling_required as $individual_bundling_required) {
                                    echo "<option value=" . $individual_bundling_required->bundling_required_id . ">" . $individual_bundling_required->bundling_required_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "bundling_required_other"); ?>
                            <?php echo form_input('bundling_required_other', '', array('id' => 'bundling_required_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
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
                            <select class="form-control" name="contactless_chip_id" id="contactless_chip_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($contactless_chip as $individual_contactless_chip) {
                                    echo "<option value=" . $individual_contactless_chip->contactless_chip_id . ">" . $individual_contactless_chip->contactless_chip_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "contactless_chip_other"); ?>
                            <?php echo form_input('contactless_chip_other', '', array('id' => 'contactless_chip_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label("Contact Chip", "contact_chip_id"); ?>

                            <select class="form-control" name="contact_chip_id" id="contact_chip_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($contact_chip as $individual_contact_chip) {
                                    echo "<option value=" . $individual_contact_chip->contact_chip_id . ">" . $individual_contact_chip->contact_chip_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo form_label("Others", "contact_chip_other"); ?>
                            <?php echo form_input('contact_chip_other', '', array('id' => 'contact_chip_other', 'placeHolder' => 'Add others', 'max-length' => '100')); ?>
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
                            <select class="form-control" name="key_tag_id" id="key_tag_id">
                                <option value="0">-- Select --</option>
                                <?php
                                foreach ($key_tag as $individual_key_tag) {
                                    echo "<option value=" . $individual_key_tag->key_tag_id . ">" . $individual_key_tag->key_tag_name . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <br>
                            <input type="checkbox" id="key_hole_punching" name="key_hole_punching" value="1"> Key Hole Punching<br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_label("Unique Card Size", "unique_card_size"); ?>
                            <?php echo form_input('unique_card_size', '', array('id' => 'unique_card_size', 'placeHolder' => 'Add unique card size', 'max-length' => '100')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Project Lead Time</label>
                        <div class="form-group has-feedback">
                            <input  type="text" id="product_lead_time" name="product_lead_time" onkeyup="this.value = this.value.replace(/[^\d-: ]/, '')" placeHolder = "Add Project Lead Time" class="form-control" />
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
                        echo form_textarea(array('id' => 'description', 'name' => 'description', 'rows' => '3', 'placeHolder' => 'Project Details '));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><br>
                        <a href="#" id="add_special_requirement_button">Click to add special requirements</a>
                        <div class="hidden" id="special_requirement_box"><?php echo form_textarea(array('id' => 'special_requirement', 'name' => 'special_requirement', 'rows' => '3', 'placeHolder' => 'Please add special requirements.')); ?>
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
                <div class="row" style="display:none;">
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
                                <input type="radio" name="delivery_required" id="delivery_required_1" value="1" onchange="$('#shipping_forms').show();" > 
                                Yes 
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="delivery_required" id="delivery_required_2" value="2" onchange="$('#shipping_forms').hide();" checked>  No
                            </label>
                        </div>
                    </div>    
                </div>
                <div class="row" id="shipping_forms" style="display: none;">
                    <div class="col-md-12">
                        Do you require delivery via
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_courier" value="1">Courier</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_air_freight" value="1">Air Freight</label>
                        </div>
                        <div class="checkbox disabled">
                            <label><input type="checkbox" name="is_sea_freight" value="1" >Sea Freight</label>
                        </div>
                    </div> 

                    <div class="col-md-12" id="my_address_default">

                        <label class="radio-inline">
                            <input type="radio" name="my_address" id="my_address_other" value="2" onchange="$('#shipping_address').show();" checked>   Ship to other address
                        </label>


                        <label class="radio-inline">
                            <input type="radio" name="my_address"  value="1" onchange="$('#shipping_address').hide();"  > 
                            Ship to my address
                        </label>

                    </div>
                    <div class="col-md-12" id="shipping_address">
                        <div class="form-group"> 
                            <h5><b>Shipping Address Details</b></h5>
                            <?php
                            echo form_label("Address Title", "address_name");

                            echo form_input('address_name', '', array('id' => 'address_name', 'placeHolder' => 'Add Name'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php
                            echo form_label('Street Address', 'street_address');

                            echo form_textarea(array('id' => 'street_address', 'rows' => '3', 'placeHolder' => 'Add Street Address', 'name' => 'street_address'), '');
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php
                            echo form_label("City", "city");

                            echo form_input('city', '', array('id' => 'city', 'placeHolder' => 'Add City'));
                            ?>
                        </div> 
                        <div class="form-group"> 
                            <?php
                            echo form_label("State", "state");

                            echo form_input('state', '', array('id' => 'state', 'placeHolder' => 'Add State'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <label>Country</label>
                            <select class="form-control" name="country_id" id="country">
                                <?php
                                foreach ($countries as $country) {
                                    $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : '';
                                    if ($address->country_id == $country->country_id) {
                                        echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "' selected>$country->country_name</option>";
                                    } else {
                                        echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "'>$country->country_name</option>";
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
                                        echo '<option    value="' . $telephone_code . '">' . $telephone_code . '</option>';
                                    }
                                    $prev = $country->telephone_code;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group"> 

                            <?php
                            echo form_label("Phone Number", "telephone_no");
                            echo form_input('telephone_no', '', array('id' => 'telephone_no', 'placeHolder' => 'Add Phone Number'));
                            ?>
                        </div> 
                        <div class="form-group"> 
                            <?php
                            echo form_label("Zip Code", "post_code");

                            echo form_input('post_code', '', array('id' => 'post_code', 'placeHolder' => 'Add Zip Code'));
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
                                <?php echo form_number('expected_amount', '', array('id' => 'expected_amount', 'placeHolder' => 'Budget', 'min' => '0', 'max' => '100000000')); ?>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_label("Maximize Your Project", "maximize_your_budget"); ?>
                            <br>
                            <input type="checkbox" id="is_urgent" name="is_urgent" value="1">   Urgent: Requires 24 hour start time, quotes needed Immediately<br>
                            <!--<input type="checkbox" id="is_sealed" name="is_sealed" value="1">   Sealed/Tender<br>-->
                            <input type="checkbox" id="is_sample_required" name="is_sample_required" value="1">   Sample required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_label("I want my project start in", "sla_milestone"); ?>
                            <select class="form-control" name="sla_milestone_1" id="sla_milestone" onchange="$('#sla_milestone_new').val($(this).val())">
                                <option value="24">24 hours</option>
                                <option value="48">48 hours</option>
                            </select>
                            <input type="hidden" name="sla_milestone" id="sla_milestone_new" value="24">
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_submit('submit_button', 'Post Project', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div> 
    </div>
</div>
