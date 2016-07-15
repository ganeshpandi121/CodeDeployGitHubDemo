<script>
    var profileValidator = {
        passwordValidation: function () {
            $('#new_password').parent().removeClass("has-error has-danger");
            $('#old_password').parent().removeClass("has-error has-danger");
            $('#confirm_new_password').parent().removeClass("has-error has-danger");

            var error = "";
            var passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}$/i;


            var pass1 = $('#new_password').val();
            if (passReg.test(pass1) == false) {
                error += "<strong>New Password: </strong>Password must be at least 8 to 12 characters. We suggest to include at least one upper case letter, one lower case letter, and one numeric digit.<br/>";
                $('#new_password').parent().addClass("has-error has-danger");

            }

            if ($('#old_password').val() == '') {
                error += "<strong>Old Password: </strong>Password cannot be empty.<br/>";
                $('#old_password').parent().addClass("has-error has-danger");

            }
            if ($('#confirm_new_password').val() == '') {
                error += "<strong>Confirm Password: </strong>Password cannot be empty.<br/>";
                $('#confirm_new_password').parent().addClass("has-error has-danger");

            }
            if ($('#confirm_new_password').val() != '') {
                if ($('#new_password').val() != $('#confirm_new_password').val()) {
                    error += "New Password and Confirm Password should be same<br/>";
                    $('#confirm_new_password').parent().addClass("has-error has-danger");

                }
            }


            if (error) {
                //$("#profile-error").html(error);
                Messages.error(error);
                return false;
            } else {
                $("#password_form").submit();
            }

        },
        proflepicValidation: function () {
            var error = "";
            if ($('#profile_pic').val() == "") {
                error += "Please upload any image file.<br/>";
            }
            if (error) {
                Messages.error(error);
                return false;
            } else {
                $("#profile_picture_form").submit();
            }
        }

    }


    $(document).ready(function () {
        $("#country-2").change(function () {
            var value = $(this).find(':selected').data('phone-code');
            if (value != "")
            {
                $("#telephone_code").val(value);
            } else
            {
                $("#telephone_code").val("");
            }

        });
        
        $('#side-bar > li > a').click(function(){
           $('#side-bar > li').children().removeClass("active");
        });
        
        //tab function
        <?php if($active_tab!=""){?>
            var act = "<?php echo $active_tab;?>";
            var tab_pane = "tab-"+act;
            $("."+ act).addClass('active');
            $("."+ tab_pane).addClass('in active');
        <?php }?>
        
 });

</script>
<script src="<?php echo $this->config->base_url(); ?>styles/js/profilevalidation.js"></script>
<div class="container-fluid">
    <div class="container ">
        <div id="profile-error"></div>
        <?php echo $this->session->flashdata('backend_msg'); ?>

        <div class="row">
            <?php
            $show_alert = 'style="display:none;"';
            if ($this->session->flashdata('error_msg') == true) {
                $show_alert = 'style="display:block;"';
            }
            ?>
            <div class="col-md-3 profile-container" style="height: 100%">
                <ul id="side-bar" class="nav nav-tabs">
                    <li class="address"><a data-toggle="tab" href="#address-menu" >Addresses</a></li>
                    <li class="personal_info"><a data-toggle="tab" href="#personal-menu" >Personal Information</a></li>
                    <li class="company_info"><a data-toggle="tab" href="#company-info">Company Information</a></li>
		    <li><a data-toggle="tab" href="#email-menu" >View Email</a></li>
                    <li class="password_change"><a data-toggle="tab" href="#password-menu">Change Password</a></li>
                    <li class="profile_pic"><a data-toggle="tab" href="#profile-picture-menu">Profile Picture</a></li>
                    <li><a data-toggle="tab" href="#history-menu">My History</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div id="address-menu" class="tab-pane tab-address fade">
                        <h3><?php
                            $address_heading = !empty($address->address_name) ? 'Edit Address' : 'Add Address';
                            echo $address_heading;
                            ?></h3>

                        <div class="alert alert-danger" id="adres_alert" <?php echo $show_alert; ?>>
                            <?php echo $this->session->flashdata('error_msg'); ?>
                        </div>
                        <?php echo $this->session->flashdata('backend_msg_adres'); ?>
                        <?php if (empty($user_info->is_address_added)) { ?>
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Please add your address here.
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <?php echo form_open($this->config->base_url() . "profile/update_address", array('id' => 'address_form', 'onsubmit' => 'return profileController.addressValidation()')); ?>

                            <div class="col-md-6">
                                <div class="alert alert-danger" id="adres_alert" <?php echo $show_alert; ?>>
                                    <?php echo $this->session->flashdata('error_msg'); ?>
                                </div>
                                <div class="form-group"> 

                                    <?php
                                    echo form_label("Name", "address_name");
                                    $address_name = !empty($user_info->address_name) ? $user_info->address_name : '';
                                    echo form_input('address_name', $address_name, array('id' => 'address_name', 'placeHolder' => 'Add Name'));
                                    ?>
                                </div> 
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php
                                    echo form_label('Street Address', 'street_address');
                                    $street_address = !empty($user_info->street_address) ? $user_info->street_address : '';
                                    echo form_textarea(array('id' => 'street_address', 'rows' => '3', 'placeHolder' => 'Add Street Address', 'name' => 'street_address'), $street_address);
                                    ?>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php
                                    echo form_label("City", "city");
                                    $city = !empty($user_info->city) ? $user_info->city : '';
                                    echo form_input('city', $city, array('id' => 'city', 'placeHolder' => 'Add City'));
                                    ?>
                                </div> 
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php
                                    echo form_label("State", "state");
                                    $state = !empty($user_info->state) ? $user_info->state : '';
                                    echo form_input('state', $state, array('id' => 'state', 'placeHolder' => 'Add State'));
                                    ?>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label>Country</label>
                                    <?php

                                    function cmp($a, $b) {
                                        return strcmp($a->country_name, $b->country_name);
                                    }

                                    usort($countries, "cmp");
                                    ?>
                                    <select class="form-control" name="country_id" id="country">
                                        <?php
                                        foreach ($countries as $country) {
                                            $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : '';
                                            if ($user_info->country_id == $country->country_id) {
                                                echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "' selected>$country->country_name</option>";
                                            } else {
                                                echo "<option data-phone-code = '" . $telephone_code . "' value='" . $country->country_id . "'>$country->country_name</option>";
                                            }
                                        }
                                        ?>



                                    </select>
                                </div> 
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php
                                    echo form_label("Zip Code", "post_code");
                                    $post_code = !empty($user_info->post_code) ? $user_info->post_code : '';
                                    echo form_input('post_code', $post_code, array('id' => 'post_code', 'placeHolder' => 'Add Zip Code'));
                                    ?>
                                </div> 
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                </div> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div id="personal-menu" class="tab-pane tab-personal_info fade">
                        <h3>Personal Information</h3>
                        <?php echo $this->session->flashdata('backend_msg_personal'); ?>
                        <div class="alert alert-danger" id="personal_alert" <?php echo $show_alert; ?>>
                            <?php echo $this->session->flashdata('error_msg'); ?>
                        </div>    
                        <?php echo form_open($this->config->base_url() . "profile/update_personal_info", array('method' => 'post', 'onsubmit' => 'return profileController.personalinfoValidation()')); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php echo form_label("First Name", "user_first_name"); ?>
                                    <?php echo form_input('user_first_name', $user_info->first_name, array('id' => 'user_first_name', 'placeHolder' => 'Add First Name')); ?>
                                </div> 
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php echo form_label("Last Name", "user_last_name"); ?>
                                    <?php echo form_input('user_last_name', $user_info->last_name, array('id' => 'user_last_name', 'placeHolder' => 'Add First Name')); ?>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                </div> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                       
                     <div id="company-info" class="tab-pane tab-company_info fade">
                        <h3>Company Information</h3>
                        <div class="alert alert-danger" id="company-info-alert" <?php echo $show_alert; ?>>
                            <?php echo $this->session->flashdata('error_msg'); ?>
                        </div>    
                        <?php echo $this->session->flashdata('backend_msg_comp_info'); ?>
                        <?php echo form_open_multipart($this->config->base_url() . "profile/update_company_info", array('method' => 'post', 'onsubmit' => 'return profileController.companyinfoValidation()')); ?>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <?php $company_name = (!empty($user_info->company_name)) ? $user_info->company_name : '';?>
                                        <?php echo form_label("Company Name", "company_name"); ?>
                                        <?php echo form_input('company_name', $company_name, array('id' => 'user_comp_name', 'placeHolder' => 'Add Company Name')); ?>
                                    </div> 
                                </div>
                                <?php 
                                 $website = (!empty($user_info->website)) ? $user_info->website : '';
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <?php echo form_label("Website Url(s)", "website_url"); ?>
                                        <?php echo form_input('website_url',$website, array('id' => 'user_web_url', 'placeHolder' => 'Add Website Url')); ?>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <?php
                           // }
                            ?>


                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <?php
                                            echo form_label("Phone Code", "telephone_code");
                                            usort($telephone_codes, function($a, $b) {
                                                return $a->telephone_code - $b->telephone_code;
                                            });
                                            ?>

                                            <select class="form-control" name="telephone_code" id="telephone_code">
                                                <?php
                                                echo "<option value=''>None</option>";

                                                foreach ($telephone_codes as $country) {
                                                    $next = $country->telephone_code;
                                                    if($next == $prev) continue;
                                                    if (!empty($country->telephone_code)) {
                                                        $telephone_code = !empty($country->telephone_code) ? $country->telephone_code : NULL;

                                                        if ($user_info->telephone_code == $country->telephone_code) {
                                                            echo '<option   value="' . $telephone_code . '" selected>' . $telephone_code . '</option>';
                                                        } else {

                                                            echo '<option    value="' . $telephone_code . '">' . $telephone_code . '</option>';
                                                        }
                                                    }
                                                    $prev = $country->telephone_code;
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <?php
                                            echo form_label("Phone Number", "telephone_no");
                                            $telephone_no = !empty($user_info->telephone_no) ? $user_info->telephone_no : '';
                                            echo form_input('telephone_no', $telephone_no, array('id' => 'telephone_no', 'placeHolder' => 'Add Phone Number', 'type' => 'number'));
                                            ?>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php
                                    echo form_label("Fax Number", "fax_no");
                                    $fax_no = !empty($user_info->fax_no) ? $user_info->fax_no : '';
                                    echo form_input('fax_no', $fax_no, array('id' => 'fax_no', 'placeHolder' => 'Add Fax Number'));
                                    ?>
                                </div> 
                            </div>
                        </div>
                          
                        <div class="row">
                                <div class="col-md-6">
                                    <?php echo form_label("Update Company Logo", "company_logo"); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"> 

                                                <?php
                                                $company_logo = !empty($user_info->company_logo_path) ? $user_info->company_logo_path : '';
                                                echo '<img width="150px" height="150px" src = ';
                                                if (!empty($company_logo)) {
                                                    echo base_url()."uploads/company/" .$company_logo. ">";
                                                } else {
                                                    echo base_url() . "styles/images/default.png>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group"> 
                                                        
                                                        <?php echo form_upload('company_logo', '', array('id' => 'company_logo', 'placeHolder' => 'Company Logo', 'max-length' => '100', 'onchange' => 'return ValidateCompanyLogo(this)')); ?>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
 				</div>
                            </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                </div> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div id="email-menu" class="tab-pane fade">
                        <h3>Registered Email Id</h3>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"> 
                                    <?php echo form_label("Email Id", "email"); ?>
                                    <?php echo form_input('email', $user_info->email, array('id' => 'email', 'disabled' => 'disabled')); ?>
                                </div> 
                            </div>
                        </div>


                    </div>

                    <div id="password-menu" class="tab-pane tab-password_change fade">
                        <?php echo form_open($this->config->base_url() . "profile/update_password", array('id' => 'password_form', 'onsubmit' => 'return profileValidator.passwordValidation()')); ?>
                        <h3>Change Password</h3>
                        <?php 
                        if ($this->session->flashdata('password_reset_msg') == true) {
                            echo $this->session->flashdata('password_reset_msg'); 
                        }
                        ?>
                        <?php echo $this->session->flashdata('backend_msg_password'); ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">  
                                    <?php echo form_password('old_password', '', array('id' => 'old_password', 'max-length' => '15', 'placeHolder' => 'Old Password')); ?>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">  
                                    <?php echo form_password('new_password', '', array('id' => 'new_password', 'max-length' => '15', 'placeHolder' => 'New Password')); ?>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">  
                                    <?php echo form_password('confirm_new_password', '', array('id' => 'confirm_new_password', 'max-length' => '15', 'placeHolder' => 'Confirm New Password')); ?>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                </div> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>

                    <div id="profile-picture-menu" class="tab-pane tab-profile_pic fade">
                        <h3>Update Profile Picture</h3>
                        <?php echo $this->session->flashdata('backend_msg_profile_pic'); ?>
                        <?php echo form_open_multipart(base_url() . 'profile/profile_pic', array('id' => 'profile_picture_form', 'onsubmit' => 'return profileValidator.proflepicValidation()')); ?> 

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"> 

                                    <?php
                                    $profile_image = !empty($user_info->logo_path) ? $user_info->logo_path : '';
                                    echo '<img width="150px" height="150px" src = ';
                                    if (!empty($user_info->logo_path)) {
                                        echo base_url() . "uploads/profile/" . $user_info->logo_path . ">";
                                    } else {
                                        echo base_url() . "styles/images/default.png".">";
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"> 
                                    <?php echo form_label("Upload Picture", "profile_pic"); ?>
                                    <?php echo form_upload('profile_pic', '', array('id' => 'profile_pic', 'placeHolder' => 'Profile Picture', 'max-length' => '100', 'onchange' => 'return ValidateFileUpload(this)')); ?>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div id="history-menu" class="tab-pane fade">
                        <h3>User History</h3>
                        <div class="row">
                            <div class="col-md-12" style="height: 400px; overflow: auto">

                                <table class="table table-fixed ">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <?php if($this->session->userdata('user_type_id') == 1 ){?>
                                                <th>User Name</th>
                                            <?php }?>
                                            <th>Action</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-muted">
                                        <?php
                                        foreach ($user_history_log as $user_history) {
                                            echo "<tr><td>";
                                            echo date("F j, Y - g:i a", $user_history->created_time);
                                            echo "</td><td>";
                                            if($this->session->userdata('user_type_id') == 1 ){
                                                echo $user_history->user_first_name.' '.$user_history->user_last_name;
                                                echo "</td><td>";
                                            }
                                            
                                            echo $user_history->action_name;
                                            echo "</td><td>";
                                            echo $user_history->description;
                                            echo "</td><td></tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>