<?php if (!empty($job_details)) { ?>
    <script>
        var editjobController = {
            editjobValidation: function () {
                $('#category').parent().removeClass("has-error has-danger");
                $('#sub-category').parent().removeClass("has-error has-danger");
                $('#job_name').parent().removeClass("has-error has-danger");
                $('#job_overview').parent().removeClass("has-error has-danger");
                $('#product_quantity').parent().removeClass("has-error has-danger");
                $('#product_lead_time').parent().removeClass("has-error has-danger");
                $('#description').parent().removeClass("has-error has-danger");
                $('#expected_amount').parent().removeClass("has-error has-danger");
                $('#is_urgent').parent().removeClass("has-error has-danger");
                $('#is_sealed').parent().removeClass("has-error has-danger");
                $('#sla_milestone').parent().removeClass("has-error has-danger");
                var error = "";

                if ($('#category option:selected').val() == "0") {
                    error += "Please select category<br/>";
                    $('#category').parent().addClass("has-error has-danger");
                }

                if ($('#sub-category option:selected').val() == "0") {
                    error += "Please select subcategory<br/>";
                    $('#sub-category').parent().addClass("has-error has-danger");
                }

                if ($('#job_name').val() == "") {
                    error += "Please enter job name<br/>";
                    $('#job_name').parent().addClass("has-error has-danger");
                }

                if ($.trim($('#job_overview').val()) == "") {
                    error += "Please enter job overview<br/>";
                    $('#job_overview').parent().addClass("has-error has-danger");
                }

                if (isNaN($('#product_quantity').val()) || $('#product_quantity').val() == "") {
                    error += "Please enter product quantity in number<br/>";
                    $('#product_quantity').parent().addClass("has-error has-danger");
                }

                if ($('#product_lead_time').val() == "") {
                    error += "Please enter project lead time<br/>";
                    $('#product_lead_time').parent().addClass("has-error has-danger");
                }

                if ($.trim($('#description').val()) == "") {
                    error += "Please enter description<br/>";
                    $('#description').parent().addClass("has-error has-danger");
                }
                if (isNaN($('#expected_amount').val()) || $('#expected_amount').val() == "") {
                    error += "Please enter expected amount in number<br/>";
                    $('#expected_amount').parent().addClass("has-error has-danger");
                }

                if ($('#sla_milestone').val() == "") {
                    error += "Please select SLA<br/>";
                    $('#sla_milestone').parent().addClass("has-error has-danger");
                }

                if (error) {
                    $('#category').focus();
                    Messages.error(error);
                    return false;
                } else {
                    return true;
                }

            }
        }

        var baseurl = "<?php echo base_url(); ?>";
        function getSubcategories() {
            $catID = $('#category').val();
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
        $(function(){
            $('#product_lead_time').on('blur', function(){
            //var re = /^\d{4}\-\d{1,2}\-\d{1,2} \d{1,2}:\d{2}([ap]m)?$/;
            var thisVal =$(this).val();
            var curDate = new Date();
            var testDate = new Date(thisVal);
            var error = "";
            /*if (!re.test(thisVal)) {
              error +="Please enter date format in <b> Y-m-d H:i </b>";
            }*/
        
            if (thisVal != "" && testDate == 'Invalid Date') {
                error += "Please enter a valid date <br/>";
            }
            if (testDate < curDate) {
               error +="Please enter date greater than current date <br/>"; 
            }
            
           
            if(error){
              Messages.error(error);  
              $(this).val("");
            }
        });
        $('#sla_milestone').on('blur', function(){
            //var re = /^\d{4}\-\d{1,2}\-\d{1,2} \d{1,2}:\d{2}([ap]m)?$/;
            var thisVal =$(this).val();
            var curDate = new Date();
            var testDate = new Date(thisVal);
            var error = "";
            /*if (!re.test(thisVal)) {
              error +="Please enter date format in <b> Y-m-d H:i </b>";
            }*/
        
            if (thisVal != "" && testDate == 'Invalid Date') {
                error += "Please enter a valid date <br/>";
            }
            if (testDate < curDate) {
               error +="Please enter date greater than current date <br/>"; 
            }
            
           
            if(error){
              Messages.error(error);  
              $(this).val("");
            }
        });
        });
    </script>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/projectvalidation.js"></script>
    <table class="table table-bordered ">
        <tr>
            <th colspan="2">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-left">Project Name:  <?php echo $job_details->job_name; ?></p>
                    </div>

                    <?php if ($user_type_id == 1 || !empty($is_job_allocated)) { 
                           include_once 'job_buyer_popup.php';
                     } ?>
            </th>
        </tr>

        <tr>
            <th width='30%'>Category  </th>
            <td ><?php echo $job_details->category_name; ?></td>
        </tr>
        <tr>
            <th>Sub Category</th>
            <td><?php echo $job_details->sub_category_name; ?></td>
        </tr>
        <tr>
            <th>Project Name</th>
            <td><?php echo $job_details->job_name; ?>
            </td>
        </tr>
        <tr>
            <th>Project Overview</th>
            <td><?php echo $job_details->job_overview; ?>
            </td>
        </tr>
        <tr>
            <th>Product Quantity</th>
            <td><?php echo $job_details->product_quantity; ?></td>
        </tr>
        <tr>
            <th>Project Lead Time</th>
            <td><?php echo date("F j, Y", $job_details->product_lead_time); ?></td>
        </tr>
        <tr>
            <th>Project Details</th>
            <td><?php echo $job_details->note; ?></td>
        </tr>
        <tr>
            <th>Special Requirements</th>
            <td><?php echo $job_details->special_requirement; ?></td>
        </tr>
        <tr>
            <th>Budget</th>
            <td>$<?php echo $job_details->budget; ?></td>
        </tr>
        <tr>
            <th>Urgent: Requires 24 hour start time, quotes need Immediately</th>
            <td><?php echo ($job_details->is_urgent == 1) ? "Yes" : "No"; ?></td>
        </tr>
        <tr style="display: none;">
            <th>Sealed/Tender</th>
            <td><?php echo ($job_details->is_sealed == 1) ? "Yes" : "No"; ?></td>
        </tr>
        <tr>
            <th>Samples Required</th>
            <td><?php echo ($job_details->is_sample_required == 1) ? "Yes" : "No"; ?></td>
        </tr>
        <?php if ($job_additional_details) { ?>
            <tr> <th colspan="2" class="text-center">ADDITIONAL DETAILS</th> </tr>
            <?php
            if (!empty($job_additional_details->plastic_id)) { ?>
                <tr>
                    <th>Plastic</th>
                    <td>
            <?php echo $job_additional_details->plastic_name; ?>
                    </td>
                </tr>
            <?php
           } else { ?>
                <tr>
                    <th>Plastic - Others</th>
                    <td>
                <?php echo $job_additional_details->plastic_other; ?>
                    </td>
                </tr>
                        <?php
                    }
                    ?>
            <?php
            if (!empty($job_additional_details->thickness_id)) { ?>
                <tr>
                    <th>Thickness </th>
                    <td>
                <?php echo $job_additional_details->thickness_name; ?>
                    </td>
                </tr>
            <?php
        } else { ?>

                <tr>
                    <th>Thickness - Others</th>
                    <td>
                <?php echo $job_additional_details->thickness_other; ?>
                    </td>
                </tr>
        <?php }

        if (!empty($job_additional_details->cmyk_id)) { ?>
                <tr>
                    <th>CMYK</th>
                    <td>
                <?php echo $job_additional_details->cmyk_name; ?>
                    </td>
                </tr>
                <?php
            }

            if (!empty($job_additional_details->metallic_ink_id)) { ?>
                <tr>
                    <th>Metallic Ink</th>
                    <td>
                <?php echo ($job_additional_details->metallic_ink_id) ? $job_additional_details->metallic_ink_name : "" ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->pantone_front_color)) { ?>
                <tr>
                    <th>Pantone Front Colour</th>
                    <td>
            <?php echo $job_additional_details->pantone_front_color; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->pantone_reverse_color)) { ?>
                <tr>
                    <th>Pantone Reverse Colour</th>
                    <td>
                        <?php echo $job_additional_details->pantone_reverse_color; ?>
                    </td>
                </tr>
            <?php }
            if (!empty($job_additional_details->scented_ink)) { ?>
                <tr>
                    <th>Special Finish : Scented Ink</th>
                    <td>

                        <?php echo ($job_additional_details->scented_ink == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->uv_ink)) { ?>
                <tr>
                    <th>Special Finish : UV Ink </th>
                    <td>
            <?php echo ($job_additional_details->uv_ink == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
            <?php
        }
        if (!empty($job_additional_details->raised_surface)) { ?>
                <tr>
                    <th>Special Finish : Raised Surface  </th>
                    <td>
            <?php echo ($job_additional_details->raised_surface == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
                        <?php
                    }
                    if (!empty($job_additional_details->magnetic_tape_id)) {
                        ?>
                <tr>
                    <th>Magnetic Tape </th>
                    <td>
                <?php echo $job_additional_details->magnetic_tape_name; ?>
                    </td>
                </tr>
                        <?php
                    }
                    if (!empty($job_additional_details->personalization_id)) {
                        ?>
                <tr>
                    <th>Personalization (Thermal or Drop On Demand)</th>
                    <td>
                <?php echo $job_additional_details->personalization_name; ?>
                    </td>
                </tr>
            <?php
        }
        if (!empty($job_additional_details->magnetic_strip_encoding)) { ?>
                <tr>
                    <th>Magnetic Strip Encoding</th>
                    <td>
                <?php echo ($job_additional_details->magnetic_strip_encoding == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
        <?php }
        if (!empty($job_additional_details->scratch_off_panel)) { ?>
                <tr>
                    <th>Scratch-Off Panel</th>
                    <td>
                <?php echo ($job_additional_details->scratch_off_panel == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
           <?php }
            if (!empty($job_additional_details->front_signature_panel_id)) { ?>
                <tr>
                    <th>Front Signature Panel</th>
                    <td>
                <?php echo $job_additional_details->front_signature_panel_name; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->reverse_signature_panel_id)) { ?>
                <tr>
                    <th>Reverse Signature Panel</th>
                    <td>
                <?php echo $job_additional_details->reverse_signature_panel_name; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->embossing_id)) {
                ?>
                <tr>
                    <th>Embossing</th>
                    <td>
            <?php echo $job_additional_details->embossing_name; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->hotstamping_id)) { ?>
                <tr>
                    <th>Hotstamping</th>
                    <td>
                        <?php echo $job_additional_details->hotstamping_name; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->hologram_id)) { ?>
                <tr>
                    <th>Hologram</th>
                    <td>
                        <?php echo $job_additional_details->hologram_name; ?>
                    </td>
                </tr>
                <?php
            } else { ?>
                <tr>
                    <th>Hologram - Others</th>
                    <td>
                        <?php echo $job_additional_details->hologram_other; ?>
                    </td>
                </tr>
                <?php }
                if (!empty($job_additional_details->fulfillment_service_required)) {?>
                <tr>
                    <th>Fulfillment Service Required </th>
                    <td>
                <?php echo ($job_additional_details->fulfillment_service_required == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
                <?php }
                if (!empty($job_additional_details->card_holder)) { ?>
                <tr>
                    <th>Card Holder</th>
                    <td>
                <?php echo ($job_additional_details->card_holder == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
            <?php
        }
        if (!empty($job_additional_details->dimensions)) { ?>
                <tr>
                    <th>Dimensions</th>
                    <td>
                <?php echo $job_additional_details->dimensions; ?>
                    </td>
                </tr>
            <?php
        }
        if (!empty($job_additional_details->gsm)) {?>
                <tr>
                    <th>GSM</th>
                    <td>
                <?php echo $job_additional_details->gsm; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->finish_id)) {?>
                <tr>
                    <th>Finish</th>
                    <td>
                <?php echo $job_additional_details->finish_name; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->attach_card_with_glue)) {?>
                <tr>
                    <th>Attach card with glue</th>
                    <td>
                <?php echo ($job_additional_details->attach_card_with_glue == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->bundling_required_id)) {?>
                <tr>
                    <th>Bundling Required</th>
                    <td>
            <?php echo $job_additional_details->bundling_required_name; ?>
                    </td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <th>Bundling - Others</th>
                    <td>
                        <?php echo $job_additional_details->bundling_required_other; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->contactless_chip_id)) {?>
                <tr>
                    <th>Contactless Chip</th>
                    <td>
            <?php echo $job_additional_details->contactless_chip_name; ?>
                    </td>
                </tr>
        <?php } else {
            ?>
                <tr>
                    <th>Contactless Chip - Others</th>
                    <td>
                <?php echo $job_additional_details->contactless_chip_other; ?>
                    </td>
                </tr>
                  <?php }
                if (!empty($job_additional_details->contact_chip_id)) {
                        ?>
                <tr>
                    <th>Contact Chip</th>
                    <td>
                <?php echo $job_additional_details->contact_chip_name; ?>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <th>Contact Chip - Others</th>
                    <td>
                <?php echo $job_additional_details->contact_chip_other; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->key_tag_id)) { ?>
                <tr>
                    <th>Key Tag</th>
                    <td>
                <?php echo $job_additional_details->key_tag_name; ?>
                    </td>
                </tr>
                <?php }
            if (!empty($job_additional_details->key_hole_punching)) { ?>
                <tr>
                    <th>Key Hole Punching</th>
                    <td>
                <?php echo ($job_additional_details->key_hole_punching == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
                <?php
            }
            if (!empty($job_additional_details->unique_card_size)) { ?>
                <tr>
                    <th>Unique Card Size</th>
                    <td>
            <?php echo $job_additional_details->unique_card_size; ?>
                    </td>
                </tr>
            <?php } ?>

    <?php } ?>

            <?php if (isset($job_details->file_name)) { ?>
            <tr>
                <th>File Details</th>
                <td>
                    <p>
                        <a href="<?php echo base_url('job/download_job_file') . '/' . $job_details->job_file_id; ?>">
                        <?php echo $job_details->file_name; ?>
                        </a>
                    </p>

                </td>
            </tr>
    <?php } ?>
    <?php } ?>

</table>

    <?php if ($user_type_id == 1 || !empty($is_job_submmitted)) { ?>
        <div>
            <!--<a class="btn btn-blue" data-toggle="modal" data-target="#edit-job">Edit Job</a>-->
            <a class="btn btn-blue" href="<?php echo $this->config->base_url();?>dashboard/edit-job/<?php echo $job_id;?>">Edit Job</a>
        </div>
        <br/>
         <?php //include_once 'edit_job_pop_up.php';
    }?>

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
                        <p>
                            <b>Submitted By: </b>
                            <?php echo $item['user_first_name'] . ' ' . $item['user_last_name']; ?>
                        </p>
                        <p>
                            <b>Comment: </b>
                            <?php echo $item['description']; ?>
                        </p>

                <?php if (!empty($item['job_file_id'])) { ?>
                    <?php foreach ($item['job_file_id'] as $file) { ?>
                                <b>File Details: </b>
                                <p>
                                    File Type: <?php echo $file->file_type_name; ?> <br>
                                    File: 
                                    <a href="<?php echo base_url('job/download_job_file') . '/' . $file->job_file_id; ?>">
                                        <?php echo $file->file_name; ?>
                                    </a><br>
                                    Created Time: 
                                    <?php echo date("F j, Y g:i a", $file->file_created_date); ?>
                                </p>
                        <?php } ?>
                <?php } ?>
                    </td>   
                </tr>
        <?php } ?>
    </table>
<?php } ?>
                