<script>
    var resetController = {
        resetValidation: function () {
            $('#new_password').parent().removeClass("has-error has-danger");
            $('#confirm_password').parent().removeClass("has-error has-danger");
            var error = "";

            var passRes = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}$/;

            var pass = $('#new_password').val();
            if (passRes.test(pass) == false) {
                error += "Password must be at least 8 characters, no more than 12 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit.<br/>";
                $('#new_password').parent().addClass("has-error has-danger");

            }

            if($('#confirm_password').val() != ""){
                if ($('#new_password').val() != $('#confirm_password').val()) {
                    error += "New Password And Confirm Password Should be same";
                    $('#confirm_password').parent().addClass("has-error has-danger");

                }
            }else{
                error += "Please enter Confirm Password<br>";
                $('#confirm_password').parent().addClass("has-error has-danger");
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

    <div class="col-md-4 col-md-offset-4">
        <h2>Reset Password</h2>
        <?php
        $show_alert = 'style="display:none;"';
        if ($this->session->flashdata('error_msg') == true) {
            $show_alert = 'style="display:block;"';
        }
        ?>
        <?php
        if ($msg != '') {
            $alert_cls = ($msg=="Password changed")? "alert-success" : "alert-danger";
            echo '<div class="alert '.$alert_cls.'">' . $msg . '</div>';
        }
        ?>   
        <div class="alert alert-danger" id="reset_alert" <?php echo $show_alert; ?>>
        <?php echo $this->session->flashdata('error_msg'); ?>
        </div>  
            <?php echo form_open("User/reset_password/" . $this->uri->segment(3), array('' => 'reset_form', 'method' => 'post', 'onsubmit' => 'return resetController.resetValidation()')); ?>
        <div class="form-group"> 
<?php echo form_password('new_password', '', array('class' => 'form-control', 'id' => 'new_password', 'max-length' => '100', 'placeHolder' => 'New Password')); ?>
        </div> 
        <div class="form-group"> 
<?php echo form_password('confirm_password', '', array('class' => 'form-control', 'id' => 'confirm_password', 'max-length' => '100', 'placeHolder' => 'Confirm Password')); ?>
        </div>
        <div class="form-group"> 
            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $user_id; ?>" /> 
            <input type="hidden" class="form-control" name="token" id="token" value="<?php echo $token; ?>" /> 
        <?php //echo form_hidden('user_id', '', array('class' => 'form-control', 'id' => 'user_id', set_value("1")));  ?>
        </div> 
        <?php echo form_submit('reset_password_button', 'Reset Password', array('class' => 'btn btn-blue')); ?>
<?php echo form_close(); ?>
    </div> 
</div>
