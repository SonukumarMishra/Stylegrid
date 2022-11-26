<script>

    /**
     *-------------------------------------------------------------
    * Global variables
    *-------------------------------------------------------------
    */
    var messenger,
        typingTimeout,
        typingNow = 0,
        temporaryMsgId = 0,
        defaultAvatarInSettings = null,
        messengerColor,
        dark_mode,
        messages_page = 1
        allContactsList=[];

    const messagesContainer = $(".messenger-messagingView .m-body"),
        messengerTitleDefault = $(".messenger-headTitle").text(),
        messageInput = $("#message-form .m-send"),
        defaultMessengerColor = "#2180f3",
        access_token = $('meta[name="csrf-token"]').attr("content");

        console.log(chat_baseurl);
        var selectedRoomId = "";
    
    /**
     *-------------------------------------------------------------
    * Re-usable methods
    *-------------------------------------------------------------
    */
    const escapeHtml = (unsafe) => {
                                    return unsafe
                                        .replace(/&/g, "&amp;")
                                        .replace(/</g, "&lt;")
                                        .replace(/>/g, "&gt;");
                                    };

    /**
     *-------------------------------------------------------------
    * Pusher channels and event listening..
    *-------------------------------------------------------------
    */

    // subscribe to the channel
    // var channel = pusher.subscribe("private-chatify");

    // // Listen to messages, and append if data received
    // channel.bind("messaging", function (data) {
    //     if (data.from_id == getMessengerId() && data.to_id == auth_id) {
    //         $(".messages").find(".message-hint").remove();
    //         messagesContainer.find(".messages").append(data.message);
    //         scrollToBottom(messagesContainer);
    //         makeSeen(true);
    //         // remove unseen counter for the user from the contacts list
    //         $(".messenger-list-item[data-contact=" + getMessengerId() + "]")
    //         .find("tr>td>b")
    //         .remove();
    //     }
    // });

        
    /**
     *-------------------------------------------------------------
    * Trigger contact item updates
    *-------------------------------------------------------------
    */
    function sendContactItemUpdates(status) {
        // return channel.trigger("client-contactItem", {
        //     update_for: getMessengerId(), // Messenger
        //     update_to: auth_id, // Me
        //     updating: status,
        // });
    }


    function disableOnLoad(action = true) {
        if (action == true) {

            // hide send card
            $(".messenger-sendCard").hide();
            // add loading opacity to messages container
            messagesContainer.css("opacity", ".5");
            // disable message form fields
            messageInput.attr("readonly", "readonly");
            $("#message-form button").attr("disabled", "disabled");
            $(".upload-attachment").attr("disabled", "disabled");
        } else {
            
            // show send card
            $(".messenger-sendCard").show();
            // remove loading opacity to messages container
            messagesContainer.css("opacity", "1");
            // enable message form fields
            messageInput.removeAttr("readonly");
            
            $("#message-form button").removeAttr("disabled");
            $(".upload-attachment").removeAttr("disabled");
        }
    }

    // loading placeholder for users list item
    function listItemLoading(items) {
        let template = "";
        for (let i = 0; i < items; i++) {
            template += `
            <div class="loadingPlaceholder">
            <div class="loadingPlaceholder-wrapper">
            <div class="loadingPlaceholder-body">
            <table class="loadingPlaceholder-header">
            <tr>
            <td style="width: 45px;"><div class="loadingPlaceholder-avatar"></div></td>
            <td>
                <div class="loadingPlaceholder-name"></div>
                    <div class="loadingPlaceholder-date"></div>
            </td>
            </tr>
            </table>
            </div>
            </div>
            </div>
            `;
        }
        return template;
    }

    /**
     *-------------------------------------------------------------
    * Slide to bottom on [action] - e.g. [message received, sent, loaded]
    *-------------------------------------------------------------
    */
    function scrollToBottom(container) {
        $(container)
            .stop()
            .animate({
            scrollTop: $(container)[0].scrollHeight,
            });
    }

    
    /**
     *-------------------------------------------------------------
    * Cancel file attached in the message.
    *-------------------------------------------------------------
    */
    function cancelAttachment() {
        $(".messenger-sendCard").find(".attachment-preview").remove();
        $(".upload-attachment").replaceWith(
            $(".upload-attachment").val("").clone(true)
        );
    }


    let contactsPage = 1;
    let contactsLoading = false;
    let noMoreContacts = false;

    function setContactsLoading(loading = false) {
        if (!loading) {
            $(".listOfContacts").find(".loading-contacts").remove();
        } else {
            $(".listOfContacts").append(
            `<div class="loading-contacts">${listItemLoading(4)}</div>`
            );
        }
        contactsLoading = loading;
    }

    function getChatContacts() {
        if (!contactsLoading && !noMoreContacts) {
            setContactsLoading(true);
            $.ajax({
                url: chat_baseurl + "member-messanger-contacts",
                method: "POST",
                data: { _token: access_token, page: contactsPage },
                dataType: "JSON",
                success: (response) => {
                    console.log(response);

                    setContactsLoading(false);

                    if(response.status = 1){

                        if(response.data.list.length > 0){
             
                            var list_html = getContactsUIHtml(response.data.list);
                            allContactsList = response.data.list;
                            $(".listOfContacts").html(list_html);

                        }else{
                            $(".listOfContacts").html('<p class="message-hint center-el"><span>Your contact list is empty</span></p>');
                        }
                    }

                    updateSelectedContact();
                    // Pagination lock & messages page
                    noMoreContacts = true;
                    // noMoreContacts = contactsPage >= data?.last_page;
                    // if (!noMoreContacts) contactsPage += 1;
                },
                error: (error) => {
                    setContactsLoading(false);
                    console.error(error);
                },
            });
        }
    }

    function getContactsUIHtml(contacts) {

        var html = '';

        if(contacts.length > 0){

            $.each(contacts, function (i, val) { 
                
                html += '<table class="messenger-list-item" data-contact="" data-room-id="'+val.chat_room_id+'">';
                html += '    <tbody>';
                html += '       <tr data-action="0">';
                html += '            <td style="position: relative">';
                html += '               <div class="avatar av-m" style="background-image: url({{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }});"></div>';
                html += '            </td>';
                html += '            <td>';
                html += '                <p data-id="3" data-type="user">'+(val.receiver_name)+'<span>'+(val.last_message_on != null ? convertUtcDateTimeToLocalDateTime(val.last_message_on) : '')+'</span></p>';
                html += '                <span class="lastMessageIndicator">'+(val.last_message != null ? val.last_message : '')+'</span>';
                html += '            </td>';
                html += '        </tr>';
                html += '    </tbody>';
                html += '</table>';

            });
    
        }

        return html;
    }
    
    function updateSelectedContact(room_id='') {

        $(document).find(".messenger-list-item").removeClass("m-list-active");
        $(document)
            .find(".messenger-list-item[data-room-id='" + (room_id || selectedRoomId) + "']")
            .addClass("m-list-active");

    }

    
    let messagesPage = 1;
    let noMoreMessages = false;
    let messagesLoading = false;

    function fetchChatRoomMessages(room_id, newFetch = false) {
        if (newFetch) {
            messagesPage = 1;
            noMoreMessages = false;
        }
        if (messenger != 0 && !noMoreMessages && !messagesLoading) {
            const messagesElement = messagesContainer.find(".messages");
            // setMessagesLoading(true);
            $.ajax({
                url: chat_baseurl + "member-messanger-room-messages",
                method: "POST",
                data: {
                    _token: access_token,
                    chat_room_id: room_id,
                    // type: type,
                    page: messagesPage,
                },
                dataType: "JSON",
                success: (response) => {
                    // setMessagesLoading(false);
                    if (messagesPage == 1) {
                        
                        // render messages data
                        var chat_container_html = getChatMessagesUI(response.data.list.length > 0 ? response.data.list.reverse() : response.data.list);
                        messagesElement.html(chat_container_html);
                        scrollToBottom(messagesContainer);

                    } else {
                        const lastMsg = messagesElement.find(
                        messagesElement.find(".message-card")[0]
                    );
                    const curOffset =
                        lastMsg.offset().top - messagesContainer.scrollTop();
                        messagesElement.prepend(response.messages);
                        messagesContainer.scrollTop(lastMsg.offset().top - curOffset);
                    }
                    // trigger seen event
                    // makeSeen(true);
                    // Pagination lock & messages page
                    noMoreMessages = messagesPage >= response.data.total;
                    if (!noMoreMessages) messagesPage += 1;
                    // Enable message form if messenger not = 0; means if data is valid
                    if (messenger != 0) {
                        disableOnLoad(false);
                    }
                },
                error: (error) => {
                    // setMessagesLoading(false);
                    console.error(error);
                },
            });
        }
    }

        
    function loadActiveContactChat(room_id) {

        // clear temporary message id
        temporaryMsgId = 0;
        // clear typing now
        typingNow = 0;

        // disable message form        
        disableOnLoad();

        var room_dtls = getDetailsFromObjectByKey(allContactsList, room_id, 'chat_room_id');
        console.log("room details - ", room_dtls);

        if(room_dtls != undefined){

            $("#message-form input[name='receiver_id']").val(room_dtls.receiver_id);
            $("#message-form input[name='receiver_user']").val(room_dtls.receiver_user);

            // avatar photo
            $(".messenger-infoView")
                .find(".avatar")
                .css("background-image", "url({{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }})");

            $(".header-avatar").css(
                "background-image",
                "url({{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }})"
            );

            // Show shared and actions
            $(".messenger-infoView-btns .delete-conversation").show();
            $(".messenger-infoView-shared").show();

            // fetch messages
            fetchChatRoomMessages(room_id, true);
            // focus on messaging input
            messageInput.focus();
            // update info in view
            $(".messenger-infoView .info-name").html(room_dtls.receiver_name);
            $(".m-header-messaging .user-name").html(room_dtls.receiver_name);
            // Star status

            // form reset and focus
            $("#message-form").trigger("reset");
            // cancelAttachment();
            messageInput.focus();
            
            disableOnLoad(false);

        }
        
    }
    
    // While sending a message, show this temporary message card.
    function sendTempMessageCard(message, id) {
        console.log("message", message);
        return `
        <div class="message-card mc-sender" data-message-id="" data-room-id="${id}" >
            <p>
                ${message}
                <sub>
                    <span class="far fa-clock"></span>
                </sub>
            </p>
        </div>
        `;
    }

    // Chat messages UI.
    function getChatMessagesUI(list) {
        console.log("list ", list);
        var html = '';

        if(list.length > 0){

            $.each(list, function (i, val) { 
                
                html += '<div class="message-card '+(val.sender_user == auth_user_type ? " mc-sender": "")+'" data-room-id="'+val.chat_room_id+'"  data-message-id="'+val.chat_message_id+'">';
                html +='     <div class="'+(val.sender_user == auth_user_type ? "chatify-d-flex chatify-align-items-center" : "")+'" style="'+(val.sender_user == auth_user_type ? "flex-direction: row-reverse; justify-content: flex-end;" : "")+'">';
                html +='        <p style="'+(val.sender_user == auth_user_type ? "margin-left: 5px;" : "")+'">'+val.message+'<sub>'+convertUtcDateTimeToLocalDateTime(val.created_at)+'</sub></p>';
                html +='     </div>';
                html +='</div>';
            
            });
        }

        return html;
    }


    /**
     *-------------------------------------------------------------
    * Error message card
    *-------------------------------------------------------------
    */
    function errorMessageCard(id) {
        messagesContainer
            .find(".message-card[data-id=" + id + "]")
            .addClass("mc-error");
        messagesContainer
            .find(".message-card[data-id=" + id + "]")
            .find("svg.loadingSVG")
            .remove();
        messagesContainer
            .find(".message-card[data-id=" + id + "] p")
            .prepend('<span class="fas fa-exclamation-triangle"></span>');
    }

    /**
     *-------------------------------------------------------------
    * Send message function
    *-------------------------------------------------------------
    */
    function sendMessage() {

        temporaryMsgId += 1;
        let temp_id = `temp_${temporaryMsgId}`;
        let hasFile = !!$(".upload-attachment").val();
        const inputValue = $.trim(messageInput.val());
        
        if (inputValue.length > 0 || hasFile) {
            
            const formData = new FormData();
            formData.append("chat_room_id", selectedRoomId);
            formData.append("message", $("#message-form textarea[name='message']").val());
            formData.append("temp_id", temp_id);
            formData.append("type", $("#message-form input[name='type']").val());
            formData.append("receiver_id", $("#message-form input[name='receiver_id']").val());
            formData.append("receiver_user", $("#message-form input[name='receiver_user']").val());
            formData.append("_token", access_token);
            
            $.ajax({
                url: $("#message-form").attr("action"),
                method: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: () => {
                    // remove message hint
                    $(".messages").find(".message-hint").remove();
                    // append a temporary message card
                    if (hasFile) {
                        messagesContainer
                            .find(".messages")
                            .append(
                            sendTempMessageCard(
                                inputValue + "\n" + loadingSVG("28px"),
                                temp_id
                            ));
                    } else {
                        messagesContainer
                            .find(".messages")
                            .append(sendTempMessageCard(inputValue, temp_id));
                    }
                    // scroll to bottom
                    scrollToBottom(messagesContainer);
                    messageInput.css({ height: "42px" });
                    // form reset and focus
                    $("#message-form").trigger("reset");
                    cancelAttachment();
                    messageInput.focus();
                },
                success: (response) => {
                    console.log(response);
                    // return;
                    if (response.status == 0) {
                        // message card error status
                        errorMessageCard(temp_id);
                        console.error(response.message);
                    } else {
                        // update contact item
                        updateContactItem(selectedRoomId, response.data);
                        
                        // temporary message card
                        const tempMsgCardElement = messagesContainer.find(".message-card[data-room-id='"+response.data.temp_id+"']");

                        // add the message card coming from the server before the temp-card
                        tempMsgCardElement.before(getChatMessagesUI([response.data]));
                        // then, remove the temporary message card
                        tempMsgCardElement.remove();
                        // scroll to bottom
                        scrollToBottom(messagesContainer);
                        // send contact item updates
                        sendContactItemUpdates(true);
                    }
                },
                error: () => {
                    // message card error status
                    errorMessageCard(temp_id);
                    // error log
                    console.error(
                    "Failed sending the message! Please, check your server response."
                    );
                },
            });
        }
        return false;
    }

    /**
     *-------------------------------------------------------------
    * Update contact item
    *-------------------------------------------------------------
    */
    function updateContactItem(room_id, message_dtls) {

        let listItem = $("body")
                        .find(".listOfContacts")
                        .find(".messenger-list-item[data-room-id=" + room_id + "]");

        const totalContacts = $(".listOfContacts").find(".messenger-list-item")?.length || 0;
        if (totalContacts < 1)
            $(".listOfContacts").find(".message-hint").remove();
        listItem.remove();

        var first_contact_ui = getContactsUIHtml([message_dtls]);        
        $(".listOfContacts").prepend(first_contact_ui);
        updateSelectedContact(room_id);
    }

    $(document).ready(function () {
    
        // set item active on click
        $("body").on("click", ".messenger-list-item", function () {
            
            const dataView = $(".messenger-list-item")
                            .find("p[data-type]")
                            .attr("data-type");

            $(".messenger-list-item").removeClass("m-list-active");
            
            $(this).addClass("m-list-active");
            
            const roomId = $(this).attr("data-room-id");
            
            updateSelectedContact(roomId);

            selectedRoomId = roomId;

            loadActiveContactChat(roomId);
            
        });
        
        // message form on submit.
        $("#message-form").on("submit", (e) => {
            e.preventDefault();
            sendMessage();
        });
        
        // get contacts list
        getChatContacts();
    
    });

</script>