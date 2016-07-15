<div class="container">
    <div class="row">
        <div class="col-md-4">
            <a href="<?php echo $this->config->base_url(); ?>"><?php echo img('styles/images/logo.png', '', array('alt' => 'Logo', 'height' => '80')); ?>          
            </a> 
        </div> 
        <div class="col-md-8">
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo $this->config->base_url(); ?>">Home</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>aboutus"  class="dropdown-toggle" data-toggle="dropdown">About us
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->config->base_url(); ?>team">Team</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $this->config->base_url(); ?>faq">FAQ</a></li>
                 <!--   <li><a href="<?php echo $this->config->base_url(); ?>terms">Terms and Conditions</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>privacy_policy">Privacy policy</a></li> -->

                    <li><a href="<?php echo $this->config->base_url(); ?>howitworks">How it works</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>fees">Fees & Charges</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>contact">Contact us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid inner-banner">

</div>
