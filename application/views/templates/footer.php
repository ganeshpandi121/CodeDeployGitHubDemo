<div  class="container-fluid  footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h3>Quick Links</h3>
                <ul class="footer_menu">
                    <li><a href="<?php echo $this->config->base_url(); ?>aboutus">About us</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>faq">FAQ</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>terms">Terms and Conditions</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>privacy_policy">Privacy policy</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>team">Team</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>howitworks">How it works</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>fees">Fees & Charges</a></li>
                    <li><a href="<?php echo $this->config->base_url(); ?>contact">Contact us</a></li>
                </ul>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-12"> <h3>Contact Us</h3>
                <table class="table borderless">
                    <tbody><tr>
                            <th>Mail:</th>
                            <td><a href="mailto:info@smartcardmarket.com" target="_top">info@smartcardmarket.com</a>
                            </td>
                        </tr>
                       <!-- <tr>
                            <th>Phone :
                            </th>
                            <td>
                                <p>
                                    <img alt="" src="<?php echo $this->config->base_url(); ?>styles/images/Malaysia-Flag-icon.png">                                        +60 133 623 983</p>
                                <p>
                                    <img alt="" src="<?php echo $this->config->base_url(); ?>styles/images/United-States-Flag-icon.png">                                       +1 917 720 3274</p>
                                <p>
                                    <img alt="" src="<?php echo $this->config->base_url(); ?>styles/images/South-Africa-Flag-icon.png">                                       +27 110 835 056</p>
                                <p>
                                   <img alt="" src="<?php echo $this->config->base_url(); ?>styles/images/United-Kingdom-Flag-icon.png">                                         +44 20 7193 3496</p>
                            </td>
                        </tr
                        <tr>
                            <th>Address:
                            </th>
                            <td>Unit 8, Level 15, Menara One Mont Kiara, No. 1<br>
                                Jalan Kiara, Mont Kiara, Kuala Lumpur, 50480, MALAYSIA<p></p>
                            </td>
                        </tr>-->
                    </tbody></table></div>
            <div class="col-sm-4"> <h3>News Letter</h3>                
                <form id="newsletter" action="#" class="form-inline">
                    <div class="form-group">
                        <input type="email" placeholder="Email" class="form-control" id="email">
                    </div>
                    <button type="button" class="btn btn-default btnNewsletter">Submit</button>
                    <div id="view_msg" class="text-info"></div>
                </form>

            </div>
        </div>
    </div>
</div>
<div  class="container-fluid copyright-index padding-25">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                &copy; Copyright 2016 by <a href="#">SmartCardMarket.com</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.btnNewsletter').on('click', function () {
            var email = $('#email').val();
            if (email != "") {
                $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('user') . '/'; ?>newsletter",
                    data: {emailid: email},
                    dataType: 'html'
                })
                        .done(function (msg) {
                            //alert( "Data :" + msg );
                            $('#view_msg').html(msg);
                        });
            } else {
                $('#view_msg').html('Please enter email');
            }

        });
    });
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-69634861-8', 'auto');
    ga('send', 'pageview');

</script>

<?php
if (ENVIRONMENT == 'production') {
    if (!$this->session->userdata('logged_in')) {
        ?>

        <script type="text/javascript">
            var $zoho = $zoho || {salesiq: {values: {}, ready: function () {}}};
            var d = document;
            s = d.createElement("script");s.type = "text/javascript";
            s.defer = true;
            s.src = "https://salesiq.zoho.com/cardcore/float.ls?embedname=cardcore";
            t = d.getElementsByTagName("script")[0];
            t.parentNode.insertBefore(s, t);
        </script>
        <?php
    }
}
?>

