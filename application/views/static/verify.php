<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 "><br/>
                
                <?php if ($this->session->flashdata('verify_msg') == true) { ?>
                    <div class="alert alert-success" id="verify_alert">
                        <?php echo $this->session->flashdata('verify_msg'); ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error_verify_msg') == true) { ?>
                    <div class="alert alert-danger text-center">
                        <strong>Warning!</strong> 
                        <?php echo $this->session->flashdata('error_verify_msg');?>
                    </div>
                    
                <?php } ?>
            </div>            
        </div>


    </div>
</div>
