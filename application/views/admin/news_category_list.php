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
                        <h2>Content Category</h2>
                    </div>
                </div>
                <table class="table table-striped" width="100%">
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <?php 
                            if(!empty($news_categories)){
                                $base_url = $this->config->base_url();
                                foreach ($news_categories as $category){
                                    echo <<< EOD
                                        <tr>
                                            <td>{$category->category_name}</td>
                                            <td>{$category->description}</td>
                                            <td><a href="{$base_url}admin/news-category/{$category->news_category_id}">Edit</a> | <a href="{$base_url}admin/news-category-delete/{$category->news_category_id}" class="btnDelete">Delete</a></td>
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
            </div>  
        </div> 
    </div>
</div>