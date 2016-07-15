<script>
    var settingsController = {
        regionValidation: function () {
           var error = "";
           if( $('#region-menu').find("input[type='checkbox']:checked").length < 1){
                 error += "Please select any Region<br/>";
           }
           if (error) {
                Messages.error(error);
                return false;
            } else {
                return true;
            }
        }
    };

</script>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h3>Step 3 - Add Region</h3>
                    </div>
                </div>
                <?php
                if ($this->session->flashdata('error_msg') == true) { ?>
                    <div class="alert alert-danger" id="region_alert">
                        <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_open("Registration/seller-signup-complete", array('name' => 'signup_region_form', 'id' => 'signup_region_form', 'method' => 'post', 'onsubmit' => 'return settingsController.regionValidation()'));
                        if(!empty($seller_data)) { 
                            echo form_hidden('seller_data', $seller_data);
                        }
                        if(!empty($seller_address_data)) { 
                            echo form_hidden('seller_address_data', $seller_address_data);
                        }
                        if(!empty($seller_company_data)) { 
                            echo form_hidden('seller_company_data', $seller_company_data);
                        }
                        if(!empty($seller_categories)) { 
                            echo form_hidden('seller_categories', $seller_categories);
                        }
                        ?>
                        <div id="region-menu" class="">
                        <?php
                        if(!empty($regions)){
                            $i = 0;
                            echo "<div class='row'>";
                            foreach ($regions as $reg) {
                                echo "<div class='col-md-3'>";
                                echo '<div class="form-group">';

                                echo bootstrap_checkbox('region[]', "checkbox-inline no-indent text-capitalize", $reg->region_id, $reg->region_name);
                                echo "</div></div>";
                                $i++;
                                if ($i % 3 == 0)
                                    echo '</div><div class="row">';
                            }
                            echo "</div>";
                            ?>
                            <div class="row">
                                <div class="col-md-9 text-center">
                                    <div class="form-group"> 
                                        <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                        <a href="<?php echo base_url();?>" class="btn btn-blue" role="button">Cancel</a>
                                    </div> 
                                </div>
                            </div>
                            <?php echo form_close(); 
                        }?>
                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>