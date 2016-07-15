<script>
    var forgotController = {        
    forgotValidation: function () {
            $('#forgot_password_email').parent().removeClass("has-error has-danger");              
            var error = ""; 
            
            var re = /\S+@\S+\.\S+/;
            var test_email = $('#forgot_password_email').val();
            if (re.test(test_email) == false) {                
                error += "Please enter a valid email address.<br/>";
                $('#forgot_password_email').parent().addClass("has-error has-danger");

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
        <?php
        $show_alert = 'style="display:none;"';
        if ($this->session->flashdata('error_msg') == true) {
            $show_alert = 'style="display:block;"';
        }?>
        <h2>Forgot Password</h2>
        <?php
        if ($msg != '') {
            $alert_cls = (!empty($success))? "alert-success" : "alert-danger";
            echo '<div class="alert '.$alert_cls.'">' . $msg . '</div>';
        }
        ?>   
        <div class="alert alert-danger" id="forgot_alert" <?php echo $show_alert; ?>>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
        <?php echo form_open($this->config->base_url() ."forgot_password", array('id' => 'forgot_form', 'onsubmit' => 'return forgotController.forgotValidation()')); ?>
        <div class="form-group"> 
            <?php echo form_input('email', '', array('class' => 'form-control', 'id' => 'forgot_password_email', 'max-length' => '100', 'placeHolder' => 'Enter Email')); ?>
        </div> 
        <?php echo form_submit('forgot_password_button', 'Reset Password', array('class' => 'btn btn-blue')); ?>
        <?php echo form_close(); ?>
    </div> 
</div>
