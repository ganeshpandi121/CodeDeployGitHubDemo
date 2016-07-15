<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center"><?php echo ($page_title != '') ? $page_title : ''; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="form-inline text-right">
                <div class="col-md-12">
                    <?php
                    echo form_open(base_url() . 'news/', array('id' => 'search_news_form', 'method' => 'get'));
                    $search_news = !empty($search_news) ? $search_news : '';
                    echo form_input('search_news', $search_news, array('id' => 'search_term', 'placeHolder' => 'Search News Here'));
                    ?>
                    <?php echo form_submit('search', 'Search News', array('class' => 'btn btn-primary form-control', 'type' => 'submit')); ?>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <?php if (!empty($news_list)) { ?>
                    <?php foreach ($news_list as $list) { ?>
                        <section>
                            <div class="page-header">
                                <h2><?php echo $list->news_title; ?></h2>
                            </div>
                            <p class="text-muted text-left text-uppercase">
                                <?php echo date("F j, Y", $list->created_time); ?>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="img-responsive center-block" width="70%" alt="<?php echo $list->news_title; ?>" src="<?php echo base_url() . 'uploads/news/' . $list->image_path; ?>">
                                </div>
                                <div class="col-md-6">
                                    <div class="padding-10">
                                        <p class="text-justify"><?php echo substr($list->description, 0, 500); ?></p>
                                    </div>
                                </div>
                            </div>
                            <span class="pull-right">
                                <?php if ($this->session->userdata('logged_in') == 1) { ?>

                                    <a class="text-primary" href="<?php echo base_url() . "news_view/" . $list->news_id; ?>">Read More </a>


                                <?php } else {
                                    $url = base_url();
                                    ?>
                                    <a href="javascript:void(0);" data-toggle="popover"
                                       title="Please Login" 
                                       data-html="true" 
                                       data-placement="bottom"
                                       data-content="To login Click <a href='<?php echo $url; ?>'>here</a>.">
                                        Read More
                                    </a>
        <?php } ?> 
                            </span><br>
                        </section> 
                        <hr style="margin-left: 10px; margin-right: 20px">

    <?php } ?>

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
                        <strong>Info!</strong> No news found.
                    </div>

<?php } ?>
            </div>

            <!-- For categories
                       <div class="col-md-4 padding-10">
                       <div class="row" style="display: none">
                           <div class="col-md-12">
                               <h2>Categories</h2>
                               <ul class="list-group">
                                   <li class="list-group-item"><span class="badge">12</span> Category 1</li>
                                   <li class="list-group-item"><span class="badge">number of posts</span> Category 2</li>
                                   <li class="list-group-item"><span class="badge">3</span> Category 3</li>
                               </ul>
                           </div>
                       </div>
                       <div class="row" style="display: none">
                           <div class="col-md-12">
                               <h2>Popular Tags</h2>
                               <a class="text-muted" href="#">Popular Tag 1</a>
                               <a class="text-muted" href="#">Popular Tag 2</a>
                               <a class="text-muted" href="#">Popular Tag 3</a>
                               <a class="text-muted" href="#">Popular Tag 4</a>
                               <a class="text-muted" href="#">Popular Tag 5</a>
                               <a class="text-muted" href="#">Popular Tag 6</a>
                               <a class="text-muted" href="#">Popular Tag 7</a>
                               <a class="text-muted" href="#">Popular Tag 8</a>
                               <a class="text-muted" href="#">Popular Tag 9</a>
                        </div>
                       </div>
                       </div>
                   </div>-->
        </div>
    </div>
</div>
