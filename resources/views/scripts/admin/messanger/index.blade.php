<script>

    window.onload = function() {
        'use strict';

        var MessangerRef = window.MessangerRef || {};
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

        MessangerRef.contactCurrentPage = 1;
        MessangerRef.contactTotalPage = 0;
        MessangerRef.contactIsActiveAjax = false;
        MessangerRef.contactIsFilter = false;

        MessangerRef.chatCurrentPage = 1;
        MessangerRef.chatTotalPage = 0;
        MessangerRef.chatIsActiveAjax = false;

        MessangerRef.allContactsList = [];
        MessangerRef.activeChatContactRoom = 0;
        MessangerRef.activeChatDate = '';

        var imgExtArray = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        var pdfExtArray = ['pdf'];
        var docExtArray = ['docx','doc'];
        var pdfImage = "{{asset('common/images/pdf.png')}}";
        var docImage = "{{asset('common/images/doc.png')}}";

        MessangerRef.initEvents = function() {

            MessangerRef.getChatContacts();
            
            $("body").on("click", ".messenger-list-item", function () {

                $(".messenger-list-item").removeClass("chat-contact-active");

                $(this).addClass("chat-contact-active");

                const roomId = $(this).attr("data-room-id");

                MessangerRef.activeChatContactRoom = roomId;

                MessangerRef.loadActiveContactChat(roomId);

            });

            $('body').on('click', '.download-attachment, .download-attachment-doc',function(e){

                e.preventDefault();

                var url = $(this).data('path');

                downloadFromUrl(url, $(this).data('file-name'));

            });

            $('#search_input').on('input', function(e) {

                MessangerRef.contactIsActiveAjax = false;
                MessangerRef.contactCurrentPage = 1;
                
                $('#listOfContacts').html('');
                $('#chat_messages_container').hide();

                if('' == this.value) {
                    MessangerRef.contactIsFilter = false;
                    MessangerRef.getChatContacts();
                }else{

                    if(this.value.length > 3){
                        MessangerRef.contactIsFilter = true;
                        MessangerRef.getChatContacts();
                    }

                }
            });

            $('body').on('click', '.download-all-btn',function(e){

                e.preventDefault();
                
                var files_json = $(this).data('files');

                MessangerRef.generateZIP(files_json);

            });

            $("#chatContactRow").on('scroll', function() {

                if (( $(this).scrollTop() + $(this).innerHeight() + 100) >= $(this)[0].scrollHeight && MessangerRef.contactCurrentPage <= MessangerRef.contactTotalPage && MessangerRef.contactIsActiveAjax == false) {
                    
                    MessangerRef.contactIsActiveAjax = true;
                    MessangerRef.contactCurrentPage++;
                    MessangerRef.getChatContacts();
                }
            });

            $("#chat_list_container").on('scroll', function() {

                if ( $(this).scrollTop() <= 0 && MessangerRef.chatCurrentPage > 1 && MessangerRef.chatCurrentPage <= MessangerRef.chatTotalPage && MessangerRef.chatIsActiveAjax == false) {
                    
                    MessangerRef.chatIsActiveAjax = true;
                    MessangerRef.getChatRoomMessages(MessangerRef.activeChatContactRoom, false);
                }

            });

        }
          
        MessangerRef.getChatContacts = function(e) {
        
            var formData = new FormData();            
            formData.append('page', MessangerRef.contactCurrentPage);
            formData.append('is_filter', MessangerRef.contactIsFilter);
            formData.append('search', $('#search_input').val());

            if(MessangerRef.contactCurrentPage == 1){
                $('#listOfContacts').html('');
            }

            showSpinner('#listOfContacts');

            window.getResponseInJsonFromURL('{{ route("admin.messanger.contacts") }}', formData, (response) => {

                hideSpinner('#listOfContacts');
   
                if (response.status == '1') {

                    MessangerRef.contactTotalPage = response.data.total_page;
                    
                    $('#listOfContacts').append(response.data.view);

                    if(response.data.list.length > 0){
                        $.merge(MessangerRef.allContactsList, response.data.list);
                    }
                    
                    if(MessangerRef.contactCurrentPage == 1 && response.data.list.length > 0){

                        MessangerRef.activeChatContactRoom = response.data.list[0]['chat_room_id'];

                        MessangerRef.loadActiveContactChat(MessangerRef.activeChatContactRoom);

                        $(".messenger-list-item").removeClass("chat-contact-active");

                        $(".messenger-list-item[data-room-id='"+MessangerRef.activeChatContactRoom+"']").addClass("chat-contact-active");

                    }

                } else {
                    showErrorMessage(response.message);
                }
                MessangerRef.contactIsActiveAjax = false;

            }, processExceptions, 'POST');
           
        };
        
        MessangerRef.generateZIP = function(links) {

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

        MessangerRef.loadActiveContactChat = function(room_id){

            var room_dtls = getDetailsFromObjectByKey(MessangerRef.allContactsList, room_id, 'chat_room_id');

            if(room_dtls != undefined){
            
                MessangerRef.chatIsActiveAjax = false;
                MessangerRef.activeChatDate = '';
                MessangerRef.chatCurrentPage = 1;

                MessangerRef.getChatRoomMessages(room_id, true);
                
                $('#chat_list_container').html('');

                $("#active-chat-box-user-name").html(room_dtls.sender_name +' & '+room_dtls.receiver_name);

                $("#active-chat-module").html(room_dtls.module == "{{ config('custom.chat_module.sourcing') }}" ? 'Sourcing' : 'Private');

                var sender_profile = room_dtls.sender_profile != null ? ( room_dtls.sender_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+room_dtls.sender_profile : '{{asset('common/images/default_user.jpeg')}}';
                
                $("#active-chat-box-user-profile").attr('src',sender_profile);

                $('#chat_messages_container').show();

            }

        }

        MessangerRef.getChatRoomMessages = function(room_id, newFetch = false) {

            var formData = new FormData();            
            formData.append('page', MessangerRef.chatCurrentPage);
            formData.append('chat_room_id', MessangerRef.activeChatContactRoom);
            
            showSpinner('#chat_list_container');

            window.getResponseInJsonFromURL('{{ route("admin.messanger.room.messages") }}', formData, (response) => {

                hideSpinner('#chat_list_container');
   
                if (response.status == '1') {

                    MessangerRef.chatTotalPage = response.data.total_page;
                    
                    if(response.data.list.length > 0){

                        var parent_room_dtls = getDetailsFromObjectByKey(MessangerRef.allContactsList, MessangerRef.activeChatContactRoom, 'chat_room_id');

                        var chat_container_html = MessangerRef.getChatMessagesUI(response.data.list.length > 0 ? response.data.list.reverse() : response.data.list, parent_room_dtls);

                        if(MessangerRef.chatCurrentPage == 1){

                            $('#chat_list_container').append(chat_container_html);

                            scrollToBottom('#chat_list_container');

                        }else{

                            const lastMsg = $('#chat_list_container').find($('#chat_list_container').find(".message-card")[0]);
                            
                            const chat_date_div = $('#chat_list_container').find($('#chat_list_container').find(".chat-date")[0]);

                            if(lastMsg.length > 0){

                                const curOffset = lastMsg.offset().top - $('#chat_list_container').scrollTop();

                                $('#chat_list_container').prepend(chat_container_html);

                                if(chat_date_div.length > 0 && $('#chat_list_container .message-card:first').data('date') == MessangerRef.activeChatDate){
                                    
                                    $('#chat_list_container .chat-date[data-date="'+MessangerRef.activeChatDate+'"]').remove();
                                    
                                    var date_ui = '<div class="row chat-date my-1" data-date="'+MessangerRef.activeChatDate+'">'+convertUtcDateTimeToLocalDateTime(MessangerRef.activeChatDate, 'dddd Do MMMM YYYY')+'</div>';

                                    $('#chat_list_container').prepend(date_ui);
                                }

                                $('#chat_list_container').scrollTop(lastMsg.offset().top - curOffset);

                            }

                        }

                    }
                    

                } else {
                    showErrorMessage(response.message);
                }
                MessangerRef.chatIsActiveAjax = false;
                MessangerRef.chatCurrentPage++;

            }, processExceptions, 'POST');

        }

        MessangerRef.getChatMessagesUI = function(list, room_dtls) {

            var html = '';

            if(list.length > 0){

                $.each(list, function (i, val) { 

                    if(MessangerRef.activeChatDate == '' || MessangerRef.activeChatDate != convertUtcDateTimeToLocalDateTime(val.created_at, 'YYYY-MM-DD')){

                        MessangerRef.activeChatDate = convertUtcDateTimeToLocalDateTime(val.created_at, 'YYYY-MM-DD');
                        html += '<div class="row chat-date my-1" data-date="'+MessangerRef.activeChatDate+'">'+convertUtcDateTimeToLocalDateTime(val.created_at, 'dddd Do MMMM YYYY')+'</div>';
                    }

                    html += '<div class="row mx-2 mb-1 message-card" data-date="'+MessangerRef.activeChatDate+'">';

                    var profile = '';

                    if(val.sender_user == room_dtls.sender_user){

                        profile = val.sender_profile != null ? ( val.sender_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+val.sender_profile : '{{asset('common/images/default_user.jpeg')}}';
                        html += '   <div class="col-md-10 msg-box py-2">';
                    
                    }else{

                        profile = val.sender_profile != null ? ( val.sender_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+val.sender_profile : '{{asset('common/images/default_user.jpeg')}}';

                        html += '   <div class="col-md-2"></div>';
                        html += '   <div class="col-md-10 msg-box-right py-2">';
                        
                    }

                   
                    html += '           <div class="d-flex">';
                    html += '               <div class="">';
                    html += '                   <img src="'+profile+'" class="img-fluid chat-pic" alt="">';
                    html += '               </div>';
                    html += '               <div class="col-11 pl-1">';
                    html += '                   <div class="d-flex justify-content-between">';
                    html += '                       <div class="msg-h1">'+val.sender_name+'</div><div class="msg-time ml-2">'+convertUtcDateTimeToLocalDateTime(val.created_at, 'HH:mm')+'</div>';
                    html += '                   </div>';
                    html += '               <div>';
                    if(val.type == "file"){

                        var files_array = JSON.parse(val.files);

                        if(files_array.length > 1){
                            html += "       <div class='text-right mt-1'><a href='#' class='download-all-btn' data-files='"+val.files+"'><i class='fas fa-download'></i>&nbsp;Download All</a></div>";
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
                        html += '           <div class="msg-p">'+val.message+'</div>';
                    }
                    html += '           </div>';
                    html += '       </div>';
                    html += '</div>';
                    html += '    </div>';
                    html += '</div>';

                });

            }
            return html;

        }

        MessangerRef.initEvents();

    };

</script>