<script>
    $(function(){
        $('.btnDelete').on('click',function(){
            if(!confirm('Are you sure you want to delete this news?')){
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
                        <h2>Product</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th width="200">Title</th>
                                <th>Description</th>
                                <th width="150">Actions</th>
                            </tr>
                            <?php 
                            if(!empty($product_list)){
                                $base_url = $this->config->base_url();
                                foreach ($product_list as $product){
                                    $description = substr($product->description,0,200);
                                    echo <<< EOD
                                        <tr>
                                            <td>{$product->news_title}</td>
                                            <td>{$description}</td>
                                            <td><a href="{$base_url}admin/content/{$product->news_id}">Edit</a> | <a class="btnDelete" href="{$base_url}news/product_delete/{$product->news_id}">Delete</a></td>
                                        </tr>
EOD;
                                }
                                
                            }else{
                            ?>
                                <tr>
                                    <td colspan="2">No Results</td>
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
    </div>
</div>