<script>
    var newssubcategoryValidator = {
        newssubcategoryValidation: function () {
            $('#subcategory_name').parent().removeClass("has-error has-danger");
            $('#description').parent().removeClass("has-error has-danger");
            var error = "";

            if ($('#news_category_id option:selected').val() == "0") {

                error += "Please select Category<br/>";
                $('#news_category_id').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#subcategory_name').val()) == "") {
                error += "Please enter Subcategory Name<br/>";
                $('#subcategory_name').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#description').val()) == "") {
                error += "Please enter Description<br/>";
                $('#description').parent().addClass("has-error has-danger");
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
                        <h2><?php echo $action; ?> Content Subcategory</h2>
                    </div>
                </div>
                <?php
                if (!empty($success_msg))
                    echo $success_msg;
                echo $this->session->flashdata('succes_message');
                ?>
                <?php
                $show_alert = 'style="display:none;"';
                if ($this->session->flashdata('error_msg') == true) {
                    $show_alert = 'style="display:block;"';
                }
                ?>
                <div class="alert alert-danger" id="newscategory_alert" <?php echo $show_alert; ?>>    
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo form_open_multipart(base_url() . 'admin/news-subcategory', array('id' => 'news_subcategory_form', 'onsubmit' => 'return newssubcategoryValidator.newssubcategoryValidation()')); ?> 
                <?php echo form_hidden("news_subcategory_id", $subcat_id); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php $news_category_id = !empty($news_category_id) ? $news_category_id : ''; ?>
                        <?php echo form_label("Category", "news_category"); ?>
                        <select class="form-control" name="news_category_id" id="news_category_id">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($news_categories as $category) {
                                $selected = ($news_category_id == $category->news_category_id) ? "selected" : "";
                                echo '<option value="' . $category->news_category_id . '" ' . $selected . '>' . $category->category_name . '</option>';
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
                        <?php
                        echo form_label('Description ', 'description');
                        echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $description, 'rows' => '3', 'placeHolder' => 'Subcategory Description '));
                        ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php $btnValue = !empty($subcat_id) ? "UPDATE " : "ADD "; ?>
                            <?php echo form_submit('submit_button', $btnValue . 'SUBCATEGORY', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div> 
    </div>
</div>