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

                    NotificationRef.notificationsTotalPage = response.data.total_page;
                    $('#notifications_container').append(response.data.view);

                } else {
                    showErrorMessage(response.error);
                }
                NotificationRef.isActiveAjax = false;

            }, processExceptions, 'POST');
           
        };


        NotificationRef.initEvents();
    };

</script>
