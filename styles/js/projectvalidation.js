/**
 * Validation file for post a project and post a requirement
 */
var postprojectController = {
    postprojectValidation: function () {
        var userType1 = $('#user_type_1').prop('checked');
        var userType2 = $('#user_type_2').prop('checked');

        $('#sign_up_email').parent().removeClass("has-error has-danger");
        $('#sign_up_password').parent().removeClass("has-error has-danger");
        $('#sign_up_confirm_password').parent().removeClass("has-error has-danger");
        $('#user_first_name').parent().removeClass("has-error has-danger");
        $('#user_last_name').parent().removeClass("has-error has-danger");
        $('#company_name').parent().removeClass("has-error has-danger");
        $('#terms_conditions').parent().removeClass("has-error has-danger");
        $('#category').parent().removeClass("has-error has-danger");
        $('#sub-category').parent().removeClass("has-error has-danger");
        $('#job_name').parent().removeClass("has-error has-danger");
        $('#job_overview').parent().removeClass("has-error has-danger");
        $('#product_quantity').parent().removeClass("has-error has-danger");
        $('#product_lead_time').parent().removeClass("has-error has-danger");
        $('#description').parent().removeClass("has-error has-danger");
        /*$('#special_requirement').parent().removeClass("has-error has-danger");*/
        $('#file_type').parent().removeClass("has-error has-danger");
        $('input[name="is_courier"]').parent().removeClass("has-error has-danger"); 
        $('input[name="is_air_freight"]').parent().removeClass("has-error has-danger"); 
        $('input[name="is_sea_freight"]').parent().removeClass("has-error has-danger"); 
        $('#address_name').parent().removeClass("has-error has-danger");
        $('#city').parent().removeClass("has-error has-danger");
        $('#country').parent().removeClass("has-error has-danger");
        $('#street_address').parent().removeClass("has-error has-danger");
        $('#post_code').parent().removeClass("has-error has-danger");
        $('#expected_amount').parent().removeClass("has-error has-danger");
        $('#is_urgent').parent().removeClass("has-error has-danger");
        $('#is_sealed').parent().removeClass("has-error has-danger");
        $('#sla_milestone').parent().removeClass("has-error has-danger");
        var error = "";

        if (userType1 == true) {
            var re = /\S+@\S+\.\S+/;
            var test_email = $('#sign_up_email').val();
            if (re.test(test_email) == false) {
                error += "Please enter a valid email address.<br/>";
                $('#sign_up_email').parent().addClass("has-error has-danger");

            }

            var passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}$/;

            var pass = $('#sign_up_password').val();
            if (passReg.test(pass) == false) {
                error += "Password must be at least 8 characters, no more than 12 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit.<br/>";
                $('#sign_up_password').parent().addClass("has-error has-danger");

            }
            
            if($('#sign_up_confirm_password').val()!=""){
                if ($('#sign_up_password').val() != $('#sign_up_confirm_password').val()) {
                    error += "Password And Confirm Password Should be same<br/>";
                    $('#sign_up_confirm_password').parent().addClass("has-error has-danger");

                }
            }else{
                error += "Please enter Confirm Password<br/>";
                $('#sign_up_confirm_password').parent().addClass("has-error has-danger");
            }
            if ($.trim($('#company_name').val()) == "") {
                error += "Please enter Company Name<br/>";
                $('#company_name').parent().addClass("has-error has-danger");
            } 
            if ($.trim($('#user_first_name').val()) == "") {
                error += "Please enter first Name<br/>";
                $('#user_first_name').parent().addClass("has-error has-danger");
            } 

            if ($.trim($('#user_last_name').val()) == "") {
                error += "Please enter last name<br/>";
                $('#user_last_name').parent().addClass("has-error has-danger");
            } 
            
            if ($.trim($('#telephone_no_1').val()) == "") {
                error += "Please enter telephone number<br/>";
                $('#telephone_no_1').parent().addClass("has-error has-danger");
            } 
            if ($.trim($('#telephone_code_1').val()) == "") {
                error += "Please enter telephone code<br/>";
                $('#telephone_code_1').parent().addClass("has-error has-danger");
            } 

            if (isNaN($('#telephone_no_1').val())) {
                error += "Only numbers are allowed in phone number<br/>";
                $('#telephone_no_1').parent().addClass("has-error has-danger");
            }
            if ($("input[name='terms_conditions']").prop('checked') == false) {
                error += "Please accept our terms and conditions<br/>";
                $("input[name='terms_conditions']").parent().addClass("has-error has-danger");
            }
        }

        if (userType2 == true) {
            if ($('#login_email').val() == "") {
                error += "Please enter Email<br/>";
                $('#login_email').parent().addClass("has-error has-danger");
            }

            if ($('#login_password').val() == "") {
                error += "Please enter Password<br/>";
                $('#login_password').parent().addClass("has-error has-danger");
            }
        }

        if ($('#category option:selected').val() == "0") {

            error += "Please select category<br/>";
            $('#category').parent().addClass("has-error has-danger");
        }

        if ($('#sub-category option:selected').val() == "0") {
            error += "Please select subcategory<br/>";
            $('#sub-category').parent().addClass("has-error has-danger");
        }

        if ($('#job_name').val() == "") {
            error += "Please enter job name<br/>";
            $('#job_name').parent().addClass("has-error has-danger");
        }

        if ($.trim($('#job_overview').val()) == "") {
            error += "Please enter job overview<br/>";
            $('#job_overview').parent().addClass("has-error has-danger");
        }

        if (isNaN($('#product_quantity').val()) || $('#product_quantity').val() == "") {
            error += "Please enter product quantity in number<br/>";
            $('#product_quantity').parent().addClass("has-error has-danger");
        }
        
        if ($('#product_lead_time').val() == "") {
            error += "Please enter project lead time<br/>";
            $('#product_lead_time').parent().addClass("has-error has-danger");
        }

        if ($.trim($('#description').val()) == "") {
            error += "Please enter description<br/>";
            $('#description').parent().addClass("has-error has-danger");
        }

        if ($('#file_type option:selected').val() == "0") {
            error += "Please select file type<br/>";
            $('#file_type').parent().addClass("has-error has-danger");
        }
        
        if($('input[name="delivery_required"]').prop('checked')== true){
          if(($('input[name="is_courier"]').prop('checked')== false) && ($('input[name="is_air_freight"]').prop('checked')== false) && ($('input[name="is_sea_freight"]').prop('checked')== false)){ 
            error += "Please select any delivery method<br/>";
            $('input[name="is_courier"]').parent().addClass("has-error has-danger"); 
            $('input[name="is_air_freight"]').parent().addClass("has-error has-danger"); 
            $('input[name="is_sea_freight"]').parent().addClass("has-error has-danger"); 
          } 
          if($('#my_address_other').prop('checked')== true){
                if ($.trim($('#address_name').val()) == "") {
                    error += "Please enter address tittle<br/>";
                    $('#address_name').parent().addClass("has-error has-danger");
                }
                
                if ($.trim($('#street_address').val()) == "") {
                    error += "Please enter street address<br/>";
                    $('#street_address').parent().addClass("has-error has-danger");
                }

                if ($.trim($('#city').val()) == "") {
                    error += "Please enter city<br/>";
                    $('#city').parent().addClass("has-error has-danger");
                } 

                if ($('#country option:selected').val() == "0") {
                    error += "Please select country<br/>";
                    $('#country').parent().addClass("has-error has-danger");
                }

                if ($('#post_code').val() == "") {
                    error += "Please enter zip code<br/>";
                    $('#post_code').parent().addClass("has-error has-danger");
                }  
          }
        }

        if (isNaN($('#expected_amount').val()) || $('#expected_amount').val() == "") {
            error += "Please enter expected amount in number<br/>";
            $('#expected_amount').parent().addClass("has-error has-danger");
        }

        if ($('#sla_milestone option:selected').val() == "0") {
            error += "Please select SLA<br/>";
            $('#sla_milestone').parent().addClass("has-error has-danger");
        }
        
        if ($('#sla_milestone1').val() == "") {
            error += "Please select SLA<br/>";
            $('#sla_milestone1').parent().addClass("has-error has-danger");
        }

        if (error) {
            // $("#postproject_alert").html(error).show();
            Messages.error(error);
            return false;
        } else {
            return true;
        }

    }
}

/**
 * Validation for upload file
 * checks specified image types
 * gif, png, jpeg, jpg, doc, docx 
 */
function ValidateFileUpload(fInput) {
    var jobFile = document.getElementById('job_file');
    var FileUploadPath = jobFile.value;

//To check if user upload any file
    if (FileUploadPath == '') {
        Messages.error("Please upload file");

    } else {
        var Extension = FileUploadPath.substring(
                FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

        if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg" || Extension == "doc" || Extension == "docx" || Extension == "pdf") {

// To Display
            if (jobFile.files && jobFile.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //$('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(jobFile.files[0]);
            }

        }

//The file upload is NOT an image
        else {
            Messages.error("Only allows file types of GIF, PNG, JPG, JPEG, DOC, DOCX. ");
            fInput.value = '';
            return false;

        }
    }
}

