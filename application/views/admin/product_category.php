<script>
var productcategoryValidator = {
      productcategoryValidation: function(){
        $('#category_name').parent().removeClass("has-error has-danger");
        var error = "";

        if ($.trim($('#category_name').val()) == "") {
            error += "Please enter Category Name<br/>";
            $('#category_name').parent().addClass("has-error has-danger");
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
                        <h2><?php echo $action;?> Product Category</h2>
                    </div>
                </div>
                <?php 
                    if(!empty($success_msg)) echo $success_msg; 
                    echo $this->session->flashdata('succes_message');
                ?>
                <?php
                $show_alert = 'style="display:none;"';
                if ($this->session->flashdata('error_msg') == true) {
                    $show_alert = 'style="display:block;"';
                }
                ?>
                <div class="alert alert-danger" id="productcategory_alert" <?php echo $show_alert; ?>>    
                <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo form_open( base_url() . 'admin/product_category',array('id' => 'product_category_form', 'onsubmit' => 'return productcategoryValidator.productcategoryValidation()')); ?> 
                <?php echo form_hidden("product_category_id", $cat_id);?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_label("Category Name", "category_name"); ?>
                        <?php echo form_input('category_name', $category_name, array('class' => 'form-control', 'id' => 'category_name', 'placeHolder' => 'Category Name', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php $btnValue = !empty($cat_id) ? "Update " : "Add "; ?>
                            <?php echo form_submit('submit_button', $btnValue.'Product Category', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>  
                            <a class="btn btn-blue" href="<?php echo base_url().'admin/view-product-category';?>">Back</a>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div> 
    </div>
</div>