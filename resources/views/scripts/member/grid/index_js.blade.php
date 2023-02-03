<script>
    window.onload = function() {
        'use strict';

        var GridRef = window.GridRef || {};
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

        GridRef.stylegridCurrentPage = 1;
        GridRef.stylegridTotalPage = 0;
        GridRef.isActiveAjax = false;

        GridRef.initEvents = function() {

            GridRef.getStylegrids();

            $(window).scroll(function() {
                       
                if ($(document).height() >= $(window).scrollTop() + $(window).height()) {
                   
                    if(GridRef.stylegridCurrentPage <= GridRef.stylegridTotalPage && GridRef.isActiveAjax == false){
                        
                        GridRef.isActiveAjax = true;
                        GridRef.stylegridCurrentPage++;
                        GridRef.getStylegrids();
                    }
                }
            });

        }
                
        GridRef.getStylegrids = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', GridRef.stylegridCurrentPage);
            
            showSpinner('#grid_container');

            window.getResponseInJsonFromURL('{{ route("member.grid.list") }}', formData, (response) => {

                hideSpinner('#grid_container');
   
                if (response.status == '1') {

                    GridRef.stylegridTotalPage = response.data.total_page;
                    $('#grid_container').append(response.data.view);
                    
                } else {
                    showErrorMessage(response.error);
                }
                GridRef.isActiveAjax = false;

            }, processExceptions, 'POST');
           
        };
        
        GridRef.initEvents();

    };

</script>
