<script>
    $(function () {
        $('.btnDelete').on('click', function () {
            if (!confirm('Are you sure you want to delete this news?')) {
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
                        <h2>Content Subcategory</h2>
                    </div>
                </div>
                <table class="table table-striped" width="100%">
                    <tr>
                        <th>Subcategory</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    if (!empty($news_subcategories)) {
                        $base_url = $this->config->base_url();
                        foreach ($news_subcategories as $subcategory) {
                            echo <<< EOD
                                        <tr>
                                            <td>{$subcategory->subcategory_name}</td>
                                            <td>{$subcategory->description}</td>
                                            <td><a href="{$base_url}admin/news-subcategory/{$subcategory->news_subcategory_id}">Edit</a> | <a href="{$base_url}admin/news-subcategory-delete/{$subcategory->news_subcategory_id}" class="btnDelete">Delete</a></td>
                                        </tr>
EOD;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="2">No Subcategories added.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>  
        </div> 
    </div>
</div>