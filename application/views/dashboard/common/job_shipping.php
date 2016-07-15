<script>
var shippingotherValidator = {
    shippingotherValidation: function(){
        $('#address_name').parent().removeClass("has-error has-danger");
        $('#city').parent().removeClass("has-error has-danger");
        $('#state').parent().removeClass("has-error has-danger");
        $('#country').parent().removeClass("has-error has-danger");
        $('#street_address').parent().removeClass("has-error has-danger");
        $('#post_code').parent().removeClass("has-error has-danger");

        var error = "";

        if ($.trim($('#address_name').val()) == "") {
        error += "Please enter Address Tittle<br/>";
        $('#address_name').parent().addClass("has-error has-danger");
        $('#address_name').focus();
        } 
        
        if ($.trim($('#street_address').val()) == "") {
        error += "Please enter Street Address<br/>";
        $('#street_address').parent().addClass("has-error has-danger");
        }

        if ($('#city').val() == "") {
        error += "Please enter City<br/>";
        $('#city').parent().addClass("has-error has-danger");
        }

        if ($('#country option:selected').val() == "0") {
        error += "Please select Country<br/>";
        $('#country').parent().addClass("has-error has-danger");
        }
        
        if ($('#telephone_code option:selected').val() == "") {
        error += "Please select Phone Code<br/>";
        $('#telephone_code').parent().addClass("has-error has-danger");
        }
        
        if ($('#telephone_no').val() == "") {
        error += "Please enter Phone Number<br/>";
        $('#telephone_no').parent().addClass("has-error has-danger");
        }
       
        if ($('#post_code').val() == "") {
        error += "Please enter Zip code<br/>";
        $('#post_code').parent().addClass("has-error has-danger");
        }
        
        if (error) {
            Messages.error(error);
            return false;
        } else {
            return true;
        }
     }
}
</script>

<div class="row">
    <div class="col-md-12">
        <?php
        if ($shipping_details->is_require_delivery == 0) {
            echo "<h3>Shipping Not required</h3>";
        } else {
            echo "<h3>Shipping  required</h3>";
        }  ?>
        </div>
    <?php if ($shipping_details->is_require_delivery == 1) {?>
        <div class="col-md-4">
            <?php
            echo "<b>" . $note_to_address . "</b><br/>";

            if ($get_shipping_to_address) {
                echo "Name: " . $get_shipping_to_address->address_name . "<br/>";
                echo "Street Address: " . $get_shipping_to_address->street_address . "<br/>";
                echo "state: " . $get_shipping_to_address->state . "<br/>";
                echo "city: " . $get_shipping_to_address->city . "<br/>";
                echo "Zip Code: " . $get_shipping_to_address->post_code . "<br/>";
                echo "Country: " . $get_shipping_to_address->country_name . " <img src='" . base_url() . "styles/images/flags-mini/" . $get_shipping_to_address->iso_country_code . ".png'/><br/>";
                echo "telephone: " . $get_shipping_to_address->telephone_code . " " . $get_shipping_to_address->telephone_no . "<br/>";
                echo "Fax no: " . $get_shipping_to_address->fax_no . "<br/>";
                
                if ($this->session->user_type_id == 2 && !in_array($job_status, array('Completed','Cancelled'))) {?>
            
                    <a class="btn btn-blue" data-toggle="modal" data-target="#edit-address">Edit Your Address</a>
                <?php } ?>
                <?php
            } else {
                if ($this->session->user_type_id == 2) {
                    echo '<a href="' . $this->config->base_url() . 'dashboard/profile">Add Your Address</a>';
                }
            }
            ?>
        </div>
        <div class="col-md-4">
            <b>Shipping Type</b><br/>
            <label>Courier: </label>  <?php echo ($shipping_details->is_courier) ? "Yes" : "No" ?><br/>
            <label>Air Freight: </label>  <?php echo ($shipping_details->is_air_freight) ? "Yes" : "No" ?><br/>
            <label>Sea Freight: </label> <?php echo ($shipping_details->is_sea_freight) ? "Yes" : "No" ?><br/>
        </div>
        <?php } ?>

</div>



<!-- Shipping Address -->
<div class="modal" id="edit-address" role="dialog">
    <div class="modal-dialog edit_address">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Address</h4>
            </div>
            <?php
                $address_id = !empty($get_shipping_to_address->address_id) ? $get_shipping_to_address->address_id : '';
                echo form_open(base_url() . "dashboard/job/edit_shipping_address/" . $address_id, array('method' => 'post', 'onsubmit' => 'return shippingotherValidator.shippingotherValidation()'));
                echo form_hidden('job_id', $job_id);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="col-md-12">    
                        <div class="form-group">
                            <?php
                            $address_name = !empty($get_shipping_to_address->address_name) ? $get_shipping_to_address->address_name : '';
                            echo form_label("Address Title", "address_name");

                            echo form_input('address_name', $address_name, array('id' => 'address_name', 'placeHolder' => 'Add Name'));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12">   
                <div class="form-group"> 
                    <?php
                    $street_address = !empty($get_shipping_to_address->street_address) ? $get_shipping_to_address->street_address : '';
                    echo form_label('Street Address', 'street_address');

                    echo form_textarea(array('id' => 'street_address', 'rows' => '3', 'placeHolder' => 'Add Street Address', 'name' => 'street_address'), $street_address);
                    ?>
                </div>
                    </div>
                    <div class="col-md-12">   
                <div class="form-group"> 
                    <?php
                    $city = !empty($get_shipping_to_address->city) ? $get_shipping_to_address->city : '';
                    echo form_label("City", "city");

                    echo form_input('city', $city, array('id' => 'city', 'placeHolder' => 'Add City'));
                    ?>
                </div> 
                    </div>
                    <div class="col-md-12">   
                <div class="form-group"> 
                    <?php
                    $state = !empty($get_shipping_to_address->state) ? $get_shipping_to_address->state : '';
                    echo form_label("State", "state");

                    echo form_input('state', $state, array('id' => 'state', 'placeHolder' => 'Add State'));
                    ?>
                </div>
                    </div>
                    <div class="col-md-12">   
                <div class="form-group"> 
                    <?php
                    $post_code = !empty($get_shipping_to_address) ? $get_shipping_to_address->post_code : '';
                    echo form_label("Zip Code", "post_code");

                    echo form_input('post_code', $post_code, array('id' => 'post_code', 'placeHolder' => 'Add Zip Code'));
                    ?>
                </div>
                    </div>
                    <div class="col-md-12">   
                <div class="form-group"> 
                    <label>Country</label>
                    <?php 
                        usort($countries, function($a, $b) {
                            return $a->country_name > $b->country_name;
                        });
                    ?>
                    <select class="form-control" name="country_id" id="country">
                        <?php
                        foreach ($countries as $country) {
                            if ($get_shipping_to_address->country_id == $country->country_id) {
                                $selected = "selected='selected'";
                            } else {
                                $selected = "";
                            }

                            $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : '';

                            echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id ."' $selected>$country->country_name</option>";
                        }
                        ?>

                    </select>
                </div>
                    </div>
                   
                        <div class="col-md-3">
                        <div class="form-group">
                        <?php echo form_label("Phone Code", "telephone_code");
                        usort($countries, function($a, $b) {
                            return $a->telephone_code - $b->telephone_code;
                        });
                        
                        ?>
                            
                        <select class="form-control" name="telephone_code" id="telephone_code">
                            <?php
                            echo "<option value=''>None</option>";
                            $next = "";
                            foreach ($countries as $country) {
                                if (!empty($country->telephone_code)) {
                                    $next = $country->telephone_code;
                                    if($next == $prev) continue;
                                    $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : NULL;
                                     $address_telephone_code = !empty($get_shipping_to_address->telephone_code) ? $get_shipping_to_address->telephone_code : '';
                                    if ($address_telephone_code == $country->telephone_code) {
                                        $selected = "selected='selected'";
                                    } else {
                                        $selected = "";
                                    }

                                    echo '<option value="' . $telephone_code . '" '.$selected.'>' . $telephone_code . '</option>';
                                    
                                    $prev = $country->telephone_code;
                                    }
                            }
                            ?>
                        </select>
                        </div>    
                    </div>
                    <div class="col-md-4">   
                    <div class="form-group">
                    <?php
                    echo form_label("Phone Number", "telephone_no");
                    $telephone_no = !empty($get_shipping_to_address->telephone_no) ? $get_shipping_to_address->telephone_no : '';
                    echo form_input('telephone_no', $telephone_no, array('id' => 'telephone_no', 'placeHolder' => 'Add Phone Number'));
                    ?>
                    </div>
                    </div>
                    <div class="col-md-5">   
                    <div class="form-group">
                    <?php
                    $to_fax = !empty($get_shipping_to_address) ? $get_shipping_to_address->fax_no : '';
                    echo form_label("Fax Number", "fax_no");
                    echo form_input('fax_no', $to_fax, array('id' => 'fax_no', 'placeHolder' => 'Add Fax Number'));
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
<!------------End of Shipping Address----------------->