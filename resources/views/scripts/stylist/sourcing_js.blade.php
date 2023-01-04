<script>
    window.onload = function() {
        'use strict';

        var SourcingRef = window.SourcingRef || {};
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
        
        SourcingRef.liveRequestsCurrentPage = 1;
        SourcingRef.myRequestsCurrentPage = 1;

        SourcingRef.initEvents = function() {

            channel.bind("sourcing_updates", function (pusher_data) {

                // Handle pusher events for sourcing request updates
                var payload = pusher_data.data;

                if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.offer_received') }}" && payload.notify_user_id == auth_id && payload.notify_user_type == auth_user_type){

                    // When any stylist send offer to me, then reload my sourcing     
                    SourcingRef.getMyRequests();

                }else if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.new_request') }}"){

                    if(payload.association_type_user != auth_user_type){                   

                        // when member creates new request to stylist, reload live requests
                        SourcingRef.getLiveRequests();
                
                    }else if(payload.association_id != auth_id && payload.association_type_user == auth_user_type){

                        // When any sylist user created new request, that time also reload live request
                        SourcingRef.getLiveRequests();
                
                    }
                }else if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.offer_accepted') }}" && payload.notify_user_id == auth_id && payload.notify_user_type == auth_user_type){
     
                    SourcingRef.getLiveRequests();
                
                }else if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.offer_decline') }}" && payload.notify_user_id == auth_id && payload.notify_user_type == auth_user_type){
     
                    SourcingRef.getLiveRequests();
                
                }

            });

            SourcingRef.getLiveRequests();
            SourcingRef.getMyRequests();

            $('body').on('click', '.page-link', function (e) {
                e.preventDefault();

                if($(this).data('table') == "live_requests"){
                
                    SourcingRef.liveRequestsCurrentPage = $(this).attr('data-page');
                    SourcingRef.getLiveRequests();

                }else if($(this).data('table') == "my_requests"){
                    SourcingRef.myRequestsCurrentPage = $(this).attr('data-page');
                    SourcingRef.getMyRequests();
                }

            });
            
        }
                
        SourcingRef.getLiveRequests = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', SourcingRef.liveRequestsCurrentPage);
            formData.append('type', 'live_requests');

            window.getResponseInJsonFromURL('{{ route("stylist.sourcing.requests") }}', formData, (response) => {
               
                $('#live_requests_tbl_container').html('');
                
                if (response.status == '1') {

                    $('#live_requests_tbl_container').html(response.data.view);

                    if(response.data.json.list.links != undefined){

                        var pagination_html = '';

                        pagination_html += '<nav>';
                        pagination_html += '<ul class="pagination">';

                        $.each(response.data.json.list.links, function(indexInArray, list) {

                            var url_page = '';

                            if(list.url != null){
                                var url = list.url;
                                var qs = url.substring(url.indexOf('?') + 1).split('&');
                                for(var i = 0, result = {}; i < qs.length; i++){
                                    qs[i] = qs[i].split('=');
                                    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
                                }
                                url_page = result.page;
                            }
                            
                            pagination_html += '<li class="page-item '+(list.active ? 'active' : (list.url == null ? 'disabled' : '') )+'"><a class="page-link" href="#" data-table="live_requests" data-page="'+url_page+'">'+list.label+'</a></li>';

                        });

                        pagination_html += '</ul>';
                        pagination_html += '</nav>';
                            
                        $('#live_requests_pagination_container').html(pagination_html);

                    }

                } else {
                    showErrorMessage(response.error);
                }
            }, processExceptions, 'POST');
           
        };

        SourcingRef.getMyRequests = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', SourcingRef.myRequestsCurrentPage);
            formData.append('type', 'my_sources');

            window.getResponseInJsonFromURL('{{ route("stylist.sourcing.requests") }}', formData, (response) => {
            
                $('#my_requests_tbl_container').html('');
                
                if (response.status == '1') {

                    $('#my_requests_tbl_container').html(response.data.view);

                    if(response.data.json.list.links != undefined){

                        var pagination_html = '';

                        pagination_html += '<nav>';
                        pagination_html += '<ul class="pagination">';

                        $.each(response.data.json.list.links, function(indexInArray, list) {

                            var url_page = '';

                            if(list.url != null){
                                var url = list.url;
                                var qs = url.substring(url.indexOf('?') + 1).split('&');
                                for(var i = 0, result = {}; i < qs.length; i++){
                                    qs[i] = qs[i].split('=');
                                    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
                                }
                                url_page = result.page;
                            }
                            
                            pagination_html += '<li class="page-item '+(list.active ? 'active' : (list.url == null ? 'disabled' : '') )+'"><a class="page-link" href="#" data-table="my_requests" data-page="'+url_page+'">'+list.label+'</a></li>';

                        });

                        pagination_html += '</ul>';
                        pagination_html += '</nav>';
                            
                        $('#my_requests_pagination_container').html(pagination_html);

                    }

                } else {
                    showErrorMessage(response.error);
                }
            }, processExceptions, 'POST');
        
        };

        SourcingRef.initEvents();
    };

</script>
