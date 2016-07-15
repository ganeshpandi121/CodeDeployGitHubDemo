<?php 

    $link = mysql_connect('cardcore.cp8gyunk8uqf.us-west-2.rds.amazonaws.com', 'smartCardMarket', 'Sm4r7C4rdP4$$');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db('smartCardMarket');

    // Buyer data migration
    $buyer_table_data = mysql_query("SELECT cd_id,company_name,company_logo_path,website,is_active "
            . "FROM consumer_details");
    $buyer_data = array();

    while ($row = mysql_fetch_assoc($buyer_table_data)) {
        $buyer_data[] = $row;
    }
    if (!empty($buyer_data)) {
        $insert_query = "INSERT INTO company_details(company_name,company_logo_path,website,is_active)"
                . " VALUES ";
        $values = '';
        $inserted = 0;
        foreach($buyer_data as $col){
            $company_name = ($col['company_name'] != '')? $col['company_name']: '';
            $logo = ($col['company_logo_path'] != '')? $col['company_logo_path']: '';
            $website = ($col['website'] != '')? $col['website']: '';
            $is_active = ($col['is_active'] != '')? $col['is_active']: '';
            $values = "('" . $company_name . "'," 
                    . "'".$logo ."'," 
                    . "'". $website. "',"
                    .$is_active.")";

            $inserted =  mysql_query($insert_query.$values);
            if($inserted){
                $company_details_id = mysql_insert_id();
                $update_query = "UPDATE consumer_details cd "
                        . " SET cd.company_details_id =".$company_details_id
                        . " WHERE cd.cd_id = ".$col['cd_id'];
                mysql_query($update_query);
            }
        }
        echo "Buyer Data Updated";
    }
    
    // Seller data migration
    $seller_table_data = mysql_query("SELECT sd_id,company_name,company_logo_path,website_url,is_active "
                . "FROM supplier_details");
    $seller_data = array();

    while ($row = mysql_fetch_assoc($seller_table_data)) {
        $seller_data[] = $row;
    }
    if (!empty($seller_data)) {
        $insert_query = "INSERT INTO company_details(company_name,company_logo_path,website,is_active)"
                . " VALUES ";
        $values = '';
        $inserted = 0;
        foreach($seller_data as $col){
            $company_name = ($col['company_name'] != '')? $col['company_name']: '';
            $logo = ($col['company_logo_path'] != '')? $col['company_logo_path']: '';
            $website = ($col['website_url'] != '')? $col['website_url']: '';
            $is_active = ($col['is_active'] != '')? $col['is_active']: '';
            $values = "('" . $company_name . "'," 
                    . "'".$logo ."'," 
                    . "'". $website. "',"
                    .$is_active.")";

            $inserted =  mysql_query($insert_query.$values);
            if($inserted){
                $company_details_id = mysql_insert_id();
                $update_query = "UPDATE supplier_details sd "
                        . " SET sd.company_details_id =".$company_details_id
                        . " WHERE sd.sd_id = ".$col['sd_id'];
                mysql_query($update_query);
            }
        }
        echo "<br/> Seller Data Updated";
    }
    
    // Freight data migration
    
    $freight_table_data = mysql_query("SELECT fd_id,company_name,website_url,is_active "
            . "FROM freight_details");
    $freight_data = array();

    while ($row = mysql_fetch_assoc($freight_table_data)) {
        $freight_data[] = $row;
    }
    if (!empty($freight_data)) {
        $insert_query = "INSERT INTO company_details(company_name,company_logo_path,website,is_active)"
                . " VALUES ";
        $values = '';
        $inserted = 0;
        foreach($freight_data as $col){
            $company_name = ($col['company_name'] != '')? $col['company_name']: '';
            $logo = ($col['company_logo_path'] != '')? $col['company_logo_path']: '';
            $website = ($col['website_url'] != '')? $col['website_url']: '';
            $is_active = ($col['is_active'] != '')? $col['is_active']: '';
            $values = "('" . $company_name . "'," 
                    . "'".$logo ."'," 
                    . "'". $website. "',"
                    .$is_active.")";

            $inserted =  mysql_query($insert_query.$values);
            if($inserted){
                $company_details_id = mysql_insert_id();
                $update_query = "UPDATE freight_details fd "
                        . " SET fd.company_details_id =".$company_details_id
                        . " WHERE fd.fd_id = ".$col['fd_id'];
                mysql_query($update_query);
            }
        }
        echo "<br/> Freight Data Updated";
    }
    
    //User transformation table population
    /*$user_table_data = mysql_query("SELECT user_id,user_type_id FROM users");
    $user_data = array();

    while ($row = mysql_fetch_assoc($user_table_data)) {
        $user_data[] = $row;
    }
    if (!empty($user_data)) {
        $insert_query = "INSERT INTO user_transformation(user_id,user_type_id,created_time)"
                . " VALUES ";
        $values = '';
        foreach($user_data as $col){
            $user_id = ($col['user_id'] != '')? $col['user_id']: '';
            $user_type_id = ($col['user_type_id'] != '')? $col['user_type_id']: '';
            $time = time();
            $values .= "('" . $user_id . "'," 
                    . "'".$user_type_id ."'," 
                    .$time."), ";
            
        }
        $insert_query = $insert_query.rtrim($values, ", ");
        mysql_query($insert_query);
        
        echo "<br/> User Transformation Table Populated";
    }*/

