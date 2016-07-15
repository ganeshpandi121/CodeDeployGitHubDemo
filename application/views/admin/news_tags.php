<script>
var newstagValidator = {
      newstagValidation: function(){
        $('#tag_name').parent().removeClass("has-error has-danger");
        $('#description').parent().removeClass("has-error has-danger");
        var error = "";

        if ($.trim($('#tag_name').val()) == "") {
            error += "Please enter Tag Name<br/>";
            $('#tag_name').parent().addClass("has-error has-danger");
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
<div class="container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2>Add Content Tag</h2>
                    </div>
                </div>
                <?php if(!empty($success_msg)) echo $success_msg; ?>
                <?php
                $show_alert = 'style="display:none;"';
                if ($this->session->flashdata('error_msg') == true) {
                    $show_alert = 'style="display:block;"';
                }
                ?>
                <div class="alert alert-danger" id="newstag_alert" <?php echo $show_alert; ?>>    
                <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                
                <?php echo form_open_multipart(base_url() . 'admin/news-tags', array('id' => 'news_tag_form', 'onsubmit' => 'return newstagValidator.newstagValidation()')); ?> 

                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_label("Tag Name", "tag_name"); ?>
                        <?php echo form_input('tag_name', '', array('class' => 'form-control', 'id' => 'tag_name', 'placeHolder' => 'Tag Name', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php echo form_submit('submit_button', 'ADD TAG', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>  
        </div> 
    </div>
</div>