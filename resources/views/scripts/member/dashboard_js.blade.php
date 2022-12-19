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
        DashboardRef.messagesContainer = $("#dashboard_chat_box");
        DashboardRef.messageInput = $("#dashboard-message-form .m-send"),
        DashboardRef.attachmentFiles=[];
        DashboardRef.temporaryMsgId = 0;
        DashboardRef.imgExtArray = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        DashboardRef.pdfExtArray = ['pdf'];
        DashboardRef.docExtArray = ['docx','doc'];
        DashboardRef.pdfImage = "{{asset('common/images/pdf.png')}}";
        DashboardRef.docImage = "{{asset('common/images/doc.png')}}";
        
        DashboardRef.loadActiveContactChat = function(room_id) {

            if(room_id != undefined && room_id != null && room_id != ''){

                // fetch messages
                DashboardRef.fetchChatRoomMessages(room_id, true);

                // form reset and focus
                $("#dashboard-message-form").trigger("reset");
                DashboardRef.cancelAttachment();
                DashboardRef.messageInput.focus();
            }
        }
    
        DashboardRef.fetchChatRoomMessages = function(room_id, newFetch = false) {

            // disable message form        
            DashboardRef.disableOnLoad();

            showSpinner('#dashboard_chat_box');

            $.ajax({
                url: chat_baseurl + "member-messanger-room-messages",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    chat_room_id: room_id
                },
                dataType: "JSON",
                success: (response) => {
                                
                    hideSpinner('#dashboard_chat_box');

                    if(response.status = 1){
                    
                        // render messages data
                        var chat_container_html = DashboardRef.getChatMessagesUI(response.data.list.length > 0 ? response.data.list.reverse() : response.data.list);
                        
                        DashboardRef.messagesContainer.html(chat_container_html);
                        
                        scrollToBottom(DashboardRef.messagesContainer);

                        // trigger seen event
                        DashboardRef.makeSeen(room_id);

                    }
                    
                    // enable message form        
                    DashboardRef.disableOnLoad(false);

                },
                error: (error) => {
                    hideSpinner('#dashboard_chat_box');
                    console.error(error);
                },
            });
        }

        
        /**
        *-------------------------------------------------------------
        * Trigger seen event
        *-------------------------------------------------------------
        */
        DashboardRef.makeSeen = function(chat_room_id) {
            
            // seen
            $.ajax({
                url: chat_baseurl + "member-messanger-read",
                method: "POST",
                data: { _token: $('meta[name="csrf-token"]').attr("content"), chat_room_id: chat_room_id },
                dataType: "JSON",
                success: (response) => {
                    if(response.status){
                        // remove unseen counter for the user from the contacts list
                        // $(".messenger-list-item[data-room-id=" + chat_room_id + "]").find(".chat-badge").remove();
                    }
                }
            });
        }
        
        // Chat messages UI.
        DashboardRef.getChatMessagesUI = function(list) {

            var html = '';

            if(list.length > 0){

                $.each(list, function (i, val) { 
                    
                    html += '<div class="row mt-1 message-card"  data-room-id="'+val.chat_room_id+'" data-message-id="'+val.chat_message_id+'">';
                   
                    if(val.sender_user != auth_user_type){

                        var receiver_profile = val.sender_profile != null ?  ( val.sender_user == "stylist" ? '' : asset_url+'{{ config('custom.media_path_prefix.member') }}' )+val.sender_profile : '{{asset('common/images/default_user.jpeg')}}';
                    
                        html += '   <div class="col-lg-2 col-1 d-flex align-items-center">';
                        html += '       <img src="'+receiver_profile+'" class="avtar_35" alt="Avatar">';                    
                        html += '   </div>';
                    }

                    html += '       <div class=" col-10 '+(val.sender_user == auth_user_type ? "pr-0 pl-md-5" : "pr-5 pl-md-0")+'">';
                    html += '           <div class="'+(val.sender_user == auth_user_type ? "text-left" : "text-right")+'"><small class="text-dark">'+convertUtcDateTimeToLocalDateTime(val.created_at)+'</small></div>';
                    html += '           <div class="container '+(val.sender_user == auth_user_type ? "darker" : "")+'">';
                    
                    if(val.type == "file"){

                        var files_array = JSON.parse(val.files);

                        if(files_array.length > 0){

                            html += '      <div class="row">';

                                $.each(files_array, function (m_key, m_val) { 

                                    if(m_val.media_path != ''){

                                        // html += '   <img src="'+m_val.media_path+'" class="dashboard-chat-media">';                    
                                        html += '<div class="chat-media-box m-0">';
                                        html += '   <div style="position:relative;">';    
                                        if ($.inArray(m_val.media_name.substr( (m_val.media_name.lastIndexOf('.') +1) ), DashboardRef.imgExtArray) != -1) {
                                        
                                            html += '   <img src="'+m_val.media_path+'" data-path="'+m_val.media_path+'" class="dashboard-chat-media" />'; 
                                           
                                        }else if ($.inArray(m_val.media_name.substr( (m_val.media_name.lastIndexOf('.') +1) ), DashboardRef.pdfExtArray) != -1) {
                                            
                                            html += '   <img src="'+DashboardRef.pdfImage+'" data-path="'+m_val.media_path+'" class="dashboard-chat-doc-media" / >'; 
                                           
                                        }else{
                                        
                                            html += '   <img src="'+DashboardRef.docImage+'" data-path="'+m_val.media_path+'" class="dashboard-chat-doc-media" />';
                                           
                                        }
                                        
                                        html += '   </div>';

                                        html += '</div>';
                                    }

                                });

                            html += '      </div>';
                        }

                    }else{
                        html += '           <p class="pt-1">'+val.message+'</p>';
                    }

                    html += '           </div>';
                    html += '       </div>';
 
                    if(val.sender_user == auth_user_type){

                        var sender_profile = auth_profile != '' ? ( auth_user_type == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+auth_profile : '{{asset('common/images/default_user.jpeg')}}';                    
                        html += '   <div class="col-lg-2 col-1 d-flex align-items-center">';
                        html += '       <img src="'+sender_profile+'" class="avtar_35" alt="Avatar">';                    
                        html += '   </div>';
                    }
                    html +='</div>';
    
                });
            }

            return html;
        }

        DashboardRef.disableOnLoad = function(action = true) {
            
            if (action == true) {

                // hide send card
                $(".dashboard-messenger-sendCard").hide();
                // add loading opacity to messages container
                DashboardRef.messagesContainer.css("opacity", ".5");
                // disable message form fields
                DashboardRef.messageInput.attr("readonly", "readonly");
                $("#dashboard-message-form a").attr("disabled", "disabled");
                $(".chat-upload-attachment").attr("disabled", "disabled");

            } else {

                // show send card
                $(".dashboard-messenger-sendCard").show();
                // remove loading opacity to messages container
                DashboardRef.messagesContainer.css("opacity", "1");
                // enable message form fields
                DashboardRef.messageInput.removeAttr("readonly");

                $("#dashboard-message-form a").removeAttr("disabled");
                $(".chat-upload-attachment").removeAttr("disabled");
            }
        }
        
        
        // Loading svg
        DashboardRef.loadingSVG = function(size = "25px", className = "", style = "") {
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
        
        /**
         *-------------------------------------------------------------
        * Send message function
        *-------------------------------------------------------------
        */
        DashboardRef.sendMessage = function() {

            DashboardRef.temporaryMsgId += 1;
            let temp_id = `temp_${DashboardRef.temporaryMsgId}`;
            let hasFile = DashboardRef.attachmentFiles.length > 0 ? true : false;
            const inputValue = $.trim(DashboardRef.messageInput.val());

            if (inputValue.length > 0 || hasFile) {
                
                const formData = new FormData();
                formData.append("chat_room_id", DashboardRef.dashSelectedRoomId);
                formData.append("message", $("#dashboard-message-form textarea[name='message']").val());
                formData.append("temp_id", temp_id);
                formData.append("media_files", JSON.stringify(DashboardRef.attachmentFiles));
                formData.append("type", hasFile ? 'file' : 'text');
                formData.append("receiver_id", $("#dashboard-message-form input[name='receiver_id']").val());
                formData.append("receiver_user", $("#dashboard-message-form input[name='receiver_user']").val());
                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
                
                $.ajax({
                    url: $("#dashboard-message-form").attr("action"),
                    method: "POST",
                    data: formData,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    beforeSend: () => {

                        // append a temporary message card
                        if (hasFile) {
                            DashboardRef.messagesContainer
                                .append(
                                    DashboardRef.sendTempMessageCard(
                                    inputValue + "\n" + DashboardRef.loadingSVG("28px"),
                                    temp_id
                                ));
                        } else {
                            DashboardRef.messagesContainer
                                .append(DashboardRef.sendTempMessageCard(inputValue, temp_id));
                        }
                        // scroll to bottom
                        scrollToBottom(DashboardRef.messagesContainer);
                        // form reset and focus
                        $("#dashboard-message-form").trigger("reset");
                        DashboardRef.cancelAttachment();
                        DashboardRef.messageInput.focus();
                    },
                    success: (response) => {
                            
                        // temporary message card
                        const tempMsgCardElement = DashboardRef.messagesContainer.find(".message-card[data-room-id='"+response.data.temp_id+"']");

                        // add the message card coming from the server before the temp-card
                        // tempMsgCardElement.before(DashboardRef.getChatMessagesUI([response.data]));
                        
                        // then, remove the temporary message card
                        tempMsgCardElement.remove();
                        
                        // scroll to bottom
                        scrollToBottom(DashboardRef.messagesContainer);
                        
                    },
                    error: () => {
                        // error log
                        console.error("Failed sending the message! Please, check your server response.");
                    },
                });
            }
            return false;

        }

        
        // While sending a message, show this temporary message card.
        DashboardRef.sendTempMessageCard = function(message, id) {

            var html = '';

            html += '<div class="row mt-1 message-card" data-room-id="'+id+'" >';
            html += '       <div class="col-10 pr-0 pl-md-5">';
            html += '           <div class="text-left"><small class="text-dark">'+convertUtcDateTimeToLocalDateTime(new Date())+'</small></div>';
            html += '           <div class="container darker">';
            html += '               <p class="pt-1">'+message+'</p>';
            html += '           </div>';
            html += '       </div>';            
            html += '   <div class="col-lg-2 col-1 d-flex align-items-center">';
            html += '       <img src="'+(auth_profile != '' ? auth_profile : '{{asset('common/images/default_user.jpeg')}}')+'" class="avtar_35" alt="Avatar">';                    
            html += '   </div>';
            html +='</div>';
            
            return html;
        }
    
        DashboardRef.attachmentValidate = function(file) {
            
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
           
        DashboardRef.getAttachmentMaxIndexCount = function() {
            
            var items_index_array = [];
        
            $(".dashboard-chat-attachment-preview").each(function (key, val) {
                items_index_array.push($(this).data('index'));
            });
        
            var max_item_count = 0;
        
            if(items_index_array.length > 0){
                max_item_count = Math.max.apply(Math,items_index_array); 
            }
            return max_item_count;
        };

        // upload image preview card.
        DashboardRef.attachmentTemplate = function(fileType, fileName, imgURL = null, index='') {
            
            var html = '';

            if (fileType != "image") {
                
                html += '<div class="dashboard-chat-attachment-preview mr-1" data-index="'+index+'">';
                html += '   <span class="fas fa-times remove-attachment" data-index="'+index+'"></span>';
                // html += '   <p style="padding:0px 30px;">';
                // html += '       <span class="fas fa-file"></span>';
                // html +=         escapeHtml(fileName) +'</p>';
                html += '</div>';

            } else {

                html += '<div class="dashboard-chat-attachment-preview mr-1" data-index="'+index+'">';
                html += '   <span class="fas fa-times remove-attachment" data-index="'+index+'"></span>';
                // html += '   <div class="image-file dashboard-chat-image-preview" style="background-image: url(' +imgURL +');"></div>';
                
                if ($.inArray(fileName.substr( (fileName.lastIndexOf('.') +1) ), DashboardRef.imgExtArray) != -1) {
                    html += '   <img class="image-file dashboard-chat-image-preview" src="' +imgURL +'">';
                }else if ($.inArray(fileName.substr( (fileName.lastIndexOf('.') +1) ), DashboardRef.pdfExtArray) != -1) {
                    html += '   <img class="image-file dashboard-chat-image-preview" src="' +DashboardRef.pdfImage +'">';
                }else{
                    html += '   <img class="image-file dashboard-chat-image-preview" src="' +DashboardRef.docImage +'">';
                }
                // html += '   <p><span class="fas fa-file"></span>'+escapeHtml(fileName) +'</p>';
                html += '</div>';

            }
            
            return html;

        }

         
        /**
         *-------------------------------------------------------------
        * Cancel file attached in the message.
        *-------------------------------------------------------------
        */
        DashboardRef.cancelAttachment = function() {

            DashboardRef.attachmentFiles = [];
            $('#dashboard_attachment_container').html('');
        }

        
        DashboardRef.initEvents = function() {

            channel.bind("messaging", function (data) {

                if(data.chat_room_dtls != undefined && data.chat_room_dtls != ''){

                    if(data.chat_room_id == DashboardRef.dashSelectedRoomId && data.message_obj != undefined && data.message_obj != '') {
                    
                        DashboardRef.messagesContainer.append(DashboardRef.getChatMessagesUI([data.message_obj]));
                    
                        scrollToBottom(DashboardRef.messagesContainer);

                        // trigger seen event
                        DashboardRef.makeSeen(DashboardRef.dashSelectedRoomId);
                    }
                }

            });

            if(DashboardRef.dashSelectedRoomId != ''){
                DashboardRef.loadActiveContactChat(DashboardRef.dashSelectedRoomId);
            }

            // message form on submit.
            $("#dashboard-message-form").on("submit", (e) => {
                e.preventDefault();
                DashboardRef.sendMessage();
            });

            $('body').on('click','.dashboard-send-msg-btn',function(e){
                e.preventDefault();
                DashboardRef.sendMessage();
            });
            
            $("#dashboard-message-form textarea[name='message']").keypress(function (e) {
                if(e.which === 13 && !e.shiftKey) {
                    e.preventDefault();            
                    DashboardRef.sendMessage();
                }
            });

            $('body').on('click','.remove-attachment',function(e){
           
                e.preventDefault();

                var index = $(this).data('index');

                if(index != undefined && index != ''){

                    var obj_item_index = DashboardRef.attachmentFiles.findIndex(x => x.id == index);
        
                    if(obj_item_index != -1){

                        DashboardRef.attachmentFiles.splice(obj_item_index, 1);

                    }

                    $('.dashboard-chat-attachment-preview[data-index="'+index+'"]').remove();

                }

            });

            // On [upload attachment] input change, show a preview of the image/file.
            
            $("body").on("change", "#dashboard-chat-file-input", (e) => {

                if (e.target.files) {

                    let total_selected_files = e.target.files.length;

                    if(DashboardRef.attachmentFiles.length >= 5){
                        showErrorMessage("You can only upload a maximum of 5 files");
                        return false;
                    }

                    if(total_selected_files > 5){
                        showErrorMessage("You can only upload a maximum of 5 files");
                    }

                    if(DashboardRef.attachmentFiles.length > 5){
                        total_selected_files = 0;
                    }else{
                        total_selected_files = DashboardRef.attachmentFiles.length > 0 ? (5 - DashboardRef.attachmentFiles.length) : (total_selected_files >= 5 ? 5 : total_selected_files); 
                    }

                    for (var i = 0; i < total_selected_files; i++) {

                        let file = e.target.files[i];

                        if (!DashboardRef.attachmentValidate(file)){
                            return false;
                        }

                        var reader = new FileReader();

                        reader.onload = function(event) {

                            var index = (DashboardRef.getAttachmentMaxIndexCount()+1);
                            
                            DashboardRef.attachmentFiles.push({
                                'id' : index,
                                'media_source' : event.target.result,
                                'media_name' : file.name,
                                'file_formate' : file.name.split(".").pop().toString().toLowerCase()
                            });

                            $('#dashboard_attachment_container').append(DashboardRef.attachmentTemplate("image", file.name, event.target.result, index));

                        }

                        reader.readAsDataURL(file);
    
                    }
                    
                }
            });
        }
        
        DashboardRef.initEvents();
    };

</script>
