
<div class="container-fluid">
    <div class="container">

        <div class="row">
            <h2>Notifications</h2>
            <div class="col-md-12 ">


                <?php if (!empty($notification_list)) { ?>
                    <div class="list-group">

                        <?php
                        foreach ($notification_list as $key => $list) {
                            ?>
                            <a href="<?php echo base_url('dashboard/job')."/".$list->job_id;?>" class="list-group-item unread">
                                <h4 class="list-group-item-heading"><?php echo $list->description; ?></h4>
                                <label>Order ID: <?php echo $list->job_id; ?></label>
                                <p class="list-group-item-text text-muted">
                                    <?php echo date("F j, Y g:i a ", $list->created_time); ?>
                                </p>
                            </a>

                        <?php } ?>
                    </div>

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
                    <br/>
                    <div class="alert alert-info">
                        <strong>Info!</strong> You don't have any notification.
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>
