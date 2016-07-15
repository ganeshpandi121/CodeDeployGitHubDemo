<!DOCTYPE html>
<!--
Email template
-->
<html>
    <head>
        <title><?php echo $subject; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: light;font-size: 14px;">
        <table align="center" width="70%" style=" background-color: #fff;border-collapse: separate; border-spacing: 0;text-align: justify; border: 1px solid #cccccc; border-radius: 3px;">
            <thead>
                <tr >
                    <td align="center" style=" border-top: 5px solid #f3f9fd;border-bottom: 5px solid #f3f9fd;">
                        <img src="<?php echo base_url() ?>styles/images/logo.png" style="padding: 10px; width: 25%">
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border-top: 10px solid #47abe6; margin-top: 5px;">
                        <div style="  padding: 0 15px;margin: 40px 0;">
                            <p style=" color: #169fff;text-transform: capitalize;">
                                <?php
                                if (!empty($greeting)) {
                                    echo $greeting;
                                } else {
                                    ?>
                                    Hi <?php
                                    echo $user_name . ',';
                                }
                                ?>
                            </p>

                            <p>
                                <?php echo $message; ?>
                            </p>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="background: #434343;color: #fff;padding: 0 15px;margin: 40px 0;" align="center">
                        <table>
                            <tr>
                                <td width="35%">
                                </td>
                                <td width="30%">
                            <center>
                                <table>
                                    <tr>
                                        <td>
                                            <a href="https://www.facebook.com/SmartCard-Market-1700413626839813/"><img src="<?php echo base_url() ?>styles/images/mail-facebook-icon.png"> </a> 
                                        </td>
                                        <td>
                                            <a href="https://www.linkedin.com/company/smartcard-market"><img src="<?php echo base_url() ?>styles/images/mail-linkedin-icon.png">  </a></td>
                                        <td>
                                            <a href="https://twitter.com/SmartCard_Marke"><img src="<?php echo base_url() ?>styles/images/mail-twitter-icon.png">  </a>   
                                        </td>
                                    </tr>
                                </table>
                            </center>

                    </td>
                    <td width="35%">
                    </td>
                </tr>
        </table>

        <p class="footer-content" >
            You have received this email because your are registered member on smartcardmarket.com. 
        </p>
        <p style="text-align: center;color: #fff;">
            &copy; 2016 <a style="color: #169fff;" href="www.smartcardmarket.com">www.smartcardmarket.com</a>. All rights reserved.
        </p>
    </td>
</tr>
</tbody>

</table>

</body>
</html>

