<script>
    window.onload = function() {
        'use strict';

        var CreateGridRef = window.CreateGridRef || {};
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

        CreateGridRef.totalStylegridCount = 1;
        
        CreateGridRef.initEvents = function() {

            CreateGridRef.loadStyleGridUI(CreateGridRef.totalStylegridCount);

            $('body').on('click', '#addGridBtn', function(e) {

                CreateGridRef.totalStylegridCount++;
                CreateGridRef.loadStyleGridUI(CreateGridRef.totalStylegridCount);

            });

            
            $('body').on('click', '.delete-grid-btn', function(e) {

                var value = $(this).data('index');

                $('.style-grid-block-row[data-index="'+value+'"]').remove();

                CreateGridRef.styleGridNumberPagination();

            });

            $('body').on('click', '.add-item-block-btn', function(e) {

                // var index = $(this).data('index');
        
                // var item_block_count = $(".item-block-inner-row").length;

                // if (item_block_count < 7) {
                //     var mjblock = '<div class="mjrowtrack_inner col-6" grid="' + rowid + '" data-toggle="modal" id="row_' +
                //         rowid + '_block_' + count1 + '"  data-target="#row_' + rowid + '_gridmodal_' + count1 +
                //         '"><div class="Neon Neon-theme-dragdropbox "><div class="Neon-input-dragDrop "><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid" value="' +
                //         rowid + '" onclick="removeblock(this)" alt="" style="position: absolute;top: 0;">';



                //     $('.showblock_' + rowid + '').append(mjblock);
                //     modaladd(rowid, rowid, count1);

                //     if (item_block_count == 6) {

                //         $('.add-item-block-btn[data-index="'+index+'"]').hide();
                //     }

                // } else {
                //     $('.add-item-block-btn[data-index="'+index+'"]').hide();
                // }
            

            });


        }

        CreateGridRef.loadStyleGridUI = function(index) {
           
            var html = '';

            html+= '<div class="row mt-2 mjrowtrack style-grid-block-row" data-index="'+index+'">';
            html+= '   <div class="col-lg-11">';
            html+= '    <div class="grid-bg mx-4 px-4 py-2 mb-4">';
            html+= '        <div class="row">';
            html+= '            <div class="col-8">';
            html+= '               <h1 class="style-grid-block-title">STYLEGRID #'+index+'</h1>';
            html+= '            </div>';
            html+= '            <div class="col-4 text-right "><img src="{{ asset('stylist/app-assets/images/icons/Empty-Trash.png')}}" class="img-fluid delete-grid-btn" data-index="'+index+'" alt=""/></div>';
            html+= '         </div>';
            html+= '         <div class="row add-item">';
            html+= '            <div class="col-lg-6 d-flex align-items-center">';
            html+= '               <div class="row">';
            html+= '                  <div class="style-grid-item-left-row d-flex flex-wrap "  data-index="'+index+'">';
            html+= '                    <div class="item-block-inner-row col-6">';
            html+= '                        <div class="Neon Neon-theme-dragdropbox mt-5">';
            html+= '                            <input name="files[]" id="filer_input2" multiple="multiple"type="file">';
            html+= '                            <div class="Neon-input-dragDrop">';
            html+= '                                <div class="Neon-input-inner py-3">';
            html+= '                                    <div class="Neon-input-text">';
            html+= '                                      <h3>Add an item here</h3>';
            html+= '                                    </div>';
            html+= '                                    <a class="Neon-input-choose-btn blue"><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" alt=""></a>';
            html+= '                                </div>';
            html+= '                            </div>';
            html+= '                        </div>';
            html+= '                    </div>';
            html+= '                  </div>';
            html+= '                  <div class="col-lg-2 px-0 text-lg-left text-center add-another-block-div" data-index="'+index+'"><button class=" px-3 form-border add-item-block-btn"  data-index="'+index+'" ><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" alt=""><br>Add another block</button></div>';
            html+= '               </div>';
            html+= '            </div>';
            html+= '            <div class="col-lg-6 px-lg-5">';
            html+= '               <div class="Neon Neon-theme-dragdropbox mt-5">';
            html+= '                  <input name="files[]" id="filer_input2" multiple="multiple" type="file">';
            html+= '                  <div class="Neon-input-dragDrop py-5 px-4 mx-lg-3">';
            html+= '                     <div class="Neon-input-inner py-2">';
            html+= '                        <div class="Neon-input-text">';
            html+= '                           <h3>Add your feature image here...</h3>';
            html+= '                        </div>';
            html+= '                     <a class="Neon-input-choose-btn blue"><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" alt=""></a>';
            html+= '                 </div>';
            html+= '                  </div>';
            html+= '               </div>';
            html+= '            </div>';
            html+= '         </div>';
            html+= '      </div>';
            html+= '   </div>';
            html+= '   <div class="col-lg-1"></div>';
            html+= '</div>';

            $('.style-grids-container').append(html);

            CreateGridRef.styleGridNumberPagination();

        };

        CreateGridRef.styleGridNumberPagination = function(e) {
           
            $('.grid-numbering-container').html('');

            var number_html = '';

            var totalStylegridCount = CreateGridRef.getTotalStyleGridDivCount();
            for (let index = 1; index <= totalStylegridCount; index++) {
              
                number_html += '<div class="blue-bg mt-lg-2 mt-1 mx-lg-0 mx-2">' + index + '</div>';
                
            }
            $('.grid-numbering-container').append(number_html);

            $(".style-grid-block-title").each(function(idx, el) {
                $(this).html('STYLEGRID #'+(idx+1));
            });

            var totalStylegridCount = CreateGridRef.getTotalStyleGridDivCount();

            if(totalStylegridCount < 11){
                
                if(totalStylegridCount == 10){
                    $('#addGridBtn').hide();                    
                }else{                
                    $('#addGridBtn').show();
                }

            }

        };

        CreateGridRef.getTotalStyleGridDivCount = function(e) {
            
            var total = $(".style-grid-block-row").length;
            return total;
        };

        CreateGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        CreateGridRef.initEvents();
    };
</script>
