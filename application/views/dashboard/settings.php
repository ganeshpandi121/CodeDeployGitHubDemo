<script>
    var settingsController = {
        categoryValidation: function () {
            
            var isValid = false,
                    form = "category_form",
                    els = form.elements['sub_category[]'];

            i;
            for (i = 0; i < els.length; i += 1) {
                if (els[i].checked) {
                    isValid = true;
                }
            }
           
            $("#categories_form").submit();
        },
        regionValidation: function () {
            
            var isValid = false,
                    form = "region_form",
                    els = form.elements['region_name[]'];

            i;
            for (i = 0; i < els.length; i += 1) {
                if (els[i].checked) {
                    isValid = true;
                }
            }
            
            $("#region_form").submit();
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
            <div class="col-md-3">
                <ul id="side-bar" class="nav nav-tabs">
                    <li class="<?php if ($act == "category") echo "active"; ?>"><a data-toggle="tab" href="#category-menu">Categories</a></li>
                    <li class="<?php if ($act == "regions") echo "active"; ?>"><a data-toggle="tab" href="#region-menu">Regions</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                
                <div class="tab-content">
                   
                    <div id="category-menu" class="tab-pane fade <?php if ($act == "category") echo "in active"; ?>">
                        <h3>Category menu</h3>
                         <?php if (empty($supplier_categories)) { ?>
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Please submit your preferred categories here.
                                </div>
                            </div>
                        <?php } ?>
                        
                        <?php
                        $category_login = 'style="display:none;"';
                        if ($this->session->flashdata('error_msg') == true) {
                            $category_login = 'style="display:block;"';
                        }
                        ?>
                        <div class="col-md-10">
                            <div class="alert alert-danger" id="category_alert" <?php echo $category_login; ?>>
                                <?php echo $this->session->flashdata('error_msg'); ?>
                            </div>
                            <?php
                            $alert = ($success_cat != 0) ? "alert-success" : "alert-danger";
                            if (!empty($msg)) {
                                echo '<div class="alert ' . $alert . ' text-center">' . $msg . '</div>';
                            } else {
                                echo "";
                            }
                            ?>
                            <?php echo form_open("dashboard/settings", array('id' => 'categories_form', 'method' => 'post', 'onsubmit' => 'return settingsController.categoryValidation()')); ?>
                            <?php
                            $i = 0;
                            $c = 0;
                            echo "<div class='row'>";
                            foreach ($categories as $category) {
                                $chkCat = "";
                                $vals = $this->Supplier_model->sub_category_count($supplier_id);
                                $lenSub = count($category['sub_category']);
                                if (!empty($vals)) {
                                    foreach ($vals as $v) {
                                        if ($category['cat_id'] == $v->cat_id) {
                                            if ($v->count_subcat > 0) {
                                                $chkCat = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                echo "<div class='col-md-3 chkParent'>";
                                echo bootstrap_checkbox('main_category[]', "checkbox-inline no-indent text-capitalize checkbox-bold parentCheckBox tick", $category['cat_id'], $category['category_name'], $chkCat);
                                echo '<div class="form-group">';
                                if(!empty($category['sub_category'])){
                                    foreach ($category['sub_category'] as $cat) {
                                        $chk = "";
                                        if (!empty($supplier_categories)) {
                                            foreach ($supplier_categories as $subcat_selected) {

                                                if ($subcat_selected->sub_cat_id == $cat['sub_cat_id']) {
                                                    $chk = "true";
                                                    break;
                                                }
                                            }
                                        }
                                        echo bootstrap_checkbox('sub_category[]', "checkbox-inline no-indent text-capitalize childCheckBox chk" . $category['category_name'], $cat['sub_cat_id'], $cat['sub_category_name'], $chk, array('class' => $category['category_name']));
                                    }
                                }
                                echo "</div></div>";
                                $i++;
                                if ($i % 3 == 0)
                                    echo '</div><div class="row">';
                            }
                            echo "</div>";
                            ?>

                            <div class="row">
                                <div class="col-md-9 text-center">
                                    <div class="form-group"> 
                                        <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                                        <?php echo form_hidden('hdntype', 'category'); ?>
                                    </div> 
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div id="region-menu" class="tab-pane fade <?php if ($act == 'regions') echo "in active"; ?>">
                        <h3>Region menu</h3>
                        <?php if (empty($supplier_regions)) { ?>
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Please submit your preferred regions here.
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $region_login = 'style="display:none;"';
                        if ($this->session->flashdata('error_msg1') == true) {
                            $region_login = 'style="display:block;"';
                        }
                        ?>
                        <div class="col-md-10">
                            <div class="alert alert-danger" id="region_alert" <?php echo $region_login; ?>>
                                <?php echo $this->session->flashdata('error_msg'); ?>
                            </div>
                            <?php
                            $alert_reg = ($success_reg != 0) ? "alert-success" : "alert-danger";
                            echo (!empty($reg_msg)) ? '<div class="alert ' . $alert_reg . ' text-center">' . $reg_msg . '</div>' : "";
                            ?>
                            <?php echo form_open("dashboard/settings", array('id' => 'regions_form', 'method' => 'post', 'onsubmit' => 'return settingsController.regionValidation()')); ?>
                            <?php
                            $i = 0;
                            echo "<div class='row'>";
                            foreach ($regions as $reg) {
                                echo "<div class='col-md-3'>";
                                echo '<div class="form-group">';
                                $chk1 = "";
                                if (!empty($supplier_regions)) {
                                    foreach ($supplier_regions as $regions_selected) {

                                        if ($regions_selected->region_id == $reg->region_id) {
                                            $chk1 = "true";
                                            break;
                                        }
                                    }
                                }
                                echo bootstrap_checkbox('region_name[]', "checkbox-inline no-indent text-capitalize", $reg->region_id, $reg->region_name, $chk1);
                                echo "</div></div>";
                                $i++;
                                if ($i % 3 == 0)
                                    echo '</div><div class="row">';
                            }
                            echo "</div>";
                            ?>
                            <div class="row">
                                <div class="col-md-9 text-center">
                                    <div class="form-group"> 
                                        <?php echo form_submit('submit_button', 'Save Changes', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
<?php echo form_hidden('hdntype', 'region'); ?>
                                    </div> 
                                </div>
                            </div>
<?php echo form_close(); ?>
                        </div>

                    </div>

                </div>                    

            </div>

        </div>
    </div>
</div>