
<script>

    $(function () {
        $('.btnApprove').on('click', function () {
            if (!confirm('Are you sure you want to Approve this news Comment?')) {
                return false;
            }
        });
    });
    $(function () {
        $('.btnReject').on('click', function () {
            if (!confirm('Are you sure you want to Reject this news Comment?')) {
                return false;
            }
        });
    });

    $(function () {
        $('.btnDelete').on('click', function () {
            if (!confirm('Are you sure you want to Delete this news Comment?')) {
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
                        <h2>News Comments</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('message')) { ?>
                            <div class="alert alert-success">      
                                <?php echo $this->session->flashdata('message') ?>
                            </div>
                        <?php } ?>
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th>User Name </th>
                                <th>User Email </th>
                                <th width="150">News Title</th>
                                <th width="450">Comment</th>
                                <th width="150">Actions</th>
                            </tr>
                            <?php 
                            if(!empty($news_comment_list)){
                                $base_url = $this->config->base_url();
                                foreach ($news_comment_list as $news_comment){ ?>
                                     <tr>
                                           <td><?php echo $news_comment->name; ?></td>
                                           <td><?php echo $news_comment->email; ?></td>
                                            <td><?php echo $news_comment->news_title; ?></td>
                                            <td><?php echo $news_comment->description; ?></td>

                                            <td>
                                            <?php if($news_comment->is_moderated == 1){?>
                                            <a class="btnReject" href="<?php echo base_url()."admin/reject_news_comment/".$news_comment->news_comment_id; ?>">Reject</a>
                                            <?php }else{?>
                                            	<a class="btnApprove" href="<?php echo base_url()."admin/approve_news_comment/".$news_comment->news_comment_id; ?>">Approve</a>
                                            <?php }?>
                                             |<a class="btnDelete" href="<?php echo base_url()."admin/delete_news_comment/".$news_comment->news_comment_id; ?>">Delete</a></td>
                                        </tr>

                               <?php }
                                
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