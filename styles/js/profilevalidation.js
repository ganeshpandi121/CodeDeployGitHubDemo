/**
 * Validation file for profile page
 */
var profileController = {
    addressValidation: function () {
        $('#address_name').parent().removeClass("has-error has-danger");
        $('#city').parent().removeClass("has-error has-danger");
        $('#country').parent().removeClass("has-error has-danger");
        $('#street_address').parent().removeClass("has-error has-danger");
        $('#post_code').parent().removeClass("has-error has-danger");

        var error = "";

        if ($.trim($('#address_name').val()) == "") {
            error += "Please enter Name<br/>";
            $('#address_name').parent().addClass("has-error has-danger");
        }

        if ($.trim($('#city').val()) == "") {
            error += "Please enter City<br/>";
            $('#city').parent().addClass("has-error has-danger");
        }

        if ($('#country option:selected').val() == "0") {
            error += "Please select Country<br/>";
            $('#country').parent().addClass("has-error has-danger");
        }

        if ($.trim($('#street_address').val()) == "") {
            error += "Please enter Street Address<br/>";
            $('#street_address').parent().addClass("has-error has-danger");
        }

        if ($('#post_code').val() == "") {
            error += "Please enter Zip code<br/>";
            $('#post_code').parent().addClass("has-error has-danger");
        }

        if (error) {
            // $("#adres_alert").html(error).show();
            Messages.error(error);
            return false;
        } else {
            return true;
        }

    },
    personalinfoValidation: function () {
        $('#user_first_name').parent().removeClass("has-error has-danger");
        $('#user_last_name').parent().removeClass("has-error has-danger");
        $('#user_comp_name').parent().removeClass("has-error has-danger");
        $('#user_trading_name').parent().removeClass("has-error has-danger");
        $('#user_web_url').parent().removeClass("has-error has-danger");
        $('#user_brands_name').parent().removeClass("has-error has-danger");

        var error = "";

        if ($.trim($('#user_first_name').val()) == "") {
            error += "Please enter First Name<br/>";
            $('#user_first_name').parent().addClass("has-error has-danger");
        }

        if ($.trim($('#user_last_name').val()) == "") {
            error += "Please enter Last Name <br/>";
            $('#user_last_name').parent().addClass("has-error has-danger");
        }

       if (error) {
            // $("#personal_alert").html(error).show();
            Messages.error(error);
            return false;
        } else {
            return true;
        }

    },
    companyinfoValidation: function () {
        $('#user_comp_name').parent().removeClass("has-error has-danger");
        $('#user_web_url').parent().removeClass("has-error has-danger");
        $('#telephone_code').parent().removeClass("has-error has-danger");
        $('#telephone_no').parent().removeClass("has-error has-danger");
       
        var error = "";

       if ($('#user_comp_name').val() == "") {
            error += "Please enter Company Name<br/>";
            $('#user_comp_name').parent().addClass("has-error has-danger");
        }
        
        if ($('#user_web_url').val() == "") {
            error += "Please enter Website Url<br/>";
            $('#user_web_url').parent().addClass("has-error has-danger");
        }
        if ($('#telephone_code').val() == "") {
            error += "Please enter Phone Code<br/>";
            $('#telephone_code').parent().addClass("has-error has-danger");
        }
         if ($('#telephone_no').val() == "") {
            error += "Please enter Phone Number<br/>";
            $('#telephone_no').parent().addClass("has-error has-danger");
        }
        if (isNaN($('#telephone_no').val())) {
            error += "Only Numbers are allowed in Phone Number<br/>";
            $('#telephone_no').parent().addClass("has-error has-danger");
        }

        if (error) {
            // $("#personal_alert").html(error).show();
            Messages.error(error);
            return false;
        } else {
            return true;
        }

    },
    phonenumberValidation: function () {
        $('#country-2').parent().removeClass("has-error has-danger");
        $('#telephone_code').parent().removeClass("has-error has-danger");
        $('#telephone_no').parent().removeClass("has-error has-danger");

        var error = "";

        if ($('#country-2 option:selected').val() == "0") {
            error += "Please select Country<br/>";
            $('#country-2').parent().addClass("has-error has-danger");
        }

        if ($('#telephone_code option:selected').val() == "") {
            error += "Please select Telephone code<br/>";
            $('#telephone_code').parent().addClass("has-error has-danger");
        }

        if (isNaN($('#telephone_no').val()) || $('#telephone_no').val() == "") {
            error += "Please enter Phone Number<br/>";
            $('#telephone_no').parent().addClass("has-error has-danger");
        }


        if (error) {
            //$("#phone_alert").html(error).show();
            Messages.error(error);
            return false;
        } else {
            return true;
        }

    },
}

/**
 * Validation for upload profile pic
 * checks specified image types
 * gif, png, jpeg, jpg, doc, docx 
 */
function ValidateFileUpload(fInput) {
    var profile = document.getElementById('profile_pic');
    var FileUploadPath = profile.value;

//To check if user upload any file
    if (FileUploadPath == '') {
        Messages.error("Please upload file");

    } else {
        var Extension = FileUploadPath.substring(
                FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        var fileSize = profile.files[0].size;

//The file uploaded is an image
        
        if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

// To Display
            if (fileSize > 2000000){
                Messages.error("Only allows file size upto 2mb. ");
                fInput.value = '';
                return false; 
             }
            if (profile.files && profile.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //$('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(profile.files[0]);
            }

        }

//The file upload is NOT an image
        else {
            Messages.error("Only allows file types of GIF, PNG, JPG, JPEG. ");
            fInput.value = '';
            return false;

        }
    }
}

/**
 * Validation for upload Company Logo
 * checks specified image types
 * gif, png, jpeg, jpg, doc, docx 
 */
function ValidateCompanyLogo(fInput) {
    var Id = document.getElementById('company_logo');
    var FileUploadPath = Id.value;

//To check if user upload any file
    if (FileUploadPath == '') {
        Messages.error("Please upload file");

    } else {
        var Extension = FileUploadPath.substring(
                FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        var fileSize = Id.files[0].size;

//The file uploaded is an image
        
        if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

// To Display
            if (fileSize > 2000000){
                Messages.error("Only allows file size upto 2mb. ");
                fInput.value = '';
                return false; 
             }
            if (Id.files && Id.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //$('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(Id.files[0]);
            }

        }

//The file upload is NOT an image
        else {
            Messages.error("Only allows file types of GIF, PNG, JPG, JPEG. ");
            fInput.value = '';
            return false;

        }
    }
}

