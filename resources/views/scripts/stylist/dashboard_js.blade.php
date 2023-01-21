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



        DashboardRef.getDashboardChatContacts = function(show_loader=true) {



            if(show_loader){

                showSpinner('#dashboard_chat_contacts');

            }



            $.ajax({

                url: chat_baseurl + "stylist-messanger-contacts",

                method: "POST",

                data: { _token: $('meta[name="csrf-token"]').attr("content"), module : 'private' },

                dataType: "JSON",

                success: (response) => {

                  

                    hideSpinner('#dashboard_chat_contacts');



                    if(response.status = 1){



                        if(response.data.list.length > 0){

             

                            var list_html = DashboardRef.getContactsUIHtml(response.data.list);

                            $("#dashboard_chat_contacts").html(list_html);



                        }else{

                            $("#dashboard_chat_contacts").html('<p class="message-hint center-el text-center"><span>Your contact list is empty</span></p>');

                        }

                    }

                },

                error: (error) => {

                    hideSpinner('#dashboard_chat_contacts');

                    console.error(error);

                },

            });

        }



        

        DashboardRef.getContactsUIHtml = function(contacts) {



            var html = '';



            if(contacts.length > 0){



                $.each(contacts, function (i, val) { 

                    

                    html += '<div class="row my-1 dashboard-messenger-list-item" data-receiver-id="'+val.receiver_id+'" data-receiver-user="'+val.receiver_user+'"  data-room-id="'+val.chat_room_id+'">';

                    html += '   <div class="col-6">';

                    html += '       <div class="row">';

                    html += '           <div>';



                    var receiver_profile = val.receiver_profile != null ? ( val.receiver_user == "stylist" ? '' : asset_url+ '{{ config('custom.media_path_prefix.member') }}' )+val.receiver_profile : '{{asset('common/images/default_user.jpeg')}}';



                    html += '               <img src="'+receiver_profile+'" alt="avatar" class="img-fluid mx-2 img-1">';

                    if(val.unread_count > 0){

                        html += '           <div class="navigate"><span>'+val.unread_count+'</span></div>';

                    }

                    html += '           </div>';

                    html += '           <a href="'+chat_baseurl+'stylist-messanger/'+val.chat_room_id+'" class="d-flex align-items-center h4 text-primary">'+(val.receiver_name)+'</a>';

                    html += '       </div>';

                    html += '   </div>';

                    html += '   <div class="col-6 text-right">';

                    html += '       <div class="row justify-content-end mx-1 pt-1">';

                    html += '           <h4 class="mx-2 online-status-text '+(val.receiver_online == 1 ? 'text-success' : 'text-danger')+'">'+(val.receiver_online == 1 ? 'Online' : 'Offline')+'</h4>';

                    html += '       </div>';

                    html += '   </div>';

                    html += '</div>';

                    

                });



            }



            return html;

        }





        DashboardRef.initEvents = function() {



            channel.bind("messaging", function (data) {



                if(data.chat_room_dtls != undefined && data.chat_room_dtls != ''){



                    if((data.chat_room_dtls.sender_user == auth_user_type && data.chat_room_dtls.sender_id == auth_id) || (data.chat_room_dtls.receiver_user == auth_user_type && data.chat_room_dtls.receiver_id == auth_id)){



                        console.log('Refrrsh contacts');



                        DashboardRef.getDashboardChatContacts(false);



                    }

                }



            });



            // listen to seen event

            channel.bind("client-seen", function (data) {

    

                if (data.update_to == auth_id) {

                    data.seen == true

                    ? DashboardRef.getDashboardChatContacts(false)

                    : console.error("seen Updating failed!");

                }

                

            });





            DashboardRef.getDashboardChatContacts();



        }

        

        DashboardRef.initEvents();

    };



</script>

