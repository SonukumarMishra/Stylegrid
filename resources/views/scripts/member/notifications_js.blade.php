<script>
    window.onload = function() {
        'use strict';

        var NotificationRef = window.NotificationRef || {};
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

        NotificationRef.notificationsCurrentPage = 1;
        NotificationRef.notificationsTotalPage = 0;
        NotificationRef.isActiveAjax = false;

        NotificationRef.initEvents = function() {

            NotificationRef.getNotifications();

            $(window).scroll(function() {
                       
                if ($(document).height() >= $(window).scrollTop() + $(window).height()) {
                   
                    if(NotificationRef.notificationsCurrentPage <= NotificationRef.notificationsTotalPage && NotificationRef.isActiveAjax == false){
                        
                        NotificationRef.isActiveAjax = true;
                        NotificationRef.notificationsCurrentPage++;
                        NotificationRef.getNotifications();
                    }
                }
            });

        }
                
        NotificationRef.getNotifications = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', NotificationRef.notificationsCurrentPage);
            
            showSpinner('#notifications_container');

            window.getResponseInJsonFromURL('{{ route("member.notifications.list") }}', formData, (response) => {

                hideSpinner('#notifications_container');
   
                if (response.status == '1') {

                    // NotificationRef.notificationsTotalPage = response.data.total_page;
                    // $('#notifications_container').append(NotificationRef.notificationsListUI(response.data));
                    $('#notifications_container').append(response.data.view);
                    
                } else {
                    showErrorMessage(response.message);
                }
                NotificationRef.isActiveAjax = false;

            }, processExceptions, 'POST');
           
        };

        
        NotificationRef.notificationsListUI = function(data_list) {

            var html = '';

            if(data_list.length > 0){

                $.each(data_list, function (i, val) { 
                     
                    html += '<div class="col-12 notification-card">';
                    html += '   <div class="row notification-row">';
                    html += '       <div class="col-12 notification-div mt-1">';
                    html += '           <div class="d-flex justify-content-between">';
                    html += '               <h1>'+val.notification_title+'</h1>';
                    html += '               <p class="time">'+convertUtcDateTimeToLocalDateTime(val.created_at)+'</p>';
                    html += '           </div>';
                    html += '           <div class="d-flex justify-content-between">';
                    html += '               <h1>'+val.notification_description+'</h1>';
                    // html += '               <button class="view-btn">View</button>';
                    html += '           </div>';
                    html += '       </div>';
                    html += '   </div>';
                    html += '</div>';

                });
            }
            return html;

        }

        NotificationRef.initEvents();
    };

</script>
