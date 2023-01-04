<script>
    window.onload = function() {
        'use strict';

        var DashboardRef = window.DashboardRef || {};
        var xhr = null;

        if (window.XMLHttpRequest) {
            xhr = window.XMLHttpRequest;
        } else if (window.ActiveXObject('Microsoft.XMLHTTP')) {
            xhr = window.ActiveXObject('Microsoft.XMLHTTP');
        }

        var send = xhr.prototype.send;

        xhr.prototype.send = function(data) {
            try {
                send.call(this, data);
            } catch (e) {
                showErrorMessage(e);
            }
        };

        DashboardRef.dashSelectedRoomId = '{{ $assigned_stylist ? $assigned_stylist->chat_room_id : "" }}';
        
        DashboardRef.loadActiveContactChat = function(room_id) {

            var room_dtls = '{{ $chat_room_dtls }}';

            if(room_dtls != undefined && room_dtls != null && room_dtls != ''){

                // fetch messages
                fetchChatRoomMessages(room_id, true);

                // focus on messaging input
                messageInput.focus();
                // update info in view
                // $(".messenger-infoView .info-name").html(room_dtls.receiver_name);
                $(".m-header-messaging .user-name").html(room_dtls.receiver_name);
                // Star status

                // form reset and focus
                $("#message-form").trigger("reset");
                cancelAttachment();
                messageInput.focus();
                disableOnLoad(false);

            }

        }

        DashboardRef.initEvents = function() {

            // channel.bind("messaging", function (data) {

            //     if(data.chat_room_dtls != undefined && data.chat_room_dtls != ''){

            //         if(data.chat_room_id == DashboardRef.dashSelectedRoomId && data.message_obj != undefined && data.message_obj != '' && data.message_obj.receiver_user == auth_user_type && data.message_obj.receiver_id == auth_id) {
                    
            //             $(".messages").find(".message-hint").remove();
                    
            //             messagesContainer.find(".messages").append(getChatMessagesUI([data.message_obj]));
                    
            //             scrollToBottom(messagesContainer);

            //             // update contact item
            //             updateContactItem(data.chat_room_id, data.message_obj);
            //             getChatContacts(DashboardRef.dashSelectedRoomId);
            //             // makeSeen(true);
            //             // // remove unseen counter for the user from the contacts list
            //             // $(".messenger-list-item[data-contact=" + DashboardRef.dashSelectedRoomId + "]")
            //             // .find("tr>td>b")
            //             // .remove();
            //         }
            //     }

            // });

            if(DashboardRef.dashSelectedRoomId != ''){
                DashboardRef.loadActiveContactChat(DashboardRef.dashSelectedRoomId);
            }

        }
        
        DashboardRef.initEvents();
    };

</script>
