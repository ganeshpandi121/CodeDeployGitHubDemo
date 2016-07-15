<script>

    var loginController = {
        LoginValidation: function () {
            $('#login_email').parent().removeClass("has-error has-danger");
            $('#login_password').parent().removeClass("has-error has-danger");

            var error = "";

            this.hideAlerts('#login_alert');

            if ($('#login_email').val() == "") {
                error += "Please enter Email<br/>";
                $('#login_email').parent().addClass("has-error has-danger");
            }

            if ($('#login_password').val() == "") {
                error += "Please enter Password";
                $('#login_password').parent().addClass("has-error has-danger");
            }

            if (error) {
                //$("#login_alert").html().show();               
                Messages.error(error);

                return false;
            } else {
                $("#login_form").submit();
            }

        },
        signUpvalidation: function () {


            $('#user_first_name').parent().removeClass("has-error has-danger");
            $('#user_last_name').parent().removeClass("has-error has-danger");

            var error = "";

            this.hideAlerts('#sign_up_alert');

            if ($.trim($('#user_first_name').val()) == "") {
                error += "Please enter First Name<br/>";
                $('#user_first_name').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#user_last_name').val()) == "") {
                error += "Please enter Last name<br/>";
                $('#user_last_name').parent().addClass("has-error has-danger");
            }
            if ($('#company_name').val() == "") {
                error += "Please enter Company Name<br/>";
                $('#company_name').parent().addClass("has-error has-danger");
            }
            if ($('#sign_in_email').val() == "") {
                error += "Please enter Email<br/>";
                $('#sign_in_email').parent().addClass("has-error has-danger");
            }

            var passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}$/;

            var pass = $('#sign_in_password').val();
            if (passReg.test(pass) == false) {
                error += "Password must be at least 8 characters, no more than 12 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit.<br/>";
                $('#sign_in_password').parent().addClass("has-error has-danger");

            }

            if ($('#sign_in_confirm_password').val() != "") {
                if ($('#sign_in_password').val() != $('#sign_in_confirm_password').val()) {
                    error += "Password And Confirm Password Should be same<br/>";
                    $('#sign_in_confirm_password').parent().addClass("has-error has-danger");

                }
            } else {
                error += "Please enter Confirm Password<br/>";
                $('#sign_in_confirm_password').parent().addClass("has-error has-danger");
            }
            if ($('#telephone').val() == "") {
                error += "Please enter Phone Code<br/>";
                $('#telephone').parent().addClass("has-error has-danger");
            }
            if ($('#telephone_no').val() == "") {
                error += "Please enter Phone Number<br/>";
                $('#telephone_no').parent().addClass("has-error has-danger");
            }
            if (isNaN($('#telephone_no').val())) {
                error += "Only numbers are allowed in phone number<br/>";
                $('#telephone_no').parent().addClass("has-error has-danger");
            }
            if (!$('#terms_conditions').prop('checked')) {
                error += "Please select terms and conditions<br/>";
                $('#terms_conditions').parent().parent().parent().addClass("has-error has-danger");
            }

            if (error) {
                //  $("#sign_up_alert").html(error).show();
                Messages.error(error);
                return false;
            } else {
                $("#sign_up_form").submit();
            }
        },
        hideAlerts: function (variable) {
            $(variable).html("").hide();
            $('.form-control').parent().removeClass("has-error has-danger");

        },
        loginFormController: function (url) {
            $('input[name="redirect_url"]').val(url);
            $('#signup_section').hide();
            $('#login_section').toggle();
            this.hideAlerts('#login_alert');
        },
        signUpFormController: function (url) {
            $('input[name="redirect_url"]').val(url);
            $('#login_section').hide();
            $('#signup_section').toggle();
            this.hideAlerts('#sign_up_alert');
        }
    }

</script>


<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4 logo">
            <a href="<?php echo $this->config->base_url(); ?>"><?php echo img('styles/images/logo.png', '', array('alt' => 'Logo', 'height' => '80')); ?>          
            </a> </div>
        <div class="col-md-8 col-sm-8 text-right index-navbar">
            <br/>
            <?php if ($this->session->userdata('logged_in')) { ?>
                Hi <?php echo $this->session->userdata('user_name'); ?><br/>
                <?php if($user_type_id == 1){
                    $dashboard_url = "admin/projects";
                 }else if($user_type_id == 2){
                     $dashboard_url = "dashboard/my-projects";
                 }else if($user_type_id == 3){
                     $dashboard_url = "dashboard/my-bids";
                 }else if($user_type_id == 4){
                     $dashboard_url = "dashboard";
                 }
                ?>
                <a href="<?php echo base_url($dashboard_url); ?>">Go to Dashboard</a> 
                <span class="gray-divider">|</span> 
                <a href="<?php echo base_url() . 'news' ?>">News </a>
                <span class="gray-divider">|</span> 
                <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Find Supplier Now</a>
                <span class="gray-divider">|</span>
                <a href="<?php echo base_url('user/logout'); ?>">Log out</a> 


                <?php if ($this->session->userdata('is_verified') == false) { ?>
                    <div class="col-md-12 ">
                        <div class="alert alert-danger text-center">
                            <strong>Warning!</strong> Please activate your account through email.
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->session->userdata('super_admin_id')) { ?>
                    <div class="col-md-12 ">
                        <div class="alert alert-danger text-center">
                            <strong>Note!</strong> 
                            You are now logged in as  
                            <label><?php echo $this->session->userdata('user_name'); ?></label>.
                            Click<a href="<?php echo base_url('admin/login_as_admin'); ?>"> here </a> 
                            to log in back as admin.
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <a onclick="loginController.loginFormController('')"> Login </a> <span class="gray-divider">|</span> 
                <a onclick="loginController.signUpFormController('')">Sign Up </a><span class="gray-divider">|</span> 
                <a href="<?php echo base_url() . 'news' ?>">News </a><span class="gray-divider">|</span>
                <a href="<?php echo $this->config->base_url(); ?>post-a-project">
                    <button type="button" class="btn btn-blue"> Post a Project</button></a>
                <span class="gray-divider">|</span> 
                <a href="javascript:void(0);" data-toggle="popover"
                   data-html="true"  data-content="Please  <a onclick='loginController.loginFormController(&quot;find_supplier_now&quot;);'>Login</a> Or <a onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Find Supplier Now</a>

            <?php } ?>
        </div>
    </div>
</div>
<?php
$show_login = 'style="display:none;"';
if ($this->session->flashdata('error_msg') == true) {
    $show_login = 'style="display:block;"';
}

if ($this->session->flashdata('password_reset_msg') == true) {
    ?><div class="container">
        <div class="row">
            <div class="alert alert-success" >
                <?php echo $this->session->flashdata('password_reset_msg'); ?>
            </div></div></div>
    <?php
}
?>
<div class="container-fluid toggle_close" id="login_section" <?php echo $show_login; ?> >
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-danger" id="login_alert" <?php echo $show_login; ?>>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo validation_errors(); ?>
                <?php echo form_open($this->config->base_url() . 'user_login', array('id' => 'login_form', 'onsubmit' => 'return loginController.LoginValidation()')); ?>
                <div class="form-group text-right">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="$('#login_section').hide();"></span>
                </div>
                <?php echo form_hidden("redirect_url"); ?>
                <div class="form-group">  
                    <?php echo form_email('email', '', array('id' => 'login_email', 'placeHolder' => 'Enter Email')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_password('password', '', array('id' => 'login_password', 'placeHolder' => 'Enter Password')); ?>
                </div>
                <div class="form-group text-right">
                    <a href="<?php echo $this->config->base_url() ?>forgot_password">Forgot your password?</a>
                </div>
                <div class="form-group text-right">    
                    <?php
                    echo form_submit('submit', 'Login', array('class' => 'btn btn-blue', 'id' => 'login_button'));
                    ?>
                </div>

                <?php echo form_close(); ?>

            </div> 
        </div>
    </div>
</div>
<div class="container-fluid toggle_close" id="signup_section" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-danger" id="sign_up_alert" style="display: none;">

                </div>
                <div class="form-group text-right">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="$('#signup_section').hide();"></span>
                </div>
                <?php echo form_open($this->config->base_url() . "Registration", array('method' => 'post', 'onsubmit' => 'return loginController.signUpvalidation()')); ?>
                <?php echo form_hidden("redirect_url"); ?>
                <div class="form-group text-center">
                    <label class="radio-inline">
                        <input type="radio" name="user_type_id" id="user_type_id_2" value="2" checked> 

                        I want to Buy

                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="user_type_id" id="user_type_id_3" value="3">  I want to Sell
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="user_type_id" id="user_type_id_4" value="4"> I'm a freight forwarder
                    </label>
                </div>


                <div class="form-group">  
                    <?php echo form_input('user_first_name', '', array('id' => 'user_first_name', 'placeHolder' => 'First Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('user_last_name', '', array('id' => 'user_last_name', 'placeHolder' => 'Last Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('company_name', '', array('id' => 'company_name', 'placeHolder' => 'Company Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_email('email', '', array('id' => 'sign_in_email', 'placeHolder' => 'Enter Email')); ?>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php
                            usort($telephone_codes, function($a, $b) {
                                return $a->country_name > $b->country_name;
                            });
                            ?>
                            <select class="form-control" name="telephone" id="telephone" onChange="$('#country_id').val($('option:selected', this).attr('data-countryid'));$('#telephone_code').val($('option:selected', this).val());">
                                <?php
                                echo "<option data-countryid = '' value=''>Phone Code</option>";
                                foreach ($telephone_codes as $country) {
                                    echo '<option data-countryid = "' . $country->country_id . '" value="' . $country->telephone_code . '">' . $country->country_name . " " . $country->telephone_code . '</option>';
                                }
                                ?>
                            </select>
                            <input type="hidden" name="country_id" id="country_id" />
                            <input type="hidden" name="telephone_code" id="telephone_code" />
                        </div> 
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">  
                            <?php echo form_input('telephone_no', '', array('id' => 'telephone_no', 'placeHolder' => 'Enter Phone Number')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">  
                    <?php echo form_password('password', '', array('id' => 'sign_in_password', 'placeHolder' => 'Enter Password')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_password('confirm_password', '', array('id' => 'sign_in_confirm_password', 'placeHolder' => 'Confirm Password')); ?>
                </div>
                <div class="form-group">  
                    <div class="checkbox">
                        <?php
                        echo bootstrap_checkbox('terms_conditions', "checkbox-inline", '1', 'By signing up, you agree to our <a href="' . base_url() . 'terms">Terms & Conditions</a> and <a href="' . base_url() . 'privacy_policy">Privacy Policy</a>', true, array('id' => 'terms_conditions'))
                        ?>
                    </div>
                </div>
                <div class="form-group text-right">    
                    <?php
                    echo form_submit('submit', 'Sign Up', array('class' => 'btn btn-blue', 'id' => 'signup_button'));
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>