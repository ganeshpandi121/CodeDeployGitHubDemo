
moment.tz.setDefault("Asia/Kuala_Lumpur");

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});

var Messages = {
    error: function (errorMessage) {
        $('#errorModal').remove();
        var text = '<div class="modal fade " id="errorModal" role="dialog">'
                + '<div class="modal-dialog">'
                + '<div class="modal-content alert-danger">'
                + '<div class="modal-header ">'
                + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                + '<h4 class = "modal-title " > Error </h4>'
                + '</div>'
                + '<div class="modal-body" style="font-size: 14px">'
                + '<p><b>' + errorMessage + '</b></p>'
                + '</div>'
                + '<div class="modal-footer">'
                + '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div>';
        $(text).insertAfter("body");
        $("#errorModal").modal();
    },
    success: function (successMessage) {
        $('#successModal').remove();
        var text = '<div class="modal fade " id="successModal" role="dialog">'
                + '<div class="modal-dialog">'
                + '<div class="modal-content alert-success">'
                + '<div class="modal-header ">'
                + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                + '<h4 class = "modal-title " > Success </h4>'
                + '</div>'
                + '<div class="modal-body" style="font-size: 14px">'
                + '<p><b>' + successMessage + '</b></p>'
                + '</div>'
                + '<div class="modal-footer">'
                + '<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div>';
        $(text).insertAfter("body");
        $("#successModal").modal();
    }
    ,
    confirm: function (confirmMessage, buttonUrl) {
        $('#confirmModal').remove();
        var text = '<div class="modal fade " id="confirmModal" role="dialog">'
                + '<div class="modal-dialog">'
                + '<div class="modal-content alert-info">'
                + '<div class="modal-header ">'
                + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                + '<h4 class = "modal-title " > Please Confirm </h4>'
                + '</div>'
                + '<div class="modal-body" style="font-size: 14px">'
                + '<p><b>' + confirmMessage + '</b></p>'
                + '<div class = "row">'
                + '<div class = "col-md-6 text-right"><a class="btn btn-success" href="' + buttonUrl + '">Approve</a></div>'
                + '<div class = "col-md-6 text-left"><button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button></div>'
                + '</div></div>'
                + '</div>'
                + '</div>'
                + '</div>';
        $(text).insertAfter("body");
        $("#confirmModal").modal();
    }
}

var Chat = {
    chatBoxOpen: function (id, user_id, user_name, to_user_id) {
        if ($('#chatModel' + id).length != 0) {
            return;
        }
        var chatCounter = $('#chatCounter').val();
        var offset = parseInt(chatCounter) * this.chatBoxWidth();
        $('#chatCounter').val((parseInt(chatCounter) + 1));
        $('#chatModel' + id).remove();
        var text = '<div class="chatWindow" id="chatModel' + id + '" style="right:' + offset + 'px;width:' + this.chatBoxWidth() + 'px" ><div class="panel panel-primary"  >'
                + '<div class="panel-heading" data-toggle="collapse" href="#collapse' + id + '">'
                + user_name + ' <div class="pull-right">'
                + '<span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="Chat.chatBoxClose(' + id + ');"></span>'
                + ' </div>'
                + '</div>'
                + '<div id="collapse' + id + '" class="panel-collapse"><div class="panel-body">'
                + '</div>'
                + '<div class="panel-footer">'
                + '<span id="chat_error_msg' + id + '" style="font-size: 12px;color: red;"></span>'
                + '<div class="input-group"><input type="text" onfocus="Chat.chatBoxLoadOne(' + id + ')" class="form-control input-sm"  name="msg" id="msg' + id + '" /><input type="hidden" name="user_id" id="user_id' + id + '" value="' + user_id + '"/><input type="hidden" name="to_user_id" id="to_user_id' + id + '" value="' + to_user_id + '"/>'
                + ' <span class="input-group-btn"><button type="button" class="btn btn-warning btn-sm" onclick="Chat.chatBoxPush(' + id + ')">Send</button></span>'
                + '</div></div></div>'
                + '</div></div>';

        $('#chatSpace').append(text);
        this.chatBoxLoadAll(id);
        $('#msg' + id).val("").focus();

        // $("#chatModel" + id).show();
    },
    chatBoxClose: function (id) {
        $('#chatModel' + id).remove();
        var chatCounter = $('#chatCounter').val();
        $('#chatCounter').val((parseInt(chatCounter) - 1));

    },
    chatBoxMinimise: function () {

    },
    chatBoxLoadAll: function (id) {
        $.get(base_url + "dashboard/job/chat/" + id,
                function (data) {
                    var obj = JSON.parse(data);
                    var text = "<div class='chat-scroll'>";
                    var x;
                    for (x in obj) {
                        text += "<p data-time=" + obj[x]["created_time"] + "><b>" + obj[x]["user_first_name"] + ":</b>" + obj[x]["msg"] + "</p>";

                    }
                    text += "</div>";

                    $("#chatModel" + id + " .panel-body").html(text);
                    $(".chat-scroll").animate({scrollTop: $(".chat-scroll")[0].scrollHeight}, 1000);

                });
    },
    chatBoxLoadOne: function (id) {
        $.get(base_url + "dashboard/job/chat/" + id,
                function (data) {
                    lastEntryValue = $("#chatModel" + id + " .panel-body .chat-scroll p").last().attr("data-time");
                    if (lastEntryValue) {
                        var obj = JSON.parse(data);
                        var text = "";
                        for (x in obj) {
                            if (lastEntryValue < obj[x]["created_time"]) {
                                text += "<p data-time=" + obj[x]["created_time"] + "><b>" + obj[x]["user_first_name"] + ":</b>" + obj[x]["msg"] + "</p>";
                            }
                        }
                        $("#chatModel" + id + " .panel-body .chat-scroll").append(text);
                    } else {
                        this.chatBoxLoadAll(id);
                    }

                    // 
                    $(".chat-scroll").animate({scrollTop: $(".chat-scroll")[0].scrollHeight}, 1000);

                });
    },
    chatBoxPush: function (id) {
        $('#chat_error_msg' + id).html("");
        msg = $('#msg' + id).val();
        to_user_id = $('#to_user_id' + id).val();
        //console.log(msg)
        if (msg == '' || msg.length == 0 || $.trim($('#msg' + id).val()).length == 0) {
            $('#chat_error_msg' + id).html("Please enter your message");
            return false;
        } else {
            user_id = $('#user_id' + id).val();
            urlfor = base_url + "dashboard/job/chat/submit_chat?jq_id=" + id + "&user_id=" + user_id + "&to_user_id=" + to_user_id + "&msg=" + msg;

            $.post(urlfor, function (data) {
                $('#msg' + id).val("").focus();
                this.chatBoxLoadOne(id);
            });
        }
    },
    chatBoxWidth: function () {
        return 300;
    }
}


