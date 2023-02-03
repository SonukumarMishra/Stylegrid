<script>
    (function(window) {
        'use strict';

        /*
         * Log application events for analytics usage.
         * @param string event The event name.
         * @param object data The event params.
         */

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        window.getResponseInJsonFromURL = function(urlToCall, dataToSend, furtherFuntionToCall, errorFuntionToCall,
            type = 'post') {

            $.ajax({
                type: type,
                url: urlToCall,
                data: dataToSend,
                processData: false,
                contentType: false,
                success: function(response) {

                    if (typeof furtherFuntionToCall == 'function') {
                        furtherFuntionToCall(response);
                    }

                },
                error: function(jqXHR, textStatus, ex) {
                    if (typeof errorFuntionToCall == 'function') {
                        errorFuntionToCall(jqXHR.responseText);
                    }
                }
            });

        };

        window.submitForm = function(selector, options, isDirectSubmit = false, furtherFuntionToCall,
            errorFuntionToCall, loadingSelector = '') {

            $(selector).validate({
                rules: options.rules ? options.rules : {},
                messages: options.messages ? options.messages : {},
                focusInvalid: options.focusInvalid ? options.focusInvalid : true,
                errorPlacement: function(error, element) {

                    if (element.attr("data-element-ref") == 'select2') {
                        $(':input[name="' + element.attr("name") + '"]').next().append(error);
                    } else {
                        error.insertAfter(element);
                    }

                },
                submitHandler: function(form, event) {

                    event.preventDefault();
                    if (isDirectSubmit == true) {
                        form.submit();
                    } else {

                        showLoadingDialog(loadingSelector != '' ? loadingSelector : '');

                        var methodType = form.getAttribute('method') != null ? form.getAttribute(
                            'method') : (options.type ? options.type : '');
                        var actionUrl = form.getAttribute('action') != null ? form.getAttribute(
                            'action') : (options.url ? options.url : '');

                        window.getResponseInJsonFromURL(actionUrl, getFormInputs(selector),
                            furtherFuntionToCall, errorFuntionToCall, methodType);

                        return false;
                    }

                }
            });

        }

        var loadingDialogToast = Swal.mixin({
            title: 'Please wait......',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        window.showLoadingDialog = function(target = '') {

            loadingDialogToast.fire({
                target: (target != '' ? document.getElementById(target) : 'body'),
                onBeforeOpen: () => {
                    Swal.showLoading();
                }

            });
        }

        window.hideLoadingDialog = function() {

            loadingDialogToast.close();

        }

        window.showSuccessMessage = function(title = '', sub_title = '') {

            toastr.options = {
                "closeButton": true,
            }
            toastr.success(title, sub_title);
        }


        window.showErrorMessage = function(title = '', sub_title = '') {

            toastr.options = {
                "closeButton": true,
            }
            toastr.error(title, sub_title);

        }

        window.confirmDialogMessage = function(title_msg, sub_title_msg, confirm_btn_text='Ok',furtherFuntionToCall, target = '') {

            Swal.fire({
                customClass: {
                    confirmButton: 'primary-bg',
                },
                title: title_msg,
                text: sub_title_msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirm_btn_text,
                target: (target != '' ? document.getElementById(target) : 'body'),
            }).then((result) => {

                if (result.value) {

                    furtherFuntionToCall();

                }

            });

        }

        window.showAlertMessage = function(icon_msg, title_msg, sub_title_msg, target = '', confirmButtonText = '',
            redirect_to = '') {
            Swal.fire({
                icon: icon_msg,
                title: title_msg,
                text: sub_title_msg,
                target: (target != '' ? document.getElementById(target) : 'body'),
                confirmButtonText: confirmButtonText ? confirmButtonText : 'Ok',
            }).then((result) => {

                if (result.value) {

                    if (redirect_to) {

                        window.location.href = redirect_to;

                    }
                }
            });
        }

        window.formatDateValue = function(date, format = '') {
            return moment.utc(date, 'YYYY-MM-DD HH:mm:ss').local().format(format != '' ? format : 'MM/DD/YYYY');
        }

        window.convertLocalDateTimeToUtcDateTime = function(date, format = '') {
            return moment(date, 'MM-DD-YYYY HH:mm:ss').utc().format(format != '' ? format :
                'YYYY-MM-DD HH:mm:ss');
        }

        window.convertUtcDateTimeToLocalDateTime = function(time, format = 'MM/DD/YYYY HH:mm') {
            return moment.utc(time, 'YYYY-MM-DD HH:mm:ss').local().format(format);
        }


        window.getFormInputs = function(form_selector) {

            var formData = new FormData($(form_selector)[0]);

            return formData;
        }

      
        window.getDetailsFromObjectByKey = function(obj, id, key) {

            for (var data in obj) {
                var e = obj[data];
                if (e[key] == id) {
                    return e;
                }
            }
        };


        window.showSpinner = function(form_selector, size = 'lg', color = 'primary') {
            $(form_selector).append(
                '<span class="text-center col-12 mt-4 mb-4" id="spinner-ref"><div class="spinner-border spinner-border-' + size + ' text-' + color + '" role="status">  <span class="sr-only">Loading...</span> </div></span>');
        }

        window.hideSpinner = function(form_selector) {
            $(form_selector + ' #spinner-ref').remove();
        }

        window.formatNumber = function(number) {
            return parseFloat(number).toFixed(2);
        }

        window.fileChangePreviewImage = function(input, src_selector) {
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(src_selector).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        window.fileValidate = function(input, options) {
            
            var tempFile = input.files[0];
            var tempFileName = tempFile.name; // get file name
            var tempFileSize = tempFile.size; // get file size 
            var tempFileType = tempFile.type; // get file type
            var tempFileExtension = tempFileName.split(".").pop();
            var result = {
                'is_valid' : true,
                'error' : ''
            };

            if(options.check_by_ext){

                if ($.isArray(options.ext_array) && !options.ext_array.includes(tempFileExtension.toString().toLowerCase())) {
                    result['is_valid'] = false;
                    result['error'] = 'Invalid image format! Image must be '+options.ext_array.join(", ")+'.';
                }
            }
            
            if(options.check_by_size){

                var max_upload_size_bytes = options.max_upload_size  * 1048576;       // MB to bytes convert
                // Validate file size.
                if (tempFileSize > max_upload_size_bytes) {
                    result['is_valid'] = false;
                    result['error'] = 'Maximum file size limit is '+options.max_upload_size+' MB.';
                }
            }

            return result;
        }

        window.copyToClipboard = function(content) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(content).select();
            document.execCommand("copy");
            $temp.remove();
        }

        window.scrollToBottom = function(container) {
            $(container)
                .stop()
                .animate({
                    scrollTop: $(container)[0].scrollHeight,
                });
        }

        window.downloadFromUrl = function(url, name="") {
            // var link = document.createElement('a');
            // link.href = url;
            // link.download = name;
            // link.click();
            // link.remove();

            fetch(url, { method: 'get', mode: 'no-cors', referrerPolicy: 'no-referrer' })
                .then(res => res.blob())
                    .then(res => {
                        const aElement = document.createElement('a');
                        aElement.setAttribute('download', name);
                        const href = URL.createObjectURL(res);
                        aElement.href = href;
                        aElement.setAttribute('target', '_blank');
                        aElement.click();
                        URL.revokeObjectURL(href);
                    });
        }
            
        window.processExceptions = function(e) {
            showErrorMessage(e);
        };

        window.manageCartBadgeCount = function(total_cart_items) {

            if(total_cart_items == 0){
                $('.cart-badge-count').hide();
            }else{
                $('.cart-badge-count').html(total_cart_items);
                $('.cart-badge-count').show();
            }

            if($('#cart-index-items-count-title').length > 0){
             
                if(total_cart_items == 1){
                    $('#cart-index-items-count-title').html('There is '+total_cart_items+' product in your cart.');
                }else if(total_cart_items > 1){
                    $('#cart-index-items-count-title').html('There are '+total_cart_items+' products in your cart.');
                }else{
                    $('#cart-index-items-count-title').html('');
                }
                
            }
        };

    }(window));
</script>
