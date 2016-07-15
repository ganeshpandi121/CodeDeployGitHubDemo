
<script>
    $(function(){
        $('.btnDelete').on('click',function(){
            if(!confirm('Are you sure you want to Delete this Category?')){
                return false;
            }
        });
    });
</script>
<div class="container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2>Product Category</h2>
                    </div>
                </div>
                <?php if($this->session->flashdata('message')){?>
                <div class="alert alert-success">      
                <?php echo $this->session->flashdata('message')?>
                 </div>
                 <?php } ?>
                <table class="table table-striped" width="100%">
                            <tr>
                                <th>Category</th>
                                
                                <th>Actions</th>
                            </tr>
                            <?php 
                            if(!empty($product_categories)){
                                $base_url = $this->config->base_url();
                                foreach ($product_categories as $category){
                                    echo <<< EOD
                                        <tr>
                                            <td>{$category->category_name}</td>
                                        
                                            <td><a href="{$base_url}admin/product_category/{$category->cat_id}">Edit</a> | <a class="btnDelete" href="{$base_url}admin/product_category_delete/{$category->cat_id}">Delete</a></td>
                                        </tr>
EOD;
                                }
                                
                            }else{
                            ?>
                                <tr>
                                    <td colspan="2">No categories added.</td>
                                </tr>
                            <?php 
                                } 
                            ?>
                        </table>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">                               
                                <ul class="pagination">
                                    <?php echo $pagination_helper->create_links(); ?>
                               </ul>
                            </div>
                        </div>
                    </div>
            </div>  
        </div> 
    </div>
</div>