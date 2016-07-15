<script>
    function timerCounter(job_id, sla) {
            $('.timer' + job_id).countdown(sla)
                    .on('update.countdown', function (event) {
                        var format = "";
                        if (event.offset.days > 0 || event.offset.weeks > 0) {
                           format = '<br/>';
                        }
                        format = format + '%H Hours: %M Minutes: %S Seconds';
                        if (event.offset.days > 0) {
                            format = '%-d day%!d ' + format;
                        }
                        if (event.offset.weeks > 0) {
                            format = '%-w week%!w ' + format;
                        }
                        $(this).html(event.strftime(format));
                    })
                    .on('finish.countdown', function (event) {
                        $(this).html('CLOSED')
                                .parent().addClass('disabled');

            });
    }
</script>
<?php if (!empty($this->session->flashdata('success_msg'))) { ?>
    <div class="alert alert-success text-center">
        <?php echo $this->session->flashdata('success_msg'); ?>
    </div>
<?php } ?>
<?php if (!empty($this->session->flashdata('error_msg'))) { ?>
    <div class="alert alert-danger text-center">
        <?php echo $this->session->flashdata('error_msg'); ?>
    </div>
<?php } ?>
<div class="container-fluid">
    <div class="container">
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#my-bids">My Bids</a></li>
            <li><a href="<?php echo base_url('dashboard/my-projects')?>">My Projects</a></li>
        </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active">
        <div class="row">
            <div class="col-md-6 "> <h2><?php echo ($page_title != '') ? $page_title : '';?></h2></div>
            <div class="col-md-6 ">
                <br/>
                <div class="form-inline pull-right ">
                    <?php
                    echo form_open(base_url() . 'dashboard/my-bids', array('id' => 'search_quote_form', 'method' => 'get'));
                    $search_term = !empty($search_term) ? $search_term : '';
                    echo form_input('search_term', $search_term, array('id' => 'search_term', 'placeHolder' => 'Search Job Here','style'=>'width:350px;'));?>
                    <?php echo form_submit('search', 'Search', array('class' => 'btn btn-primary form-control', 'type' => 'submit')); ?>
                      
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="row" id="my-bids">
            <div class="col-md-12 ">
                <?php if($this->session->userdata('user_type_id') == 2 && 
                             $this->session->userdata('is_transformed') == 0){?>
                    <a class="btn btn-warning btnView" href="<?php echo base_url('dashboard/become_seller');?>">Become a Seller </a>
                <?php }else{?>
                <?php if (!empty($user_bid_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>Order ID</th>
                                <th>Project Name</th>
                                <th>Company Name</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Rank</th>
                                <th>Created Date</th>
                                <th>Project Lead Time</th>
                                <th>Auction Time</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($user_bid_list as $k => $item) { ?>
                                <tr>
                                    <td><?php echo "#" . $item->job_id; ?></td>
                                    <td><?php echo $item->job_name; ?></td>
                                    <td><?php if(!empty($item->rank)) { echo $item->company_name; }?></td>
                                    <td><?php echo $item->product_quantity; ?></td>
                                    <td class="text-info"><?php echo $item->job_status_name; ?></td>
                                    <td>
                                        <h4 class="badge" style="font-size: 15px">
                                            <?php echo $item->rank;       ?>
                                        </h4>
                                    </td>
                                    <td><?php echo date("F j, Y", $item->created_date); ?></td>
                                    <td>
                                        <?php $time_class = (time() < $item->product_lead_time) ? "text-success" : "text-danger" ?>
                                        <b class="<?php echo $time_class; ?>"> 
                                            <script>
                                                document.write(moment('<?php echo date("Y-m-d H:i", $item->product_lead_time); ?>').endOf('minutes').fromNow())
                                            </script>
                                        </b>
                                        <br/>
                                        <?php echo date("F j, Y", $item->product_lead_time); ?>
                                    </td>
                                    <td>
                                        <?php $time_class = (time() < $item->sla_milestone) ? "text-success" : "text-danger" ?>
                                        <b><span class="timer<?php echo $item->job_id;?> <?php echo $time_class;?>">0 : 00 : 00 : 00</span></b>
                                        <script>
                                           timerCounter("<?php echo $item->job_id;?>","<?php echo date('Y/m/d H:i:s', $item->sla_milestone); ?>");
                                        </script>
                                        <br/>
                                        <?php echo date("F j, Y", $item->sla_milestone); ?>
                                    </td>

                                    <td><a class="btn btn-blue" href="<?php echo base_url() . "dashboard/job/" . $item->job_id; ?>">View </a></td>
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
                        <br/>
                        <div class="alert alert-info">
                            <strong>Info!</strong> You don't have any Quote Request.
                        </div>

                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
     </div><br/>
   </div>
  </div>
</div>