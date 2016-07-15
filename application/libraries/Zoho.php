<?php

class Zoho {
    /* Not being used 
      public function getAuth() {
      $username = "anju@121outsource.com";
      $password = "1bit832mz3gu";
      $param = "SCOPE=ZohoCRM/crmapi&EMAIL_ID=" . $username . "&PASSWORD=" . $password . "&DISPLAY_NAME=leadCardCore";
      $ch = curl_init("https://accounts.zoho.com/apiauthtoken/nb/create");
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
      $result = curl_exec($ch);
      /* This part of the code below will separate the Authtoken from the result.
      Remove this part if you just need only the result
      $anArray = explode("\n", $result);
      $authToken = explode("=", $anArray['2']);
      $cmp = strcmp($authToken['0'], "AUTHTOKEN");
      /*echo $anArray['2'] . "";
      if ($cmp == 0) {
      /*echo "Created Authtoken is : " . $authToken['1'];
      return $authToken['1'];
      }
      curl_close($ch);
      } */

    public function data_to_leads($auth, $data) {

        //insert data to leads database
        $this->insert_leads_to_db($data);

        //post data to zoho as leads
        $this->post_data_zoho($auth, $data);
        return true;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function insert_leads_to_db($data) {
        $this->CI = & get_instance();
        $leads_db = $this->CI->load->database('leads_db', TRUE);

        $data['project'] = 2;
        $data['lead_source'] = 'www.smartcardmarket.com';
        $data['cc_email'] = $this->CI->config->item('admin_email', 'smartcardmarket');
        $data['bcc_email'] = '';
        $data['ipadress'] = $_SERVER['REMOTE_ADDR'];
        $leads_db->insert('contact_us_cardcore_master_db', $data);
        //$insert_id = $this->leads_db->insert_id();
        $leads_db->close();
        return true;
    }

    /**
     * 
     * @param type $auth
     * @param type $form_data
     * @return type
     */
    public function post_data_zoho($auth, $form_data) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <Leads>
        <row no="1">
        <FL val="First Name">' . $form_data['first_name'] . '</FL>
        <FL val="Last Name">' . $form_data['last_name'] . '</FL>
        <FL val="Email">' . $form_data['email'] . '</FL>
        <FL val="Subject">' . $form_data['subject'] . '</FL>
        <FL val="Phone">' . $form_data['phone'] . '</FL>
        <FL val="Description">' . $form_data['message'] . '</FL>
        <FL val="Lead Source">' . "www.smartcardmarket.com" . '</FL>
        </row>
        </Leads>';

        $url = "https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
        $query = "authtoken=" . $auth . "&scope=crmapi&newFormat=1&xmlData=" . $xml;
        $ch = curl_init();
        /* set url to send post request */
        curl_setopt($ch, CURLOPT_URL, $url);
        /* allow redirects */
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        /* return a response into a variable */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        /* times out after 30s */
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        /* set POST method */
        curl_setopt($ch, CURLOPT_POST, 1);
        /* add POST fields parameters */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Set the request as a POST FIELD for curl.
        //Execute cUrl session
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}

?>