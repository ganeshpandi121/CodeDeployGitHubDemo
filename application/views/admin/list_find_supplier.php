<script>
    $(function(){
        $('.btnDelete').on('click',function(){
            if(!confirm('Are you sure you want to delete this supplier?')){
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
                        <h2>Find Supplier List</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <?php 
                            if(!empty($supplier_list)){
                                $base_url = $this->config->base_url();
                                foreach ($supplier_list as $supplier){
                                    $phone = $supplier->telephone_code." ".$supplier->telephone_number;
                                    echo <<< EOD
                                        <tr>
                                            <td>{$supplier->company_name}</td>
                                            <td>{$supplier->email}</td>
                                            <td><img src="{$base_url}/uploads/company/{$supplier->company_logo}" width="60" height="60" alt="Company Logo"/></td>
                                            <td>{$phone}</td>
                                            <td>{$supplier->country_name}</td>
                                            <td>{$supplier->description}</td>
                                            <td><a href="{$base_url}admin/find-supplier/{$supplier->find_supplier_id}">Edit</a> | <a class="btnDelete" href="{$base_url}admin/find-supplier-delete/{$supplier->find_supplier_id}">Delete</a></td>
                                        </tr>
EOD;
                                }
                                
                            }else{
                            ?>
                                <tr>
                                    <td colspan="6" align="center">No Results</td>
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
