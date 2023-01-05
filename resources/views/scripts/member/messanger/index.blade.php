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
        allContactsList=[]
        attachmentFiles=[];

    var imgExtArray = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
    var pdfExtArray = ['pdf'];
    var docExtArray = ['docx','doc'];
    var pdfImage = "{{asset('common/images/pdf.png')}}";
    var docImage = "{{asset('common/images/doc.png')}}";
    
    const messagesContainer = $(".messenger-messagingView .m-body"),
        messengerTitleDefault = $(".messenger-headTitle").text(),
        messageInput = $("#message-form .m-send"),
        defaultMessengerColor = "#2180f3",
        access_token = $('meta[name="csrf-token"]').attr("content");

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

    // Listen to messages, and append if data received
    channel.bind("messaging", function (data) {

        if(data.chat_room_dtls != undefined && data.chat_room_dtls != ''){

            if(data.chat_room_id == selectedRoomId && data.message_obj != undefined && data.message_obj != '' && data.message_obj.receiver_user == auth_user_type && data.message_obj.receiver_id == auth_id) {
            
                $(".messages").find(".message-hint").remove();
            
                messagesContainer.find(".messages").append(getChatMessagesUI([data.message_obj]));
            
                scrollToBottom(messagesContainer);

                // update contact item
                updateContactItem(data.chat_room_id, data.message_obj);
                getChatContacts(selectedRoomId);
                makeSeen(selectedRoomId);

            }else{

                if((data.chat_room_dtls.sender_user == auth_user_type && data.chat_room_dtls.sender_id == auth_id) || (data.chat_room_dtls.receiver_user == auth_user_type && data.chat_room_dtls.receiver_id == auth_id)){

                    getChatContacts(selectedRoomId);

                }
            }
        }

    });

    
    // listen to contact item updates event
    channel.bind("client-contactItem", function (data) {
        if (data.update_for == auth_id) {
            data.updating == true
            ? updateContactItem(data.update_to)
            : console.error("[Contact Item updates] Updating failed!");
        }
    });

        
    /**
     *-------------------------------------------------------------
    * Trigger contact item updates
    *-------------------------------------------------------------
    */
    function sendContactItemUpdates(status) {
        return channel.trigger("client-contactItem", {
            update_for: selectedRoomId, // Messenger
            update_to: auth_id, // Me
            updating: status,
        });
    }

    
    /**
     *-------------------------------------------------------------
    * Trigger seen event
    *-------------------------------------------------------------
    */
    function makeSeen(chat_room_id) {
        
        // seen
        $.ajax({
            url: chat_baseurl + "member-messanger-read",
            method: "POST",
            data: { _token: access_token, chat_room_id: chat_room_id },
            dataType: "JSON",
            success: (response) => {
                if(response.status){
                    // remove unseen counter for the user from the contacts list
                    $(".messenger-list-item[data-room-id=" + chat_room_id + "]").find(".chat-badge").remove();
                }
            }
        });
    }

    function disableOnLoad(action = true) {

        if (action == true) {

            // hide send card
            $(".messenger-sendCard").hide();
            // add loading opacity to messages container
            messagesContainer.css("opacity", ".5");
            // disable message form fields
            messageInput.attr("readonly", "readonly");
            $("#message-form a").attr("disabled", "disabled");
            $(".upload-attachment").attr("disabled", "disabled");
        } else {
            
            // show send card
            $(".messenger-sendCard").show();
            // remove loading opacity to messages container
            messagesContainer.css("opacity", "1");
            // enable message form fields
            messageInput.removeAttr("readonly");
            
            $("#message-form a").removeAttr("disabled");
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
    * Cancel file attached in the message.
    *-------------------------------------------------------------
    */
    function cancelAttachment() {

        attachmentFiles = [];
        $('#attachment_container').html('');
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

    function getChatContacts(selected_chatroom_id='') {

        setContactsLoading(true);
        
        $.ajax({
            url: chat_baseurl + "member-messanger-contacts",
            method: "POST",
            data: { _token: access_token, page: contactsPage },
            dataType: "JSON",
            success: (response) => {

                setContactsLoading(false);

                if(response.status = 1){

                    if(response.data.list.length > 0){
            
                        var list_html = getContactsUIHtml(response.data.list);
                        allContactsList = response.data.list;
                        $(".listOfContacts").html(list_html);

                        // render first contact chat
                        if(allContactsList.length > 0){

                            if(selected_chatroom_id != ''){

                                // $('.messenger-list-item[data-room-id="'+selected_chatroom_id+'"]').click();

                            }else{
                                $('.messenger-list-item[data-room-id="'+allContactsList[0].chat_room_id+'"]').click();
                            }

                            $('#chat-section').show();
                        }else{
                            $('#chat-section').hide();
                        }

                    }else{
                        $(".listOfContacts").html('<p class="message-hint center-el text-center"><span>Your contact list is empty</span></p>');
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

    function getContactsUIHtml(contacts) {

        var html = '';

        if(contacts.length > 0){

            $.each(contacts, function (i, val) { 
                
                html += '<li class="messenger-list-item my-1" data-receiver-id="'+val.receiver_id+'" data-receiver-user="'+val.receiver_user+'"  data-room-id="'+val.chat_room_id+'">';
                html += '   <span class="d-flex justify-content-between m-1">';
                html += '       <div class="d-flex flex-row">';
                html += '           <div class="">';
                
                var receiver_profile = val.receiver_profile != null ?  ( val.receiver_user == "stylist" ? '' : asset_url+'{{ config('custom.media_path_prefix.member') }}' )+val.receiver_profile : '{{asset('common/images/default_user.jpeg')}}';
                   
                html += '               <img src="'+receiver_profile+'" alt="avatar" class="d-flex align-self-center me-3 chat-pic" width="60">';
                html += '               <span class="badge '+(val.receiver_online == 1 ? 'bg-success' : 'bg-danger')+' badge-dot online-status" data-online="'+val.receiver_online+'"></span>';
                html += '           </div>';
                html += '           <div class=" pl-1">';
                html += '                   <span class="list-name">'+(val.receiver_name)+'</span>';
                if(val.room_last_message != '' && val.room_last_message != null){

                    var msg_obj = val.room_last_message;
                    
                    if(msg_obj.type == "file"){

                        var files_array = JSON.parse(msg_obj.files);
                        html +=             '<p class="list-msg"><i class="fa fa-file" aria-hidden="true"></i></p>';
                        
                    }else{
                        html += '           <p class="list-msg">'+(msg_obj.message != null ? msg_obj.message : '')+'</p>';
                    }
                }
                html += '               </div>';
                html += '           </div>';
                html += '       </div>';
                html += '       <div class="">';
                if(val.room_last_message != '' && val.room_last_message != null){

                    var msg_obj = val.room_last_message;
                    html += '           <p class="small text-muted mb-1 list-time">'+(msg_obj.created_at != null ? convertUtcDateTimeToLocalDateTime(msg_obj.created_at) : '')+'</p>';

                }
                if(val.unread_count > 0){
                    html += '           <span class="chat-badge">'+val.unread_count+'</span>';
                }
                html += '       </div>';
                html += '   </span>';
                html += '</li>';
                
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

    // Loading svg
    function loadingSVG(size = "25px", className = "", style = "") {
        return `
            <svg style="${style}" class="loadingSVG ${className}" xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 40 40" stroke="#ffffff">
            <g fill="none" fill-rule="evenodd">
            <g transform="translate(2 2)" stroke-width="3">
            <circle stroke-opacity=".1" cx="18" cy="18" r="18"></circle>
            <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(349.311 18 18)">
            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur=".8s" repeatCount="indefinite"></animateTransform>
            </path>
            </g>
            </g>
            </svg>
        `;
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
                        
                        var parent_room_dtls = getDetailsFromObjectByKey(allContactsList, room_id, 'chat_room_id');
                        // render messages data
                        var chat_container_html = getChatMessagesUI(response.data.list.length > 0 ? response.data.list.reverse() : response.data.list, parent_room_dtls);
                        messagesElement.html(chat_container_html);
                        scrollToBottom(messagesContainer);

                    } else {
                        const lastMsg = messagesElement.find(messagesElement.find(".message-card")[0]);
                        const curOffset =
                            lastMsg.offset().top - messagesContainer.scrollTop();
                            messagesElement.prepend(response.messages);
                            messagesContainer.scrollTop(lastMsg.offset().top - curOffset);
                    }
                    
                    // trigger seen event
                    makeSeen(room_id);

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
        
        if(room_dtls != undefined){

            $("#message-form input[name='receiver_id']").val(room_dtls.receiver_id);
            $("#message-form input[name='receiver_user']").val(room_dtls.receiver_user);

            // // avatar photo
            // $(".messenger-infoView")
            //     .find(".avatar")
            //     .css("background-image", "url({{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }})");

            // $(".header-avatar").css(
            //     "background-image",
            //     "url({{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }})"
            // );

            // Show shared and actions
            // $(".messenger-infoView-btns .delete-conversation").show();
            // $(".messenger-infoView-shared").show();

            // fetch messages
            fetchChatRoomMessages(room_id, true);

            // focus on messaging input
            messageInput.focus();
            // update info in view
            // $(".messenger-infoView .info-name").html(room_dtls.receiver_name);
            $(".active-chat-box-user-name").html(room_dtls.receiver_name);
            $('.active-chat-box-online-status').data('receiver-id', room_dtls.receiver_id);
            $('.active-chat-box-online-status').data('receiver-user', room_dtls.receiver_user);
            $('.active-chat-box-online-status').removeClass('dot-online');
            $('.active-chat-box-online-status').removeClass('dot-offline');
            var is_online = $('.messenger-list-item[data-receiver-id="'+room_dtls.receiver_id+'"][data-receiver-user="'+room_dtls.receiver_user+'"]').find('.online-status').data('online');
            $('.active-chat-box-online-status').addClass( is_online == 1 ? 'dot-online' : 'dot-offline');
            
            // Star status

            // form reset and focus
            $("#message-form").trigger("reset");
            cancelAttachment();
            messageInput.focus();
            disableOnLoad(false);

        }
        
    }
    
    // While sending a message, show this temporary message card.
    function sendTempMessageCard(message, id) {

        var html = '';

        html += '<div class="row justify-content-end mx-2 mt-2 message-card" data-room-id="'+id+'">';
        html += '   <div class="d-flex">';
        // html += '       <div class="card ml-1" style="background: #e9f4ff;width: 50rem;">';
        html += '       <div class="card ml-1" style="background: #e9f4ff;width: 50vw;">';
        html += '           <div class="card-header d-flex justify-content-between p-1" style="border-bottom: 1px solid;">';
        html += '               <p class="fw-bold mb-0 chat-client-name">'+auth_name+'</p>';
        html += '               <p class="small mb-0 chat-client-time"><i class="far fa-clock"></i>'+convertUtcDateTimeToLocalDateTime(new Date())+'</p>';
        html += '           </div>';
        html += '           <div class="card-body">';
        html += '               <p class="mb-0">'+message+'</p>';
        html +='            </div>';
        html +='        </div>';
        html += '       <img src="'+(auth_profile != '' ? auth_profile : asset_url+'{{asset('common/images/default_user.jpeg')}}')+'" class="chat-pic ml-1" alt="Avatar">';                    
        html +='    </div>';
        html +='</div>';

        return html;
    }

    // upload image preview card.
    function attachmentTemplate(fileType, fileName, imgURL = null, index='') {
        
        var html = '';

        if (fileType != "image") {
            
            html += '<div class="attachment-preview mr-1" data-index="'+index+'">';
            html += '   <span class="fas fa-times remove-attachment" data-index="'+index+'"></span>';
            // html += '   <p style="padding:0px 30px;">';
            // html += '       <span class="fas fa-file"></span>';
            // html +=         escapeHtml(fileName) +'</p>';
            html += '</div>';

        } else {

            html += '<div class="attachment-preview mr-1" data-index="'+index+'">';
            html += '   <span class="fas fa-times remove-attachment" data-index="'+index+'"></span>';

            if ($.inArray(fileName.substr( (fileName.lastIndexOf('.') +1) ), imgExtArray) != -1) {
                html += '   <img class="image-file chat-image-preview" src="' +imgURL +'">';
            }else if ($.inArray(fileName.substr( (fileName.lastIndexOf('.') +1) ), pdfExtArray) != -1) {
                html += '   <img class="image-file chat-doc-preview" src="' +pdfImage +'">';
            }else{
                html += '   <img class="image-file chat-doc-preview" src="' +docImage +'">';
            }

            // html += '   <p><span class="fas fa-file"></span>'+escapeHtml(fileName) +'</p>';
            html += '</div>';

        }
        
        return html;

    }

    // Chat messages UI.
    function getChatMessagesUI(list, room_dtls) {

        var html = '';

        if(list.length > 0){

            $.each(list, function (i, val) { 
                
                html += '<div class="row justify-content-'+(val.sender_id == auth_id && val.sender_user == auth_user_type ? "end" : "start")+' mx-2 mt-2 message-card"  data-room-id="'+val.chat_room_id+'" data-message-id="'+val.chat_message_id+'">';
                html += '   <div class="d-flex">';

                if((val.sender_id == auth_id && val.sender_user == auth_user_type) == false){
                    // message from receiver
                    var receiver_profile = val.sender_profile != null ? ( val.sender_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+val.sender_profile : '{{asset('common/images/default_user.jpeg')}}';
                    html += '   <img src="'+receiver_profile+'" class="chat-pic mr-1" alt="Avatar">';                    
                }

                // html += '       <div class="card'+(val.sender_id == auth_id && val.sender_user == auth_user_type ? "  ml-1" : "")+'" style="background: #e9f4ff;width: 50rem;">';
                html += '       <div class="card'+(val.sender_id == auth_id && val.sender_user == auth_user_type ? "  ml-1" : "")+'" style="background: #e9f4ff;width: 50vw;">';
                html += '           <div class="card-header d-flex justify-content-between p-1" style="border-bottom: 1px solid;">';
                html += '               <p class="fw-bold mb-0 chat-client-name">'+val.sender_name+'</p>';
                html += '               <p class="small mb-0 chat-client-time"><i class="far fa-clock"></i>&nbsp;'+convertUtcDateTimeToLocalDateTime(val.created_at)+'</p>';
                html += '           </div>';
                html += '           <div class="card-body">';

                if(val.type == "file"){

                    var files_array = JSON.parse(val.files);
            
                    if(files_array.length > 1){
                        html += "<div class='text-right'><a href='#' class='download-all-btn' data-files='"+val.files+"'><i class='fas fa-download'></i>&nbsp;Download All</a></div>";
                    }
                        
                    if(files_array.length > 0){

                        html += '      <div class="row">';

                            $.each(files_array, function (m_key, m_val) { 

                                if(m_val.media_path != ''){
                                
                                    html += '<div class="chat-media-box m-1">';
                                    html += '   <div style="position:relative;">';    
                                    if ($.inArray(m_val.media_name.substr( (m_val.media_name.lastIndexOf('.') +1) ), imgExtArray) != -1) {
                                    
                                        html += '   <img src="'+m_val.media_path+'" data-path="'+m_val.media_path+'" class="chat-media" />'; 
                                        html += '   <span class="fas fa-download download-attachment" data-index="'+m_key+'" data-path="'+m_val.media_path+'" data-file-name="'+m_val.media_name+'"></span>';
                                    
                                    }else if ($.inArray(m_val.media_name.substr( (m_val.media_name.lastIndexOf('.') +1) ), pdfExtArray) != -1) {
                                        
                                        html += '   <img src="'+pdfImage+'" data-path="'+m_val.media_path+'" class="chat-media-doc" / >'; 
                                        html += '   <span class="fas fa-download download-attachment-doc" data-index="'+m_key+'" data-path="'+m_val.media_path+'"  data-file-name="'+m_val.media_name+'"></span>';
                                    
                                    }else{
                                    
                                        html += '   <img src="'+docImage+'" data-path="'+m_val.media_path+'" class="chat-media-doc" />';
                                        html += '   <span class="fas fa-download download-attachment-doc" data-index="'+m_key+'" data-path="'+m_val.media_path+'"  data-file-name="'+m_val.media_name+'"></span>';
                                    
                                    }
                                    
                                    html += '   </div>';

                                    html += '</div>';
                                }
                            });

                        html += '      </div>';
                    }

                }else{
                    html += '           <p class="mb-0">'+val.message+'</p>';
                }

                html +='            </div>';
                html +='        </div>';
                
                if(val.sender_id == auth_id && val.sender_user == auth_user_type){
                    
                    // Sender user

                    var sender_profile = val.sender_profile != null ? ( val.sender_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+val.sender_profile : '{{asset('common/images/default_user.jpeg')}}';              
                    html += '   <img src="'+sender_profile+'" class="chat-pic ml-1" alt="Avatar">';                    

                }
                html +='    </div>';
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
        let hasFile = attachmentFiles.length > 0 ? true : false;
        const inputValue = $.trim(messageInput.val());
        
        if (inputValue.length > 0 || hasFile) {
            
            const formData = new FormData();
            formData.append("chat_room_id", selectedRoomId);
            formData.append("message", $("#message-form textarea[name='message']").val());
            formData.append("temp_id", temp_id);
            formData.append("media_files", JSON.stringify(attachmentFiles));
            formData.append("type", hasFile ? 'file' : 'text');
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
                    // form reset and focus
                    $("#message-form").trigger("reset");
                    cancelAttachment();
                    messageInput.focus();
                },
                success: (response) => {
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

    
    function attachmentValidate(file) {
       
       const { name: fileName, size: fileSize } = file;
       const fileExtension = fileName.split(".").pop();
       if (
           !getAllowedExtensions.includes(fileExtension.toString().toLowerCase())
       ) {
           showErrorMessage('file type not allowed');
           return false;
       }
       // Validate file size.
       if (fileSize > getMaxUploadSize) {
           showErrorMessage("File is too large. Maximum size for each file uploads is {{ config('chat.attachments.max_upload_size') }} MB.");
           return false;
       }
       return true;
   }
    
    function getAttachmentMaxIndexCount() {
            
        var items_index_array = [];
    
        $(".attachment-preview").each(function (key, val) {
            items_index_array.push($(this).data('index'));
        });
    
        var max_item_count = 0;
    
        if(items_index_array.length > 0){
            max_item_count = Math.max.apply(Math,items_index_array); 
        }
        return max_item_count;
    };
    
    function generateZIP(links) {
           
        var zip = new JSZip();
        var count = 0;

        var zip_title = new Date().toISOString().replace(/\D/g,"").substr(0,14);

        var zipFilename = '{{ env("APP_NAME") }}'+'_'+ zip_title+ ".zip";

        links.forEach(function (obj, i) {

            var filename = obj.media_name;
            // loading a file and add it in a zip file
            JSZipUtils.getBinaryContent(obj.media_path, function (err, data) {
                if (err) {
                    throw err; // or handle the error
                }
                zip.file(filename, data, { binary: true });
                count++;
                if (count == links.length) {
                    zip.generateAsync({ type: 'blob' }).then(function (content) {
                        saveAs(content, zipFilename);
                    });
                }
            });
        });
    };
        
    $(document).ready(function () {
    
        // set item active on click
        $("body").on("click", ".messenger-list-item", function () {
            
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

        $('body').on('click','.send-msg-btn',function(e){
            e.preventDefault();
            sendMessage();
        });
        
        $("#message-form textarea[name='message']").keypress(function (e) {
            if(e.which === 13 && !e.shiftKey) {
                e.preventDefault();            
                sendMessage();
            }
        });

        
        $('body').on('click','.remove-attachment',function(e){
            e.preventDefault();

            var index = $(this).data('index');

            if(index != undefined && index != ''){

                var obj_item_index = attachmentFiles.findIndex(x => x.id == index);
    
                if(obj_item_index != -1){

                    attachmentFiles.splice(obj_item_index, 1);

                }

                $('.attachment-preview[data-index="'+index+'"]').remove();

            }

        });

        $('body').on('click', '.download-attachment, .download-attachment-doc',function(e){
            e.preventDefault();
            var url = $(this).data('path');
            downloadFromUrl(url, $(this).data('file-name'));
        });

        $('body').on('click', '.download-all-btn',function(e){
            e.preventDefault();

            var files_json = $(this).data('files');
            generateZIP(files_json);

        });

        // On [upload attachment] input change, show a preview of the image/file.
        
        $("body").on("change", ".upload-attachment", (e) => {

            if (e.target.files) {

                let total_selected_files = e.target.files.length;

                if(attachmentFiles.length >= 5){
                    showErrorMessage("You can only upload a maximum of 5 files");
                    return false;
                }

                if(total_selected_files > 5){
                    showErrorMessage("You can only upload a maximum of 5 files");
                }

                if(attachmentFiles.length > 5){
                    total_selected_files = 0;
                }else{
                    total_selected_files = attachmentFiles.length > 0 ? (5 - attachmentFiles.length) : (total_selected_files >= 5 ? 5 : total_selected_files); 
                }

                for (i = 0; i < total_selected_files; i++) {

                    let file = e.target.files[i];

                    if (!attachmentValidate(file)){
                        return false;
                    }

                    var reader = new FileReader();

                    reader.onload = function(event) {

                        var index = (getAttachmentMaxIndexCount()+1);
                        
                        attachmentFiles.push({
                            'id' : index,
                            'media_source' : event.target.result,
                            'media_name' : file.name,
                            'file_formate' : file.name.split(".").pop().toString().toLowerCase()
                        });

                        $('#attachment_container').append(attachmentTemplate("image", file.name, event.target.result, index));

                    }

                    reader.readAsDataURL(file);
   
                }
                
            }
        });
        
        // get contacts list
        getChatContacts();
    
    });

</script>