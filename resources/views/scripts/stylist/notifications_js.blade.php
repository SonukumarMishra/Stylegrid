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

        NotificationRef.initEvents = function() {

            NotificationRef.getNotifications();

        }
                
        NotificationRef.getNotifications = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', NotificationRef.notificationsCurrentPage);

            window.getResponseInJsonFromURL('{{ route("stylist.notifications.list") }}', formData, (response) => {
               
                if (response.status == '1') {

                    $('#notifications_container').html(response.data.view);

                } else {
                    showErrorMessage(response.error);
                }
            }, processExceptions, 'POST');
           
        };


        NotificationRef.initEvents();
    };

</script>
