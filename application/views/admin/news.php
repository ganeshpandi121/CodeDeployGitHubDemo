<script src="<?php echo $this->config->base_url(); ?>styles/js/tinymce/tinymce.min.js"></script>
<script>tinymce.init({selector: '#description',
        height: 500,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ]});


</script>

<script>
    var newsValidator = {
        newsValidation: function () {
            tinyMCE.triggerSave();
            $('#news_title').parent().removeClass("has-error has-danger");
            $('#news_permalink').parent().removeClass("has-error has-danger");
            $('#description').parent().removeClass("has-error has-danger");
            $('#news_category_id').parent().removeClass("has-error has-danger");
           // $('#news_subcategory_id').parent().removeClass("has-error has-danger");
            $('#meta_description').parent().removeClass("has-error has-danger");
            $('#meta_keyword').parent().removeClass("has-error has-danger");
            $('#meta_title').parent().removeClass("has-error has-danger");
            var error = "";

            if ($.trim($('#news_title').val()) == "") {
                error += "Please enter News Tittle<br/>";
                $('#news_title').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#news_permalink').val()) == "") {
                error += "Please enter News Url<br/>";
                $('#news_permalink').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#description').val()) == "") {
                error += "Please enter News Description<br/>";
                $('#description').parent().addClass("has-error has-danger");
            }

            if ($('#news_category_id option:selected').val() == "0") {

                error += "Please select Category<br/>";
                $('#news_category_id').parent().addClass("has-error has-danger");
            }
            
            /*if ($('#news_subcategory_id option:selected').val() == "0") {

                error += "Please select Subcategory<br/>";
                $('#news_subcategory_id').parent().addClass("has-error has-danger");
            }*/

            if ($.trim($('#meta_title').val()) == "") {
                error += "Please enter Meta Tittle<br/>";
                $('#meta_title').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#meta_keyword').val()) == "") {
                error += "Please enter Meta Keyword<br/>";
                $('#meta_keyword').parent().addClass("has-error has-danger");
            }

            if ($.trim($('#meta_description').val()) == "") {
                error += "Please enter Meta Description<br/>";
                $('#meta_description').parent().addClass("has-error has-danger");
            }

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
     * gif, png, jpeg, jpg, doc, docx 
     */
    function ValidateFileUpload(fInput) {
        var jobFile = document.getElementById('news_image');
        var FileUploadPath = jobFile.value;

        //To check if user upload any file
        if (FileUploadPath == '') {
            Messages.error("Please upload file");

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

            //The file uploaded is an image

            if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

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
    
    $(function(){
        $('#news_title').on('blur', function(){
            var strThis = $(this).val();
            strUrl = strThis.replace(/\s+/g, '-').toLowerCase();
            $('#news_permalink').val(strUrl);
        });
        
        $('#news_category_id').on('change', function(){
            var cat_id = $(this).val();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('news') . '/'; ?>ajax_subcategories",
                data: {
                    cat_id: cat_id
                },
                dataType: 'html'
            })
                    .done(function (response) {
                        //alert( "Data :" + msg );
                        $('.view_sub_category').html(response);
                    });
        });
    });

function getSubDropdown(sel)
{
var selectedValue=sel.options[sel.selectedIndex].text;

document.getElementById('main_category_name_hidden').value=selectedValue;
if(selectedValue=='Product'){
    document.getElementById("prod_cat").style.display='inline';
    document.getElementById("news_cat").style.display='none';
    document.getElementById("prod_subcat").style.display='inline';
}
else{
    document.getElementById("prod_cat").style.display='none';
    document.getElementById("prod_subcat").style.display='none';
    document.getElementById("news_cat").style.display='inline';
}
}   
</script>
<script>
    $(document).ready(function() {
        var select_cat_element = document.getElementById('news_category_id');
       var selectedValue= select_cat_element.options[select_cat_element.selectedIndex].text;
       document.getElementById('main_category_name_hidden').value=selectedValue;
       if(selectedValue == 'Product'){
        document.getElementById("prod_cat").style.display='inline';
        document.getElementById("news_cat").style.display='none';
        document.getElementById("prod_subcat").style.display='inline';
    }
    else{
        document.getElementById("prod_cat").style.display='none';
        document.getElementById("prod_subcat").style.display='none';
        document.getElementById("news_cat").style.display='inline';
    }

});
     var baseurl = "<?php echo base_url(); ?>";
    function getSubcategories() {
        $catID = $('#category').val();
       // alert($catID);
        $.ajax({
            type: "POST",
            url: baseurl + "ajax/get_sub_categories ",
            data: {
                "categoryID": $catID,
                "isAjax": true
            },
            dataType: 'json',
            success: function (data) {

                var select = $("#product_subcategory_id"), options = '';
                select.empty();

                for (var i = 0; i < data.length; i++)
                {
                    options += "<option value='" + data[i].sub_cat_id + "'>" + data[i].sub_category_name + "</option>";
                }

                select.append(options);
            }
        });
    }
</script>
<div class="container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2><?php echo $action; ?> Content</h2>
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
                <div class="alert alert-danger" id="news_alert" <?php echo $show_alert; ?>>    
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php echo form_open_multipart(base_url() . 'admin/content', array('id' => 'news_form', 'onsubmit' => 'return newsValidator.newsValidation()')); ?> 
                <?php echo form_hidden("hdn_news_id", $news_id); ?>
                <input type="hidden"  id="main_category_name_hidden" name="main_category_name_hidden">
                <?php
                $meta_id = !empty($news_data->meta_id) ? $news_data->meta_id : '';
                echo form_hidden("hdn_meta_id", $meta_id);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php $news_title = !empty($news_data->news_title) ? $news_data->news_title : ''; ?>
                        <?php echo form_label("Title", "news_title"); ?>
                        <?php echo form_input('news_title', $news_title, array('class' => 'form-control', 'id' => 'news_title', 'placeHolder' => 'Content Title', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $news_url = !empty($news_data->news_permalink) ? $news_data->news_permalink : ''; ?>
                        <?php echo form_label("Url", "news_permalink"); ?>
                        <?php echo form_input('news_permalink', $news_url, array('class' => 'form-control', 'id' => 'news_permalink', 'placeHolder' => 'Content Url', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $news_description = !empty($news_data->description) ? $news_data->description : ''; ?>
                        <?php
                        echo form_label('Description ', 'description');
                        echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $news_description, 'rows' => '3', 'placeHolder' => 'Content Description '));
                        ?>
                    </div>
                </div><br/>
                

                <div class="row">
                    <div class="col-md-12">
                        <?php $news_cat_id = !empty($news_data->news_category_id) ? $news_data->news_category_id : ''; ?>
                        <?php echo form_label("Category", "news_category"); ?>
                        <select class="form-control" name="news_category_id" id="news_category_id" onchange="getSubDropdown(this)">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($news_categories as $category) {
                                $selected = ($news_cat_id == $category->news_category_id) ? "selected" : "";
                                echo '<option value="' . $category->news_category_id . '" ' . $selected . '>' . $category->category_name . '</option>';
                            }
                            ?>
                            
                        </select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12" style="display:" id="news_cat">
                        <?php $news_subcategory_id = !empty($news_data->news_subcategory_id) ? $news_data->news_subcategory_id : ''; ?>
                        <?php echo form_label("News Subcategory", "news_subcategory"); ?>
                        <div class="view_sub_category">
                        <select class="form-control" name="news_subcategory_id" id="news_subcategory_id">
                            <option value="0">-- Select --</option>
                            <?php
                            if($news_subcategories){
                                                               
                                foreach ($news_subcategories as $subcategory) {
                                    $selected = ($news_subcategory_id == $subcategory->news_subcategory_id) ? "selected" : "";
                                    echo '<option value="' . $subcategory->news_subcategory_id . '" ' . $selected . '>' . $subcategory->subcategory_name . '</option>';
                                }
                            }
                            ?>
                        </select>

                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12" style="display:none" id="prod_cat" >
                        
                        <?php echo form_label("Product Category", "product_category"); ?>
                        <select class="form-control" name="product_category_id" id="category" onchange="getSubcategories()">
                            <option value="0">-- Select --</option>
                            <?php
                            
                            foreach ($product_categories as $category) {
                               
                                $selected = ( $news_data->cat_id == $category ->cat_id) ? "selected=selected" : "";
                                echo "<option value=" . $category->cat_id . " " . $selected . ">" . $category->category_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12" style="display:none" id="prod_subcat">
                        
                        <?php  echo form_label("Product SubCategory", "product_subcategory"); 
                        //echo "<pre>";print_r($product_subcategories);?>
                        <select class="form-control" name="product_subcategory_id" id="product_subcategory_id">
                            <option value="0">-- Select --</option>
                            <?php 
                            foreach ($product_subcategories as $sub_category) { 
                                $selected = ($news_data->sub_cat_id == $sub_category->sub_cat_id) ? "selected=selected" : "";
                                echo "<option value=" . $sub_category->sub_cat_id . " " . $selected . ">" . $sub_category->sub_category_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $meta_title = !empty($news_data->meta_title) ? $news_data->meta_title : ''; ?>
                        <?php echo form_label("Tags", "tag"); ?>
                        <?php echo form_input('tag', '', array('class' => 'form-control', 'id' => 'tag', 'placeHolder' => 'Tags', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $meta_title = !empty($news_data->meta_title) ? $news_data->meta_title : ''; ?>
                        <?php echo form_label("Meta Tittle", "meta_title"); ?>
                        <?php echo form_input('meta_title', $meta_title, array('class' => 'form-control', 'id' => 'meta_title', 'placeHolder' => 'Meta Title', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $meta_keyword = !empty($news_data->meta_keyword) ? $news_data->meta_keyword : ''; ?>
                        <?php echo form_label("Meta Keyword", "meta_keyword"); ?>
                        <?php echo form_input('meta_keyword', $meta_keyword, array('class' => 'form-control', 'id' => 'meta_keyword', 'placeHolder' => 'Meta Keyword', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $meta_description = !empty($news_data->meta_description) ? $news_data->meta_description : ''; ?>
                        <?php echo form_label("Meta Description", "meta_description"); ?>
                        <?php echo form_input('meta_description', $meta_description, array('class' => 'form-control', 'id' => 'meta_description', 'placeHolder' => 'Meta Description', 'max-length' => '100')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <?php $news_image = !empty($news_data->image_path) ? $news_data->image_path : ''; ?>
                        <?php echo form_label("Upload Image", "news_image"); ?><br/>
                        <?php if ($news_image) { ?>
                            <img src="<?php echo $this->config->base_url() . "uploads/news/" . $news_image; ?>" width="150" height="150" />
                        <?php } ?>
                        <input type="hidden" name="hdnImage" value="<?php echo $news_image; ?>"><br/><br/>
                        <?php echo form_upload('news_image', '', array('id' => 'news_image', 'onchange' => 'return ValidateFileUpload(this)')); ?>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <?php $btnValue = !empty($news_id) ? "Update " : "Add "; ?>
                            <?php echo form_submit('submit_button', $btnValue . 'Content', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>   
        </div> 
    </div>
</div>