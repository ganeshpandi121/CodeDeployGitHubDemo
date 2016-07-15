<script>
    var baseurl = "<?php echo base_url(); ?>";
    function getSubcategories() {
        $catID = $('#category').val();

        $.ajax({
            type: "POST",
            url: baseurl + "ajax/get_sub_categories ",
            data: {
                "categoryID": $catID,
                "isAjax": true
            },
            dataType: 'json',
            success: function (data) {

                var select = $("#sub-category"), options = '';
                select.empty();

                for (var i = 0; i < data.length; i++)
                {
                    options += "<option value='" + data[i].sub_cat_id + "'>" + data[i].sub_category_name + "</option>";
                }

                select.append(options);
            }
        });
    }
    $(function () {
        $('.email-seller').on('click', function () {
            $('#message_err').removeClass('alert alert-danger fade in');
            $('#message_err').html('');
            var is_find_supplier = $(this).attr('rel');
            var sd_id = $(this).attr('data');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('contact') . '/'; ?>compose_email",
                data: {
                    sd_id: sd_id,
                    is_find_supplier: is_find_supplier
                },
                dataType: 'html',
                success: function (response) {
                     $('.view-email-supplier').html(response);
                 }
            });
           
        });
        
    });
    function validate_popup() {
        var content = $('#email_body').val();
        if(content == '' || content.length == 0 ){
            $('#message_err').addClass('alert alert-danger fade in');
            $('#message_err').html('Please enter message');
            return false;
        }
    }
</script>
<?php if (!empty($this->session->flashdata('find_success_msg'))) { ?>
    <div class="alert alert-success text-center">
        <?php echo $this->session->flashdata('find_success_msg'); ?>
    </div>
<?php } ?>
<?php if (!empty($this->session->flashdata('find_error_msg'))) { ?>
    <div class="alert alert-danger text-center">
        <?php echo $this->session->flashdata('find_error_msg'); ?>
    </div>
<?php } ?>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-justify">
                <h2>Find Supplier Now</h2>
                <div class="row">
                    <?php echo form_open($this->config->base_url() . 'find_supplier_now', array("method" => "get")) ?>
                    <div class="col-md-3"> <label>  Category  </label> 
                        <select class="form-control" name="category" id="category" onchange="getSubcategories()">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($categories as $category) {
                                $selected = (!empty($_GET['category']) && ($_GET['category'] == $category->cat_id)) ? 'selected="selected"' : "";
                                echo "<option value=" . $category->cat_id . "  $selected >" . $category->category_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Sub Category</label>
                        <select class="form-control" name="sub-category" id="sub-category">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($sub_categories as $sub_category) {
                                 $selected = (!empty($_GET['sub-category']) && ($_GET['sub-category'] == $sub_category->sub_cat_id)) ? 'selected="selected"' : " ";
                                echo "<option value=" . $sub_category->sub_cat_id . " $selected >" . $sub_category->sub_category_name . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Region</label>
                        <select class="form-control" name="region" id="sub-region">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($regions as $region) {
                                $selected = (!empty($_GET['region']) && ($_GET['region'] == $region->region_id)) ? 'selected="selected"' : "";
                                echo "<option value=" . $region->region_id . " $selected >" . $region->region_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Country</label>
                        <?php 
                            usort($countries, function($a, $b) {
                                return $a->country_name > $b->country_name;
                            });
                        ?>
                        <select class="form-control" name="country" id="country">
                            <option value="0">-- Select --</option>
                            <?php
                            foreach ($countries as $country) {
                                $selected = (!empty($_GET['country']) && ($_GET['country'] == $country->country_id)) ? 'selected="selected"' : "";
                                echo "<option value=" . $country->country_id . " $selected >" . $country->country_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 text-center">
                        <br/>
                        <?php
                        echo form_submit('submit', 'Submit', array('class' => 'btn btn-success', 'id' => 'login_button'));
                        ?>
                        <br/>
                        <br/>
                    </div>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($filtered_sellers_list)) {
                foreach ($filtered_sellers_list as $list) {
                    ?>
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                <?php echo ($list->company_name) ? $list->company_name : $list->user_first_name . ' ' . $list->user_last_name; ?>
                                <div class='pull-right'>
                                    <?php if (!empty($list->country_id)) { ?>
                                        <img  src="<?php echo base_url(); ?>styles/images/flags-mini/<?php echo $list->iso_country_code; ?>.png" data-toggle="tooltip" 
                                              alt="<?php echo $list->country_name; ?> "
                                              title="<?php echo $list->country_name; ?>" />                            
                                          <?php } ?>
                                </div>
                            </div>
                            <!-- <div class="panel-body">
                            <?php //echo ($list->website_url)? $list->website_url: '' ;  ?>
                            </div> -->
                            <div class="panel-footer clearfix">
                                <?php if ($this->session->userdata('user_type_id') != 1) { 
                                    $is_find_supplier = !empty($list->find_supplier_id)? '1': '0';?> 
                                    <a class="btn btn-info pull-left email-seller" data-toggle="modal" data-target="#email-supplier" data="<?php echo $list->sd_id; ?>" rel="<?php echo $is_find_supplier;?>">
                                        Email Supplier
                                    </a>
                                    <a href="<?php echo base_url('find_supplier_now/request/2' . '/' . $list->sd_id.'?find_supplier='.$is_find_supplier); ?>" class="btn btn-warning pull-right">
                                        Request A Call
                                    </a>
                                    <?php
                                } else {
                                    echo "You are Admin";
                                }
                                ?>   
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                    <br/>
                    <div class="alert alert-info">
                        <strong>Info!</strong> No Supplier Found. 
                    </div>

            <?php }?>
        </div>
    </div>
</div>


<div class="modal fade" id="email-supplier" role="dialog">
    <div class="modal-dialog view-email-supplier">

        
    </div>
    
</div>