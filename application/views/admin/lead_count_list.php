<div class="container-fluid">
    <div class="container">

        <div class="row">
            <div class="col-md-12 ">
                <h2>Find Lead Count</h2>
                <?php if (!empty($lead_count_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>Supplier Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Lead Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lead_count_list as $key => $list) { ?>
                                <tr>
                                    <td><?php echo $list->sd_id; ?></td>
                                    <td><?php echo $list->name; ?></td>
                                    <td><?php echo $list->email; ?></td>
                                    <td><?php echo $list->company_name; ?></td>
                                    <td><?php echo $list->counts; ?></td>
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
