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
                        <h3>Add Seller Regions</h3>
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
                        echo form_open("dashboard/seller-process-complete", array('name' => 'seller_region_form', 'id' => 'seller_region_form', 'method' => 'post', 'onsubmit' => 'return settingsController.regionValidation()'));
                        
                        if(!empty($added_categories)) { 
                            echo form_hidden('added_categories', $added_categories);
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
                            <?php echo form_close(); }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>