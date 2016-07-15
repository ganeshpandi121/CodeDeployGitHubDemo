<!---- All the supplier details will be below and open when 
         clicked on "View Supplier Details in order progress page: -->
<!-- Supplier Quote -->
 <?php if (!empty($approved_supplier_data)) { ?>
<div class="modal fade" id="supplier-details" role="dialog">
        <div class="modal-dialog">
            <!-- Quote content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <?php
                        if (!empty($approved_supplier_data->company_logo_path)) {
                            $logo =   base_url() . "uploads/company/" . $approved_supplier_data->company_logo_path;
                        } else {
                            $logo = base_url() . "styles/images/default.png";
                        }
                    ?>
                    <h4 class="modal-title"> <img src="<?php echo $logo;?>" width="40px" height="40px"> 
                        <?php echo $approved_supplier_data->supplier_name; ?> 
                    </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered clearfix">

                        <tr>
                            <th width='50%'>Name </th>
                            <td ><?php echo $approved_supplier_data->supplier_name; ?> </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $approved_supplier_data->email; ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo $approved_supplier_data->telephone_code . '' . $approved_supplier_data->telephone_no; ?></td>
                        </tr>
                        <tr>
                            <th>Fax Number</th>
                            <td><?php 
                            $fax_number = !empty($approved_supplier_data->fax_no) ? $approved_supplier_data->fax_no : '---';
                            echo $fax_number; ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php
                            if (!empty($approved_supplier_data->street_address))
                            {
                            echo $approved_supplier_data->address_name . ',<br> ' . $approved_supplier_data->street_address . '.'; 
                            }
                            else 
                            {
                                echo "---";
                            }
?>
                            </td>
                        </tr>
                         <tr>
                            <th>City</th>
                            <td><?php echo !empty($approved_supplier_data->city) ? $approved_supplier_data->city : '---'; ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo !empty($approved_supplier_data->state) ? $approved_supplier_data->state : '---'; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Country</th>
                            <td><?php echo !empty($approved_supplier_data->country_name) ? $approved_supplier_data->country_name : '---'; ?></td>
                        </tr>
                        <tr>
                            <th>ZIP code</th>
                            <td><?php echo !empty($approved_supplier_data->post_code) ? $approved_supplier_data->post_code : '---'; ?></td>
                        </tr>
                        <tr>
                            <th>Additional Information</th>
                            <td>Company: 
                                <?php echo !empty($approved_supplier_data->company_name) ? $approved_supplier_data->company_name : '---' ?><br>Web site: 
                                <?php echo !empty($approved_supplier_data->website) ? $approved_supplier_data->website : '---' ?><br>
                             
                           </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

</div>

<!------------End of all supplier details----------------->


<?php } ?>