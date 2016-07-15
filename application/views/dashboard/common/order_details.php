<?php
if (!empty($job_details)) {
    $urgent = ($job_details->is_urgent == 1) ? "Yes" : "No";
    $sealed = ($job_details->is_sealed == 1) ? "Yes" : "No";
    ?>
    <table class="table table-bordered ">
        <tr>
            <th colspan="2">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-left">Project Name:  <?php echo $job_details->job_name; ?></p>
                    </div>
                    <?php
                    if ($user_type_id == 1 || !empty($is_job_quoted_by_user)) {
                        if ($user_type_id == 1 || $this->session->userdata('is_vetted') == 1) {
                            
                            $buyer_company = !empty($job_user_data->company_name) ? $job_user_data->company_name : '';
                            $logo = "<img src=" . base_url() . "styles/images/default.png width='60px' />";
                            if (!empty($job_user_data->country_id)) {

                                $flag = "<img src = '" . base_url() . "styles/images/flags-mini/" . $user_country->iso_country_code . ".png' data-toggle='tooltip' alt='" . $user_country->country_name . "' title='" . $user_country->country_name . "'>";
                            } else {
                                $flag = NULL;
                            }
                            if (!empty($job_user_data->company_logo_path)) {
                                $logo = "<img width='60px' src='" . base_url() . "uploads/company/" . $job_user_data->company_logo_path . "'/>";
                            }
                            if (!empty($job_user_data)) {
                                $user_name = $job_user_data->user_first_name . ' ' . $job_user_data->user_last_name;
                            }
                            $title = "<div class='row'>"
                                    . "<div class = 'col-md-10'>".$logo . " " . $user_name ."</div>"
                                    . "<div class='col-md-2'><span class='text-right'>"
                                     .$flag."</span></div></div>";
                            $content = "  <tr>
                                  <th width='50%'>Name </th>
                                  <td >".$user_name."</td>
                              </tr>
                              <tr>
                                  <th>Email</th>
                                  <td>". $job_user_data->email."</td>
                              </tr>
                              <tr>
                                  <th width='30%'>Phone Number  </th>
                                  <td >" .$job_user_data->telephone_code . '' . $job_user_data->telephone_no ."</td>
                              </tr>
                              <tr>
                                  <th>Fax Number</th>
                                  <td>";           
                                    if (!empty($job_user_data->fax_no)) {
                                        $content .= $job_user_data->fax_no ;
                                    } else {
                                        $content .= "---";
                                    }
                            $content  .= "</td>
                              </tr>
                              <tr>
                                  <th>Address</th>
                                  <td>";           
                            if (!empty($job_user_data->street_address)) {
                                $content .= $job_user_data->address_name . ',<br> ' . $job_user_data->street_address . '.';
                            } else {
                                $content .= "---";
                            }
                            $content  .= "</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>".$job_user_data->city."</td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>".$job_user_data->state."</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>";
                             if (!empty($job_user_data->country_name)) {
                                 $content .= $job_user_data->country_name ;
                             }else{
                                 $content .= '---';
                             }
                             $content  .= "</td>
                            </tr>
                            <tr>
                                <th>ZIP code</th>
                               <td>";
                                if (!empty($job_user_data->post_code)) {
                                    $content .= $job_user_data->post_code ;
                                }else{
                                    $content .= '---';
                                }
                            $content  .= "</td>
                            </tr>";
                        } else {
                            $user_id = $this->session->userdata('user_id');
                            $url = base_url('dashboard/job/notify_demo_seller') . '/' . $user_id . '/' . $job_id;
                        $content = "You are currently logged in as Demo mode. 
                            To place a bid and start winning orders, 
                            as well as receiving advanced functionality. 
                            Request a package from our sales to begin by clicking 
                            <a  href='" . $url . "'>here</a>.";
                        $title = "You are a demo user";
                        }
                        ?>
                        <div class="col-md-4 text-right">
                            <a class="btn btn-blue center-block" data-toggle="modal" data-target="#buyer-details">Buyer Details </a>
                        </div>
                        <div class="modal fade" id="buyer-details" role="dialog">
                            <div class="modal-dialog">
                                <!-- Quote content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> 
                                            <?php echo $title;?></h4
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered clearfix">
                                               <?php echo $content;?>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
    <?php } ?>
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
            <td><?php echo $urgent; ?></td>
        </tr>
        <tr style="display: none;">
            <th>Sealed/Tender</th>
            <td><?php echo $sealed; ?></td>
        </tr>
         <tr>
            <th>Sample Required</th>
            <td><?php echo !empty($job_details->is_sample_required) ? 'Yes' : 'No';?></td>
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
</table>
<?php } ?>