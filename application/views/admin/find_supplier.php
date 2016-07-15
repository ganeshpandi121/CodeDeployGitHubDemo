<script>
    var findsupplierValidator = {
        findsupplierValidation: function () {
            $('#company_name').parent().removeClass("has-error has-danger");
            $('#email').parent().removeClass("has-error has-danger");
            $('#telephone_code_1').parent().removeClass("has-error has-danger");
            $('#telephone_no').parent().removeClass("has-error has-danger");
            $('#logo_image').parent().removeClass("has-error has-danger");
            $('#description').parent().removeClass("has-error has-danger");
            
            var error = "";

            if ($.trim($('#company_name').val()) == "") {
                error += "Please enter Company Name<br/>";
                $('#company_name').parent().addClass("has-error has-danger");
            }
            
            var re = /\S+@\S+\.\S+/;
            var test_email = $('#email').val();
            if (re.test(test_email) == false) {
                error += "Please enter a Valid Email<br/>";
                $('#email').parent().addClass("has-error has-danger");
            }

            if ($('#telephone_code_1 option:selected').val() == "") {

                error += "Please select Phone Code<br/>";
                $('#telephone_code_1').parent().addClass("has-error has-danger");
            }

            if ($('#telephone_no').val() == "") {
                error += "Please enter Phone Number<br/>";
                $('#telephone_no').parent().addClass("has-error has-danger");
            }
            
            if( $('#category-menu').find("input[type='checkbox']:checked").length < 1){
                 error += "Please select any Category<br/>";
            }
            
            if( $('#region-menu').find("input[type='checkbox']:checked").length < 1){
                 error += "Please select any Region<br/>";
            }

            if ($.trim($('#description').val()) == "") {
                error += "Please enter Description<br/>";
                $('#description').parent().addClass("has-error has-danger");
            }

            /*if ($.trim($('#logo_image').val()) == "") {
                error += "Please upload Company Logo<br/>";
                $('#logo_image').parent().addClass("has-error has-danger");
            }*/
            
            if (error) {
                Messages.error(error);
                return false;
            } else {
                return true;
            }

        }
    }
    /**
     * Validation for upload file
     * checks specified image types
     * gif, png, jpeg, jpg
     */
    function ValidateFileUpload(fInput) {
        var jobFile = document.getElementById('logo_image');
        var FileUploadPath = jobFile.value;

        //To check if user upload any file
        if (FileUploadPath == '') {
            Messages.error("Please upload file");

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            var fileSize = jobFile.files[0].size;
            //The file uploaded is an image

            if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
                if (fileSize > 2000000){
                 Messages.error("Only allows file size upto 2mb. ");
                 fInput.value = '';
                 return false; 
                 }
                // To Display
                if (jobFile.files && jobFile.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        //$('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(jobFile.files[0]);
                }

            }

            //The file upload is NOT an image
            else {
                Messages.error("Only allows file types of GIF, PNG, JPG, JPEG. ");
                fInput.value = '';
                return false;

            }
        }
    }
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
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2><?php echo $action;?> Supplier</h2>
                    </div>
                </div>
                <?php 
                    if (!empty($success_msg)) echo $success_msg; 
                    echo $this->session->flashdata('succes_message');
                ?>
                <?php
                $show_alert = 'style="display:none;"';
                if ($this->session->flashdata('error_msg') == true) {
                    $show_alert = 'style="display:block;"';
                }
                ?>
                <div class="alert alert-danger" id="supplier_alert" <?php echo $show_alert; ?>>    
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo form_open_multipart(base_url() . 'admin/find_supplier', array('id' => 'news_form', 'onsubmit' => 'return findsupplierValidator.findsupplierValidation()')); ?> 
                <?php 
                    $supplier_id = !empty($find_supplier->find_supplier_id)? $find_supplier->find_supplier_id : "";
                    echo form_hidden("hdn_find_supplier_id", $supplier_id); 
                    echo form_hidden("user_id", $this->session->userdata('user_id')); 
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php $company = !empty($find_supplier->company_name) ? $find_supplier->company_name : ''; ?>
                        <?php echo form_label("Company Name", "company_name"); ?>
                        <?php echo form_input('company_name', $company, array('class' => 'form-control', 'id' => 'company_name', 'placeHolder' => 'Company Name', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $email = !empty($find_supplier->email) ? $find_supplier->email : ''; ?>
                        <?php echo form_label("Email", "news_permalink"); ?>
                        <?php echo form_input('email', $email, array('class' => 'form-control', 'id' => 'email', 'placeHolder' => 'Email', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div id="category-menu" class="">
                            <?php echo form_label("Categories", "categories"); ?>

                            <div class="col-md-12 cls-border-1">
                                <?php
                                $i = 0;
                                $c = 0;
                                echo "<div class='row'>";
                                foreach ($categories as $category) {
                                    $chkCat = "";
                                    if(!empty($count_find_supplier_categories)){
                                    $vals = $count_find_supplier_categories;
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
                                    }

                                    echo "<div class='col-md-4 chkParent'>";
                                    echo bootstrap_checkbox('main_category[]', "checkbox-inline no-indent text-capitalize checkbox-bold parentCheckBox tick", $category['cat_id'], $category['category_name'], $chkCat);
                                    echo '<div class="form-group">';


                                    foreach ($category['sub_category'] as $cat) {
                                        $chk = "";
                                        if (!empty($find_supplier_categories)) {
                                            foreach ($find_supplier_categories as $subcat_selected) {

                                                if ($subcat_selected->sub_category_id == $cat['sub_cat_id']) {
                                                    $chk = "true";
                                                    break;
                                                }
                                            }
                                        }
                                        echo bootstrap_checkbox('sub_category[]', "checkbox-inline no-indent text-capitalize childCheckBox chk" . $category['category_name'], $cat['sub_cat_id'], $cat['sub_category_name'], $chk, array('class' => $category['category_name']));
                                    }
                                    echo "</div></div>";
                                    $i++;
                                    if ($i % 3 == 0)
                                        echo '</div><div class="row">';
                                }
                                echo "</div>";
                                ?>


                            </div>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div id="region-menu">
                            <?php echo form_label("Regions", "regions"); ?>
                            <div class="col-md-12 cls-border-1">
                                <?php
                                $i = 0;
                                echo "<div class='row'>";
                                foreach ($regions as $reg) {
                                    echo "<div class='col-md-4'>";
                                    echo '<div class="form-group">';
                                    $chk1 = "";
                                    if (!empty($find_supplier_regions)) {
                                        foreach ($find_supplier_regions as $regions_selected) {

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
                            </div>

                        </div>
                    </div>
                </div><br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <?php
                            echo form_label("Phone Code", "telephone_code");
                            usort($telephone_codes, function($a, $b) {
                                return $a->country_name > $b->country_name;
                            });
                            ?>
                            <select class="form-control" name="telephone_code_1" id="telephone_code_1" onChange="$('#country_id').val($('option:selected', this).attr('data-countryid'));$('#telephone_code').val($('option:selected', this).val());">
                                <?php
                                echo "<option value=''>None</option>";
                                foreach ($telephone_codes as $country) {
                                    $selected = (!empty($find_supplier->country) && ($find_supplier->country==$country->country_id))? "selected" : "";
                                    echo '<option data-countryid = "' . $country->country_id . '" value="' . $country->telephone_code . '" '.$selected.'>' . $country->country_name . " " . $country->telephone_code . '</option>';
                                }
                                ?>
                            </select>
                            <?php 
                                $telephone_code = !empty($find_supplier->telephone_code)? $find_supplier->telephone_code:"";
                                $country = !empty($find_supplier->country)? $find_supplier->country : "";
                            ?>
                            <input type="hidden" name="country_id" id="country_id" value="<?php echo $country;?>"/>
                            <input type="hidden" name="telephone_code" id="telephone_code" value="<?php echo $telephone_code;?>"/>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">  
                            <?php echo form_label("Phone Number", "telephone_no"); ?>
                            <?php $telephone_no = !empty($find_supplier->telephone_number)? $find_supplier->telephone_number:"";?>
                                
                            <?php echo form_input('telephone_no', $telephone_no, array('id' => 'telephone_no', 'placeHolder' => 'Enter Phone Number')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php $description = !empty($find_supplier->description) ? $find_supplier->description : ''; ?>
                        <?php
                        echo form_label('Description ', 'description');
                        echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $description, 'rows' => '3', 'placeHolder' => 'Category Description '));
                        ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $image = !empty($find_supplier->company_logo) ? $find_supplier->company_logo : ''; ?>
                        <?php echo form_label("Upload Company Logo", "logo_image"); ?><br/>
                        <?php if ($image) { ?>
                            <img src="<?php echo $this->config->base_url() . "uploads/company/" . $image; ?>" width="150" height="150" />
                            <br/><br/>
                        <?php } ?>
                        <input type="hidden" name="hdnImage" value="<?php echo $image; ?>">
                        <?php echo form_upload('logo_image', '', array('id' => 'logo_image', 'onchange' => 'return ValidateFileUpload(this)')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php $btnValue = !empty($find_supplier->find_supplier_id) ? "Update " : "Add "; ?>
                            <?php echo form_submit('submit_button', $btnValue . 'Supplier', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>   
        </div> 
    </div>
</div>