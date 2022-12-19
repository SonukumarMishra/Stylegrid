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

        SourcingRef.initEvents = function() {

            channel.bind("sourcing_updates", function (pusher_data) {

                console.log("sourcing_updates", pusher_data);

                // Handle pusher events for sourcing request updates
                var payload = pusher_data.data;

                if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.offer_received') }}" && payload.notify_user_id == auth_id && payload.notify_user_type == auth_user_type){
                    
                    console.log('refresh list');
                    SourcingRef.getLiveRequests();
                }

            });

            SourcingRef.getLiveRequests();

            $('body').on('click', '.page-link', function (e) {
                e.preventDefault();
                SourcingRef.liveRequestsCurrentPage = $(this).attr('data-page');
                SourcingRef.getLiveRequests();
            });
            
        }
        
        
        SourcingRef.getLiveRequests = function(e) {
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('page', SourcingRef.liveRequestsCurrentPage);

            window.getResponseInJsonFromURL('{{ route("member.sourcing.live.requests") }}', formData, (response) => {
               
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
                            
                            pagination_html += '<li class="page-item '+(list.active ? 'active' : (list.url == null ? 'disabled' : '') )+'"><a class="page-link" href="#" data-page="'+url_page+'">'+list.label+'</a></li>';

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

        SourcingRef.initEvents();
    };

</script>
