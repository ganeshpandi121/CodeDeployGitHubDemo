<script>
    var contactController = {
        ContactValidation: function () {
            $('#name').parent().removeClass("has-error has-danger");
            $('#email_id').parent().removeClass("has-error has-danger");
            $('#subject').parent().removeClass("has-error has-danger");
            $('#message').parent().removeClass("has-error has-danger");
            var error = "";

            //this.hideAlerts('#contact_alert');

            if ($('#first_name').val() == "") {
                error += "Please Enter First Name<br/>";
                $('#first_name').parent().addClass("has-error has-danger");
            }

            if ($('#last_name').val() == "") {
                error += "Please Enter Last Name<br/>";
                $('#last_name').parent().addClass("has-error has-danger");
            }

            if ($('#email_id').val() == "") {
                error += "Please Enter Email Id<br/>";
                $('#email_id').parent().addClass("has-error has-danger");
            }

            if ($('#telephone_code option:selected').val() == "") {
                error += "Please Select Telephone code<br/>";
                $('#telephone_code').parent().addClass("has-error has-danger");
            }

            if (isNaN($('#telephone_no').val()) || $('#telephone_no').val() == "") {
                error += "Please Enter Telephone Number<br/>";
                $('#phone_no').parent().addClass("has-error has-danger");
            }

            if ($('#subject').val() == "") {
                error += "Please Enter Subject<br/>";
                $('#subject').parent().addClass("has-error has-danger");
            }

            if ($('#message').val() == "") {
                error += "Please Enter Message<br/>";
                $('#message').parent().addClass("has-error has-danger");
            }

            if (error) {

                // $("#contact_alert").html(error).show();
                Messages.error(error);
                return false;
            } else {
                $("#contact_form").submit();
            }
        }
    }
</script>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h2>Contact Us</h2>
            <div class="col-md-6">
                <br>
                <table class="table borderless">
                    <tbody><tr>
                            <th>Mail :
                            </th>
                            <td><a target="_top" href="mailto:info@smartcardmarket.com">info@smartcardmarket.com</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone :
                            </th>
                            <td>
                                <p>
                                    <?php echo img('styles/images/Malaysia-Flag-icon.png', '', array('alt' => 'Malaysia')); ?>
                                    +60 133 623 983</p>
                                <p>
                                    <?php echo img('styles/images/United-States-Flag-icon.png', '', array('alt' => 'United States')); ?>
                                    +1 917 720 3274</p>
                                <p>
                                    <?php echo img('styles/images/South-Africa-Flag-icon.png', '', array('alt' => 'South Africa')); ?>
                                    +27 110 835 056</p>
                                <p>
                                    <?php echo img('styles/images/United-Kingdom-Flag-icon.png', '', array('alt' => 'United Kingdom')); ?>
                                    +44 20 7193 3496</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Address:
                            </th>
                            <td>Unit 8, Level 15, Menara One Mont Kiara, No. 1<br>
                                Jalan Kiara, Mont Kiara, Kuala Lumpur, 50480, MALAYSIA<p></p>
                            </td>
                        </tr>
                    </tbody></table>
                </p>
            </div>
            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-10 padding-25">
                        <?php if (!empty($error_msg)) { ?>
                            <div class="alert alert-danger" id="contact_alert" >
                                <?php echo $error_msg; ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($success_msg)) { ?>
                            <div class="alert alert-success text-center">
                                <?php echo $success_msg; ?>
                            </div>
                        <?php } ?>
                        <?php echo form_open("contact", array('id' => 'contact_form', 'method' => 'post', 'onsubmit' => 'return contactController.ContactValidation()')); ?>			
                        <div class="form-group">  
                            <?php
                            echo form_label('First Name ', 'first_name');
                            echo form_input('first_name', '', array('id' => 'first_name', 'max-length' => '100', 'placeHolder' => 'Enter First Name'));
                            ?>
                        </div>
                        <div class="form-group">  
                            <?php
                            echo form_label('Last Name ', 'last_name');
                            echo form_input('last_name', '', array('id' => 'last_name', 'max-length' => '100', 'placeHolder' => 'Enter Last Name'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php echo form_label("Email", "contact_email"); ?>
                            <?php echo form_email('email_id', '', array('id' => 'email_id', 'placeHolder' => 'Enter Email')); ?>
                        </div>
                        <div class="form-group">  
                            <?php
                            echo form_label("Phone Code", "telephone_code");?>
                            <?php
                            usort($telephone_codes, function($a, $b) {
                                return $a->country_name > $b->country_name;
                            });
                            ?>
                            <select class="form-control" name="telephone" id="telephone" onChange="$('#telephone_code').val($('option:selected', this).val());">
                                <option  value="">-- Select --</option>
                                <?php
                                echo "<option data-countryid = '' value=''>Phone Code</option>";
                                foreach ($telephone_codes as $code) {
                                    echo '<option data-countryid = "' . $code->country_id . '" value="' . $code->telephone_code . '">' . $code->country_name . " " . $code->telephone_code . '</option>';
                                }
                                ?>
                            </select>
                            <input type="hidden" name="telephone_code" id="telephone_code" />
                           
                            <?php /*usort($telephone_codes, function($a, $b) {
                                return $a->telephone_code - $b->telephone_code;
                            });*/
                            ?>
                            <!--<select class="form-control" name="telephone_code" id="telephone_code">
                                <option  value="">-- Select --</option>
                                <?php //foreach ($telephone_codes as $code) { ?>
                                    <option   value="<?php //echo $code->telephone_code; ?>">
                                        <?php //echo $code->telephone_code; ?>
                                    </option>;

                                <?php //} ?>
                            </select>-->
                            <?php
                            echo form_label('Phone Number ', 'telephone_no');
                            echo form_input('telephone_no', '', array('id' => 'telephone_no', 'max-length' => '100', 'placeHolder' => 'Enter Phone Number'));
                            ?>
                        </div>
                        <div class="form-group"> 
                            <?php echo form_label("Subject", "subject"); ?>
<?php echo form_input('subject', '', array('id' => 'subject', 'max-length' => '100', 'placeHolder' => 'Enter Subject')); ?>
                        </div> 
                        <div class="form-group">  
                            <?php
                            echo form_label('Message ', 'message');
                            echo form_textarea(array('id' => 'message', 'rows' => '3', 'name' => 'message', 'placeHolder' => 'Enter Message '));
                            ?>
                        </div>
                        <div class="form-group"> 
<?php echo form_hidden('ipadres', $this->input->ip_address()); ?>

                        </div>
                        <?php echo form_submit('submit_button', 'Send', array('class' => 'btn btn-blue btn-lg', 'type' => 'submit')); ?>
<?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
