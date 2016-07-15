<div class="container-fluid">
    <div class="container">
        
        <div class="row">
            <div class="col-md-12 ">
                <h2>Find Supplier Requests</h2>
                <?php if (!empty($supplier_request_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>Request From</th>
                                <th>Request To</th>
                                <th>Type of Request</th>
                                <th>Supplier Type</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($supplier_request_list as $key => $list) { ?>
                                <tr>
                                    <td><?php echo $list->request_from_firstname.' '.$list->request_from_lastname; ?></td>
                                    <td class="text-info">
                                        <?php 
                                        if(!empty($list->request_to_firstname)){
                                            $request_to = $list->request_to_firstname.' '.$list->request_to_lastname;
                                        }else if(!empty($list->company_name)){
                                            $request_to = $list->company_name;
                                        }
                                        echo $request_to; ?>
                                    </td>
                                    <td><?php echo $list->request_type; ?></td>
                                    <td><?php echo $list->supplier_type; ?></td>
                                    <td><?php echo $list->comments; ?></td>
                                </tr>
                        <?php } ?>
                        </tbody>
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

                    <?php } else { ?>
                        <div class="alert alert-info">
                            <strong>Info!</strong> No Request Found.
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
