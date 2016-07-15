<script>
var jobupdateValidator = {
    jobupdateValidation: function () {
        $('#job_update').parent().removeClass("has-error has-danger");
        var error = "";
        
        if ($.trim($('#job_update').val()) == "") {
            error += "Please enter job update<br/>";
                $('#job_update').parent().addClass("has-error has-danger");
        }
        
        if (error) {
            Messages.error(error);
            return false;
        } else {
            return true;
        }
    }
 }
 function ValidateFileUpload(fInput) {
    var job_update_file = document.getElementById('job_update_file');
    var FileUploadPath = job_update_file.value;

//To check if user upload any file
    if (FileUploadPath == '') {
        alert("Please upload file");

    } else {
        var fileSize = job_update_file.files[0].size;

//The file uploaded is an image
     
            // To Display
            if (fileSize > 2000000){
                Messages.error("Only allows file size upto 2mb. ");
                fInput.value = '';
                return false; 
             }else{
                if (job_update_file.files && job_update_file.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        //$('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(job_update_file.files[0]);
                }
             }
 
    }
}
</script>
<?php if (!empty($this->session->flashdata('update_error_msg'))) { ?>
    <div class="alert alert-danger text-center">
        <?php echo $this->session->flashdata('update_error_msg'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading clearfix"><h4>Job updates</h4></div>

            <?php echo form_open_multipart(base_url() . "dashboard/job/submit_job_update", array('method' => 'post', 'onsubmit' => 'return jobupdateValidator.jobupdateValidation()')) ?>
            <?php
            echo form_hidden('job_id', $job_id);
            if (isset($from_order)) {
                echo form_hidden('from_order', $from_order);
            }
            ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo form_label('Post an update :', 'job_overview');
                            echo form_textarea(array('name' => 'job_update', 'id' => 'job_update', 'rows' => '2', 'placeHolder' => 'Type here'));
                            ?>
                        </div>

                    </div>

                    <!--  <div class="col-md-6">   
                          <div class="form-group">
                    <?php /* echo form_label('Status :', 'status');
                      $options = array(
                      'In progress' => 'In progress',
                      'Finished' => 'Finished',
                      'Cancel' => 'Cancel',
                      );


                      echo form_dropdown('job_status', $options, 'In progress', 'class = form-control');
                     */ ?>
                          </div>
                      </div>-->
                </div>

                <div class="row">

                    <div class="col-md-6"> 
                        <div class="form-group">
                            <?php
                            echo form_label('File type :', 'file_type_id_label');

                            echo form_dropdown('file_type_id', $job_file_types, '1');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="form-group">
                            <?php echo form_label("Upload Files:", "job_update_file"); ?>
                            <?php echo form_upload('job_update_file', '', array('id' => 'job_update_file', 'onchange' => 'return ValidateFileUpload(this)')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">  
                        <div class="form-group">
                            <?php echo form_submit('submit_button', 'Post Update', array('class' => 'btn btn-primary form-control', 'type' => 'submit','disabled'=>'disabled')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>