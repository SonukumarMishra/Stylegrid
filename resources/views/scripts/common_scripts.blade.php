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

        window.confirmDialogMessage = function(title_msg, sub_title_msg, furtherFuntionToCall, target = '') {

            Swal.fire({
                customClass: {
                    confirmButton: 'primary-bg',
                },
                title: title_msg,
                text: sub_title_msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ok',
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

        window.convertUtcDateTimeToLocalDateTime = function(time, format = 'DD MMM, YYYY , hh:mm A') {
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
                '<div class="text-center col-12 mt-4 mb-4" id="spinner-ref"><div class="spinner-border spinner-border-' +
                size + ' text-' + color +
                '" role="status">  <span class="sr-only">Loading...</span> </div></div>');
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

    }(window));
</script>
