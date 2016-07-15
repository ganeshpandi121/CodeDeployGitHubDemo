<script>
var productsubcategoryValidator = {
      productsubcategoryValidation: function(){
        $('#subcategory_name').parent().removeClass("has-error has-danger");
        $('#description').parent().removeClass("has-error has-danger");
        var error = "";
        
        if ($('#product_category_id option:selected').val() == "0") {

                error += "Please select Category<br/>";
                $('#product_category_id').parent().addClass("has-error has-danger");
        }
        
        if ($.trim($('#subcategory_name').val()) == "") {
            error += "Please enter Subcategory Name<br/>";
            $('#subcategory_name').parent().addClass("has-error has-danger");
        }
        if (error) {
            Messages.error(error);
            return false;
        } else {
            return true;
        }

       }
</script>
<div class="container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2><?php echo $action;?> Product Subcategory</h2>
                    </div>
                </div>
                <?php
                if ($this->session->flashdata('success_message')) {?>
                    <div class="alert alert-success text-center">
                        <?php echo $this->session->flashdata('success_message'); ?>
                    </div>
                <?php }
                ?>
                <?php if ($this->session->flashdata('error_msg')) {?>
                    <div class="alert alert-danger" id="productcategory_alert">    
                        <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                    
                <?php } ?>
                <?php echo form_open(base_url() .'admin/product_subcategory/'.$subcat_id, array('id' => 'product_subcategory_form', 'onsubmit' => 'return productsubcategoryValidator.productsubcategoryValidation()')); ?> 
                
                <div class="row">
                    <div class="col-md-12">
                        <label>Category</label>

                        <select class="form-control" name="product_category_id" id="product_category_id">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($categories as $category) {
                                $selected = ($product_category_id == $category->cat_id) ? "selected" : "";
                                echo "<option value=" . $category->cat_id ." " . $selected . ">" . $category->category_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_label("Subcategory Name", "subcategory_name"); ?>
                        <?php echo form_input('subcategory_name', $subcategory_name, array('class' => 'form-control', 'id' => 'subcategory_name', 'placeHolder' => 'Subcategory Name', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php $btnValue = !empty($subcat_id) ? "Update " : "Add "; ?>
                            <?php echo form_submit('submit_button', $btnValue.' Product Subcategory', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                             <a class="btn btn-blue" href="<?php echo base_url().'admin/view-product-subcategory';?>">Back</a>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div> 
    </div>
</div>