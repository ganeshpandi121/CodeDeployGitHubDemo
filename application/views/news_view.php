<?php if (!empty($news_data)) { ?>
    <script>
        var newscommentValidator = {
            newscommentValidation: function () {
                $('#comment').parent().removeClass("has-error has-danger");
                var error = "";

                if ($.trim($('#comment').val()) == "") {
                    error += "Please enter Comment<br/>";
                    $('#comment').parent().addClass("has-error has-danger");
                }

                if (error) {
                    Messages.error(error);
                    return false;
                } else {
                    return true;
                }
            }
        }
    </script>
    <div class="container-fluid">
        <div class="container">

            <div class="row">
                <section class="col-md-10 col-md-offset-1">
                    <div class="page-header">
                        <h1><?php echo $news_data->news_title; ?> </h1>
                        <div class="text-nowrap">
                            <label class="text-uppercase" style="color: #9eabb3">
                                <?php echo date("F j, Y", $news_data->created_time); ?>
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <img class="img-responsive center-block" width="70%" alt="<?php echo $news_data->news_title; ?>" src="<?php echo base_url() . 'uploads/news/' . $news_data->image_path; ?>">
                    </div><br/>
                    <div class="padding-10" >
                        <p class="text-left text-justify">
                            <?php echo $news_data->description; ?>
                        </p>
                    </div>
<?php 
                  if($this->session->flashdata('comment_message')){?>
                <div class="alert alert-success">      
                <?php echo $this->session->flashdata('comment_message')?>
                 </div>
                 <?php } ?>
                    <div class="padding-10" >
                        <h2>Comments</h2>
                        <p class="text-left text-justify"></p>
                            <div class="row">
                                <div class="col-md-12">                   
                                    <table width="100%" class="table table-responsive">
                                        <?php
                                        foreach ($news_comments as $nc) {
                                            $uname = ucfirst($nc->user_first_name . " " . $nc->user_last_name);
                                            $time = date('d M Y H:i', $nc->created_time);
                                            $image = (!$nc->logo_path) ? "styles/images/default.png" : 'uploads/profile/'.$nc->logo_path;
                                            print <<<EOD
                                            <tr>
                                                <td width="40"><img src="{$this->config->base_url()}{$image}" class="img_responsive" width="150" height="100"/></td>
                                                <td><p>{$uname}
                                                    <br/>Created Time: {$time}
                                                    <br/>{$nc->description}
                                                    </p>
                                                </td>

                                            </tr>
EOD;
                                        }
                                        ?>
                                    </table>
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
                            </div>
                    </div>
                 
                    <div class="padding-10" >
                        <div class="comment-head"><strong>Leave a Comment</strong></div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo form_open(base_url() . 'news-comment', array('id' => 'news_comment', 'method' => 'post', 'onsubmit' => 'return newscommentValidator.newscommentValidation();')); ?>
                                <?php echo form_hidden('news_id', $news_data->news_id); ?>
                                <div class="form-group">
                                    <?php echo form_textarea(array('id' => 'comment', 'name' => 'comment', 'rows' => '3', 'placeHolder' => 'Add Your Comment Here')); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_submit('submit', 'ADD', array('id' => 'submit', 'class' => 'btn btn-primary')); ?>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>

                </section>
            </div>

        </div>
    </div>
    <?php
}?>