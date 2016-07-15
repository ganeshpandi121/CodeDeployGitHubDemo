<?php
if (!isset($_COOKIE['user']) || empty($_COOKIE['user'])) {
    $number_of_days = 7;
    $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
    setcookie("user", "old", $date_of_expiry);
}
?>
<div class="container-fluid banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="banner-heading text-center"><q>SMARTCardMarket creates a 

                                <br><span>win-win </span><br>

                                situation for buyers and <br>suppliers alike.</q> </h1>

                        <div class="text-center padding-25 banner-btn-group">
                            <a href="<?php echo $this->config->base_url(); ?>post-a-project"><button class="btn btn-blue banner-btn">Buy Product</button></a>
                            <span class="or-breaker">or</span>
                            <a  onclick="$('#user_type_id_3').prop('checked',true);loginController.signUpFormController()"><button class="btn btn-blue banner-btn">Sell Product</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container padding-25">
    <div class="row">
        <div class="col-md-12 text-center underline underline-white padding-25"><h2 class="index-heading">How It Works</h2></div>
    </div>
    <div class="row">
        <div class="col-md-6 how-it-works"><h3> Purchasing a product or looking to Manufacture?</h3>
            <p class="text-justify">
                You will find them on SmartCardMarket.com! Gain access to leading manufacturers and product suppliers across the globe. Who can assist you with your requirements within moments of posting a project!
            </p>
            <p class="text-center">
                <a href="<?php echo $this->config->base_url(); ?>post-a-project"><button class="btn btn-blue banner-btn">Post a Project</button></a></p>
        </div>
        <?php
//Youtube looping check with cookie
        if (!isset($_COOKIE['user'])) {
            $autoplay = 'autoplay=1&loop=1';
        } else {
            $autoplay = 'autoplay=0&loop=0';
        }
        ?>
        <div class="col-md-6 col-sm-12 col-xs-12 video-container center-block"><iframe class="center-block" width="560" height="315" src="https://www.youtube.com/embed/9Ze5bSdQawo?<?php echo $autoplay; ?>" frameborder="0" ></iframe></div>

    </div>
</div>
<br/><br/>
<div class="container-fluid gray padding-25">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center underline underline-gray padding-25"><h2 class="index-heading">Products</h2></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="hovereffect">
                    <?php echo img('styles/images/Products1.png', '', array('alt' => 'Products1', 'class' => 'img-border img-responsive center-block')); ?>
                    <div class="overlay">
                        <h2>Find Supplier Now</h2>
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="info" data-toggle="popover"

                               data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                           <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="hovereffect">
                    <?php echo img('styles/images/Products2.png', '', array('alt' => 'Products2', 'class' => 'img-border img-responsive center-block')); ?>
                    <div class="overlay">
                        <h2>Find Supplier Now</h2>
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="info" data-toggle="popover"

                               data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a  href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                           <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="hovereffect">
                    <?php echo img('styles/images/Products3.png', '', array('alt' => 'Products3', 'class' => 'img-border img-responsive center-block')); ?>
                    <div class="overlay">
                        <h2>Find Supplier Now</h2>
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="info" data-toggle="popover"

                               data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                           <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="hovereffect">
                    <?php echo img('styles/images/Products4.png', '', array('alt' => 'Products4', 'class' => 'img-border img-responsive center-block')); ?>
                    <div class="overlay">
                        <h2>Find Supplier Now</h2>
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="info" data-toggle="popover"

                               data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                           <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="hovereffect">
                        <?php echo img('styles/images/Products5.png', '', array('alt' => 'Products5', 'class' => 'img-border img-responsive center-block')); ?>
                        <div class="overlay">
                            <h2>Find Supplier Now</h2>
                            <?php if ($this->session->userdata('logged_in')) { ?>
                                <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" class="info" data-toggle="popover"

                                   data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                               <?php } ?>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="hovereffect">
                        <?php echo img('styles/images/Products6.png', '', array('alt' => 'Products6', 'class' => 'img-border img-responsive center-block')); ?>
                        <div class="overlay">
                            <h2>Find Supplier Now</h2>
                            <?php if ($this->session->userdata('logged_in')) { ?>
                                <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" class="info" data-toggle="popover"

                                   data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                               <?php } ?>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="hovereffect">
                        <?php echo img('styles/images/Products7.png', '', array('alt' => 'Products7', 'class' => 'img-border img-responsive center-block')); ?>
                        <div class="overlay">
                            <h2>Find Supplier Now</h2>
                            <?php if ($this->session->userdata('logged_in')) { ?>
                                <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" class="info" data-toggle="popover"

                                   data-html="true"  data-content="Please  <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                               <?php } ?>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="hovereffect">
                        <?php echo img('styles/images/Products8.png', '', array('alt' => 'Products8', 'class' => 'img-border img-responsive center-block')); ?>
                        <div class="overlay">
                            <h2>Find Supplier Now</h2>
                            <?php if ($this->session->userdata('logged_in')) { ?>
                                <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">Click Here</a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" class="info" data-toggle="popover"

                                   data-html="true"  data-content="Please <a href='#' onclick='loginController.loginFormController(&quot;find_supplier_now&quot;)'>Login</a> Or <a href='#' onclick='loginController.signUpFormController(&quot;find_supplier_now&quot;)'>Sign Up</a>" data-placement="bottom" >Click Here</a>
                               <?php } ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid gray padding-25"></div>

