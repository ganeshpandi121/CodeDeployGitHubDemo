<!--this form for Forgot password-->

<div class="row">
  
            <div class="col-md-4 col-md-offset-4">
                  <h2>Forgot Password</h2>
               
                <div class="form-group"> 
                    <?php echo form_input('email', '', array('class' => 'form-control', 'id' => 'forgot_password_email', 'max-length' => '100', 'placeHolder' => 'Enter Email')); ?>
                </div> 
                 <?php echo form_submit('forgot_password_button', 'Reset Password', array('class' => 'btn btn-blue'));?>
            </div> 
</div>

<!--Supplier Registration Page form -->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Supplier Registration</h2>
                  
                    <div class="form-group">  
                    <?php echo form_input('user_first_name', '', array('class' => 'form-control', 'id' => 'user_first_name', 'max-length' => '100', 'placeHolder' => 'First Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('user_last_name', '', array('class' => 'form-control', 'id' => 'user_last_name', 'max-length' => '100', 'placeHolder' => 'Last Name')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('contact_no', '', array('class' => 'form-control', 'max-length' => '50', 'id' => 'supplier_contact_no', 'placeHolder' => 'Enter Phone Number')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('email', '', array('class' => 'form-control', 'id' => 'sign_in_email', 'max-length' => '100', 'placeHolder' => 'Enter Email')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_password('password', '', array('class' => 'form-control', 'id' => 'sign_in_password', 'max-length' => '100', 'placeHolder' => 'Enter Password')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_password('confirm_password', '', array('class' => 'form-control', 'id' => 'sign_in_confirm_password', 'max-length' => '100', 'placeHolder' => 'Confirm Password')); ?>
                </div>
                  <div class="form-group">  
                    <?php echo form_input('company_name', '', array('class' => 'form-control', 'id' => 'supplier_company_name', 'max-length' => '250', 'placeHolder' => 'Enter Company Name')); ?>
                </div>
                    <div class="form-group">  
                    <?php echo form_input('trading_name', '', array('class' => 'form-control', 'id' => 'supplier_trading_name', 'max-length' => '250', 'placeHolder' => 'Enter Trading Name')); ?>
                </div>
                      <div class="form-group">  
                    <?php echo form_input('website_urls', '', array('class' => 'form-control', 'id' => 'supplier_website_urls', 'max-length' => '250', 'placeHolder' => 'Enter Website(s)')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('brands', '', array('class' => 'form-control', 'id' => 'supplier_brands', 'max-length' => '250', 'placeHolder' => 'Brands')); ?>
                </div>
                  
               
                 <?php echo form_submit('submit_button', 'Register', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
</div>


<!--Profile Settings-->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Profile Settings</h2>
                  
                    <div class="form-group">  
                    <?php echo form_input('user_first_name', '', array('class' => 'form-control', 'id' => 'user_first_name', 'max-length' => '100', 'placeHolder' => 'First Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('user_last_name', '', array('class' => 'form-control', 'id' => 'user_last_name', 'max-length' => '100', 'placeHolder' => 'Last Name')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('contact_no', '', array('class' => 'form-control', 'max-length' => '50', 'id' => 'supplier_contact_no', 'placeHolder' => 'Enter Phone Number')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('email', '', array('class' => 'form-control', 'id' => 'sign_in_email', 'max-length' => '100', 'placeHolder' => 'Enter Email')); ?>
                </div>
                  <div class="form-group">  
                    <?php echo form_input('company_name', '', array('class' => 'form-control', 'id' => 'supplier_company_name', 'max-length' => '250', 'placeHolder' => 'Enter Company Name')); ?>
                </div>
                    <div class="form-group">  
                    <?php echo form_input('trading_name', '', array('class' => 'form-control', 'id' => 'supplier_trading_name', 'max-length' => '250', 'placeHolder' => 'Enter Trading Name')); ?>
                </div>
                      <div class="form-group">  
                    <?php echo form_input('website_urls', '', array('class' => 'form-control', 'id' => 'supplier_website_urls', 'max-length' => '250', 'placeHolder' => 'Enter Website(s)')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('brands', '', array('class' => 'form-control', 'id' => 'supplier_brands', 'max-length' => '250', 'placeHolder' => 'Brands')); ?>
                </div>
                  
               
                 <?php echo form_submit('submit_button', 'Save', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
</div>



<!--Change Password-->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Change Password</h2>
                  
                    <div class="form-group">  
                    <?php echo form_password('password', '', array('class' => 'form-control', 'id' => 'old_password', 'max-length' => '100', 'placeHolder' => 'Enter Password')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_password('new_password', '', array('class' => 'form-control', 'id' => 'new_password', 'max-length' => '100', 'placeHolder' => 'Enter Password')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_password('confirm_password', '', array('class' => 'form-control', 'id' => 'confirm_new_password', 'max-length' => '100', 'placeHolder' => 'Confirm Password')); ?>
                </div>
                  
               
                 <?php echo form_submit('submit_button', 'Save', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
</div>

<!--Address change Page form -->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Address Update</h2>
                  
                    <div class="form-group">  
                    <?php echo form_input('address_name', '', array('class' => 'form-control', 'id' => 'address_name', 'max-length' => '250', 'placeHolder' => 'Address Name')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('street_address', '', array('class' => 'form-control', 'id' => 'street_address', 'placeHolder' => 'Street Address')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('state', '', array('class' => 'form-control', 'max-length' => '100', 'id' => 'state', 'placeHolder' => 'Enter State')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('city', '', array('class' => 'form-control', 'id' => 'city',  'max-length' => '100', 'placeHolder' => 'Enter City')); ?>
                </div>
               
                  <div class="form-group">  
                    <?php echo form_input('post_code', '', array('class' => 'form-control', 'id' => 'post_code', 'max-length' => '100', 'placeHolder' => 'Enter Pincode')); ?>
                </div>
                    <div class="form-group">  
                    <?php echo form_input('country_id', '', array('class' => 'form-control', 'id' => 'country_id', 'max-length' => '100', 'placeHolder' => 'Enter Country')); ?>
                </div>
                      <div class="form-group">  
                    <?php echo form_input('telephone_no', '', array('class' => 'form-control', 'id' => 'telephone_no', 'max-length' => '100', 'placeHolder' => 'Enter Phone Number')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('fax_no', '', array('class' => 'form-control', 'id' => 'fax_no', 'max-length' => '100', 'placeHolder' => 'Enter Fax Number')); ?>
                </div>
                  
               <?php echo form_submit('submit_button', 'Save', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
</div>



<!--Supplier Category form -->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Supplier Category form </h2>
                  
                    <div class="form-group"> 
                        
                    <?php 
                    
                        $category_array = array(
                  'Retail Cards'  => 'Retail Cards',
                  'Secure Cards'    => 'Secure Cards',
                  'Telecom'   => 'Telecom',
                  'RFID' => 'RFID',
                  'Card Readers'   => 'Card Readers',
                  'Peripherals' => 'Peripherals',
                  'Payment Services' => 'Payment Services',
                  'Programs'   => 'Programs',
                  'Materials' => 'Materials'
                );
                   echo form_label('Category: ','category', array('style' => 'padding: 10px'));
                   echo form_dropdown('categories', $category_array, 'Retail Cards'); ?>
                </div>
                  
                    <div class="form-group"> 
                        
                    <?php 
                    //Sub category for retail 
                       $sub_category_array = array(
                        'Gift'  => 'Gift',
                        'Loyalty'    => 'Loyalty',
                        'Membership'   => 'Membership',
                        'Promotional' => 'Promotional',
                        'Oversize'   => 'Oversize',
                        'Snap-Apart ' => 'Snap-Apart '
                      );
                       
                       echo form_label('Sub category (retail) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                echo form_checkbox($data);
                echo $value;
                       }
                  ?>
                </div>
                  
                   <div class="form-group"> 

                    <?php 
                    //Sub category for secure cards 
                       $sub_category_array = array(
                        'Visa'  => 'Visa',
                        'MasterCard'    => 'MasterCard',
                        'Amex'   => 'Amex',
                        'Discovery' => 'Discovery',
                        'EMV'   => 'EMV',
                        'Driver Licence' => 'Driver Licence',
                           'Medicare'   => 'Medicare',
                        'National ID' => 'National ID',
                      );
                       
                       echo form_label('Sub category (secure) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
                  
                   <div class="form-group"> 
                     <?php 
                    //Sub category for telecom cards 
                       $sub_category_array = array(
                        'SIM Cards'  => 'SIM Cards',
                        'Scratch Cards '    => 'Scratch Cards ',
                      );
                       
                       echo form_label('Sub category (telecom) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
                  
                  <div class="form-group"> 

                    <?php 
                    //Sub category for card printers 
                       $sub_category_array = array(
                        'Datacard'  => 'Datacard',
                        'Evolis'    => 'Evolis',
                        'HID'   => 'HID',
                        'Magicard' => 'Magicard',
                        'Matica'   => 'Matica',
                        'Nisca' => 'Nisca',
                           'Polaroid'   => 'Polaroid',
                        'Zebra' => 'Zebra',
                           'IDP' => 'IDP',
                      );
                       
                       echo form_label('Sub category (card printers) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
                  
                   <div class="form-group"> 
                  <?php 
                    //Sub category for card readers 
                       $sub_category_array = array(
                        'Swipe'  => 'Swipe',
                        'Contact'    => 'Contact',
                        'Contactless'   => 'Contactless',
                        'Fixed' => 'Fixed',
                        'Wireless'   => 'Wireless',
                        
                      );
                       
                       echo form_label('Sub category (card readers) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
          
 
   <div class="form-group"> 
                  <?php 
                    //Sub category for Peripherals 
                       $sub_category_array = array(
                        'Lanyards'  => 'Lanyards',
                        'Ribbons'    => 'Ribbons',
                        'Cleaning Cards'   => 'Cleaning Cards',
                        ' Card holders' => ' Card holders',
                        'Retractable Clips'   => 'Retractable Clips',
                        
                      );
                       
                       echo form_label('Sub category (Peripherals) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>


                     <div class="form-group"> 
                  <?php 
                    //Sub category for Payment Service 
                       $sub_category_array = array(
                        'Merchant services'  => 'Merchant services',
                        ' banking services'    => ' banking services',
                        'stored value (open loop) '   => 'stored value (open loop) ',
                        
                      );
                       
                       echo form_label('Sub category (Payment Service) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
  
                     <div class="form-group"> 
                  <?php 
                    //Sub category for Programs
                       $sub_category_array = array(
                        'Loyalty'  => 'Loyalty',
                        'Gift'    => 'Gift',
                        'membership'   => 'membership',
                        ' stored value (closed Loop)   '    => ' stored value (closed Loop)   ',
                        
                      );
                       
                       echo form_label('Sub category (Programs) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>

                    <div class="form-group"> 
                  <?php 
                    //Sub category for Materials
                       $sub_category_array = array(
                        'Raw PVC'  => 'Raw PVC',
                        ' RFID inlays'    => ' RFID inlays',
                        ' Contact modules'   => ' Contact modules',
                        ' dual interface '    => 'dual interface',
                        
                      );
                       
                       echo form_label('Sub category (Materials) :','sub-category', array('style' => 'padding: 10px'));
                      
                        foreach ($sub_category_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data); echo $value;
                       }
                  ?>
                </div>
                  <p> <b>Please select the regions, which you would like to receive leads from?</b></p>
                  
                  <div class="form-group"> 
                        
                    <?php 
                    //region array
                       $region_array = array(
                        'Asia'  => 'Asia Pacific (excludes China, Australia & New Zealand)',
                        'North America'    => 'North America',
                        'Central America'   => 'Central America',
                        'South America' => 'South America',
                        'Middle East'   => 'Middle East',
                        'United Kingdom ' => 'United Kingdom ',
                             'Scandinavia'   => 'Scandinavia (Sweden, Denmark, Norway, Finland)',
                        'European Union' => 'European Union',
                             'Oversize'   => 'Oversize',
                        'Africat ' => 'Africa',
                             'Indian Subcontinent'   => 'Indian Subcontinent',
                        'Eastern Europe' => 'Eastern Europe'
                      );
                        sort($region_array);
                       foreach ($region_array as $array => $value)
                        {
                           $data = array(
                         'name'        => $array,
                         'id'          => "sub-category",
                         'value'       => $value,
                         'style'       => 'margin: 5px;',
                        );
                     echo form_checkbox($data);  echo $value;
                       }
                  ?>
                </div>
                  
               <?php echo form_submit('submit_button', 'Save', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
 ̰
</div>


<!--Supplier Quote submit form -->
<div class="row">
             <div class="col-md-4 col-md-offset-4">
                  <h2>Supplier Quote submit form</h2>
                  
                    <div class="form-group">  
                    <?php echo form_input('unit_volume', '', array('class' => 'form-control', 'id' => 'unit_volume', 'max-length' => '250', 'placeHolder' => 'Unit Volume:')); ?>
                </div>
                <div class="form-group">  
                    <?php echo form_input('price_per_unit', '', array('class' => 'form-control', 'id' => 'price_per_unit', 'placeHolder' => 'Price Per Unit:')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('total_order', '', array('class' => 'form-control', 'max-length' => '100', 'id' => 'total_order', 'placeHolder' => 'Total Order (ex Tax):')); ?>
                </div>
                <div class="form-group">  
                 <?php
                 echo form_label('Currency: ','currency_id', array('style' => 'padding: 10px'));
                   echo form_dropdown('currency_id', array('$' => '$', '#' => '#'), 'Currency Id'); ?>
             
                </div>
               
                  <div class="form-group">  
                    <?php echo form_input('payment_term', '', array('class' => 'form-control', 'id' => 'payment_term', 'max-length' => '100', 'placeHolder' => 'payment_term')); ?>
                </div>
                    <div class="form-group">  
                    <?php echo form_input('incoterms_id', '', array('class' => 'form-control', 'id' => 'incoterms_id', 'max-length' => '250', 'placeHolder' => 'incoterms_id')); ?>
                </div>
                      <div class="form-group">  
                    <?php echo form_input('lead_time', '', array('class' => 'form-control', 'id' => 'lead_time', 'max-length' => '100', 'placeHolder' => 'lead_time')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('pre_approved_sample', '', array('class' => 'form-control', 'id' => 'pre_approved_sample', 'max-length' => '250', 'placeHolder' => 'pre_approved_sample')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('sample_lead_time', '', array('class' => 'form-control', 'id' => 'sample_lead_time', 'max-length' => '100', 'placeHolder' => 'sample_lead_time')); ?>
                </div>
                   <div class="form-group">  
                    <?php echo form_input('additional_information', '', array('class' => 'form-control', 'id' => 'additional_information', 'max-length' => '100', 'placeHolder' => 'additional_information')); ?>
                </div>
                  
               <?php echo form_submit('submit_button', 'Submit Quote', array('class' => 'btn btn-blue', 'type' => 'submit'));?>
            </div> 
</div>



<!-- Contact form -->
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Contact Form</h2>


        <div class="form-group">  
        <?php
        echo form_label('Name ', 'name', array('style' => 'padding: 10px'));
        echo form_input('name', '', array('id' => 'name', 'max-length' => '100', 'placeHolder' => 'Enter Name'));
        ?>
        </div>
        <div class="form-group"> 
            <?php echo form_label("Email", "contact_email"); ?>
            <?php echo form_email('email_id', '', array('id' => 'email_id', 'placeHolder' => 'Enter Email')); ?>
        </div> 
        <div class="form-group"> 
            <?php echo form_label("Subject", "subject"); ?>
            <?php echo form_input('subject', '', array('id' => 'subject', 'max-length' => '100', 'placeHolder' => 'Enter Subject'));?>
        </div> 
        <div class="form-group">  
            <?php
            echo form_label('Message ', 'message');
            echo form_textarea(array('class' => 'form-control', 'id' => 'message', 'rows' => '3', 'placeHolder' => 'Enter Message '));
            ?>
        </div>
         <?php echo form_submit('submit_button', 'Send', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
    </div> 
</div>
