<!---- All the supplier details will be below and open when 
         clicked on "View Supplier Details in order progress page: -->
<!-- Freight Quote -->
<?php if (!empty($approved_freight_data)) { ?>
    <div class="modal fade" id="freight-details" role="dialog">

        <div class="modal-dialog">
            <!-- Quote content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <img src="http://placehold.it/40x40"> Freight Profile </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered clearfix">
                        <tr>
                            <th width='50%'>Name </th>
                            <td ><?php echo $approved_freight_data->freight_name; ?> </td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo $approved_freight_data->telephone_code . '' . $approved_freight_data->telephone_no; ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo $approved_freight_data->address_name . ' ' . $approved_freight_data->street_address . ' ' . $approved_freight_data->city . ' ' . $approved_freight_data->state; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $approved_freight_data->email; ?></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td><?php echo $approved_freight_data->country_name; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!------------End of all supplier details----------------->
    <div class="form-group">
        <a class="btn btn-blue center-block" data-toggle="modal" data-target="#freight-details">View Freight Details </a>
    </div>
<?php } ?>