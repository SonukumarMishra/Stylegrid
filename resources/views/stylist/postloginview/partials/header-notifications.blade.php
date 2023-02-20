
@php
    $stylist_auth = Session::get('stylist_data');
@endphp

<script>
    
    // Notification show code

    @if (isset($stylist_auth) && !empty($stylist_auth))

        function getUnreadNotifications(){
            
            var formData = new FormData();            
            formData.append('user_id', '{{ $stylist_auth->id }}');
            formData.append('user_type', 'stylist');

            window.getResponseInJsonFromURL("{{ route('stylist.notifications.unread_list') }}", formData, (response) => {
                
                if(response.status == 1){

                    processUnreadNotificationResponse(response.data);

                }
            
            }, (error) => { console.log(error); }, 'POST');

        }

        function processUnreadNotificationResponse(response){

            $('#notify-badge-count').addClass('hidden');
            $('#notify-badge-count-title').hide();
            $('#notify-read-all-container').addClass('hidden');
            $('#unread-notifications-container').html('');

            if(response.total > 0){

                $('#notify-badge-count').html(response.total);
                $('#notify-badge-count').removeClass('hidden');
                $('#notify-badge-count-title').html(response.total+' new Notification');
                $('#notify-badge-count').show();
                $('#notify-badge-count-title').show();
                $('#notify-read-all-container').removeClass('hidden');

                var html = '';

                $.each(response.list, function (i, value) { 
                    
                    value.data = JSON.parse(value.data);
                    
                    html += '<div class="notify-action" data-action-type="" data-action-id="" data-id="">';
                    html += '    <div class="media d-flex align-items-center">';
                    html += '        <div class="media-body">';
                    html += '            <h6 class="media-heading">'+value.notification_description+'</h6>';
                    html += '            <small class="notification-text">'+convertUtcDateTimeToLocalDateTime(value.created_at)+'</small>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';

                });

                $('#unread-notifications-container').append(html);

            }else{
                $('#unread-notifications-container').append('<h6 class="header-notification text-center text-muted mt-2 mb-2">No Notifications!</h6>');
            }

        }
        
        $('body').on('click','#notify-all-read-btn',function(){

            var nformData = new FormData();
            nformData.append('read_all', 1)
            nformData.append('user_id', '{{ $stylist_auth->id }}');
            nformData.append('user_type', 'stylist');

            getResponseInJsonFromURL("{{ route('stylist.notifications.read_all') }}", nformData, (response) => {
                getUnreadNotifications(); 
            }, (error) => { console.log(error); });
        });

        getUnreadNotifications();

        setInterval(getUnreadNotifications, 10000);   // 10 seconds(miliseconds)

    @endif
    
    
</script>