<script>
    var settingsController = {
        categoryValidation: function () {
           var error = "";
           if( $('#category-menu').find("input[type='checkbox']:checked").length < 1){
                 error += "Please select any Category<br/>";
           }
           if (error) {
                Messages.error(error);
                return false;
            } else {
                return true;
            }
        }
    };

    $(function () {
        $(document).on("click", ".tick", function () {
            var chk = $(this).find("input[name='main_category[]']").is(':checked');
            
            if (chk)
            {
                $(this).siblings('.form-group')
                        .find("input[type='checkbox']")
                        .prop('checked', true);
            } else
            {
                $(this).siblings('.form-group')
                        .find("input[type='checkbox']")
                        .prop('checked', false);
            }
        });
        
        $(document).on('click', '.childCheckBox > input[type="checkbox"]', function() {
            var parent = $(this).parents('.chkParent');
            if( parent.find('.form-group').find("input[type='checkbox']:checked").length >= 1){
              parent.find("input[name='main_category[]']").prop('checked',true);  
            }
            if( parent.find('.form-group').find("input[type='checkbox']:checked").length == parent.find('.form-group').find("input[type='checkbox']").length) 
            {
               parent.find("input[name='main_category[]']").prop('checked',true);
            } else if( parent.find('.form-group').find("input[type='checkbox']:checked").length == 0 ) 
            {
               parent.find("input[name='main_category[]']").prop('checked',false);
            }
        });
    });
    
</script>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                
                <div class="row">
                    <div class="col-md-12">
                        <h3>Add Seller Categories</h3>
                    </div>
                </div>
                <?php
                if ($this->session->flashdata('error_msg') == true) {?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                <?php }?>
                <div class="row">
                    <div class="col-md-12">
                    <?php echo form_open("dashboard/become_seller", array('name' => 'seller_category_form', 'id' => 'seller_category_form', 'method' => 'post', 'onsubmit' => 'return settingsController.categoryValidation()')); 

                    ?>
                    <div id="category-menu" class="">
                    <?php
                    if(!empty($categories)){
                        $i = 0;
                        echo "<div class='row'>";
                        foreach ($categories as $category) {

                            echo "<div class='col-md-3 chkParent'>";
                            echo bootstrap_checkbox('main_category[]', "checkbox-inline no-indent text-capitalize checkbox-bold parentCheckBox tick", $category['cat_id'], $category['category_name']);
                            echo '<div class="form-group">';


                            foreach ($category['sub_category'] as $cat) {

                                echo bootstrap_checkbox('sub_category[]', "checkbox-inline no-indent text-capitalize childCheckBox chk" . $category['category_name'], $cat['sub_cat_id'], $cat['sub_category_name'], '', array('class' => $category['category_name']));
                            }
                            echo "</div></div>";
                            $i++;
                            if ($i % 4 == 0)
                                echo '</div><div class="row">';
                        }
                        echo "</div>";
                    
                    ?>
                        <div class="row">
                            <div class="col-md-9 text-center">
                                <div class="form-group"> 
                                    <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                      <a href="<?php echo base_url();?>" class="btn btn-blue" role="button">Cancel</a>
                                </div> 

                            </div>
                        </div>
                        <?php echo form_close();  }?>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>