(function($) {

    window.crud_ajax_setup = function() {

        $.ajaxSetup({ // to send CSRF with ajax request.
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    crud_ajax_setup();

    var originPath = $('meta[name="http-root"]').attr('content'); // hold the correct current domain.
    var locale = $('html').attr('lang'); // hold the current locale.


    $('body').on('submit', 'form.ajax', function(e) {
        
        e.preventDefault();
        var form = $(this);
        var formButton = $(form.find(':button.btn-primary'));
        formButton.attr('disabled',true);
        form.prop('disabled','true');  
          
        var formUrl = form.attr('action');

        if ($('.js-ckeditor').length) {
            $.each(CKEDITOR.instances, function(key, value) {
                value.updateElement();
            });
        }

        var formInputs = $(form.find(':input.form-data'));
        var formData = new FormData();

        formInputs.each(function(index, el) {
            var formInput = $(el);

            if (formInput.attr('type') == 'file' && formInput.attr('name').indexOf('[]') >= 0) {

                if (formInput[0].files[0]) {

                    for (var i = 0; i < formInput[0].files.length; i++) {
                        formData.append(formInput.attr('name'), formInput[0].files[i]);
                    }

                } else {
                    formData.append(formInput.attr('name'), formInput.val());
                }

            } else if (formInput.attr('type') == 'file') {

                if (formInput.val()) {
                    formData.append(formInput.attr('name'), formInput[0].files[0]);
                }

            } else if (formInput[0].type == 'select-multiple') {

                if (formInput.val()) {
                    for (var i = 0; i < formInput.val().length; i++) {
                        formData.append(formInput.attr('name'), formInput.val()[i]);
                    }

                }
            } else if (formInput[0].type == 'radio' || formInput[0].type == 'checkbox') {
                if (formInput.is(':checked')) {
                    formData.append(formInput.attr('name'), formInput.val());
                } else {
                    if (formInput[0].type == 'checkbox') {
                        formData.append(formInput.attr('name'), '');
                    }
                }
            } else {
                formData.append(formInput.attr('name'), formInput.val());
            }

        });

        if (form.find('input[name="_method"]').length) {
            formData.append('_method', form.find('input[name="_method"]').val());
        }

        if (form.find('input[name="_token"]').length) {
            formData.append('_token', form.find('input[name="_token"]').val());
        }

        $('.flash-messages').remove();
        $('#ajax-messages').html('');
        $('.val-error').remove();
        $('.nav-tab-title-js').removeClass('text-danger'); // for form wizard tabs.
        $('.has-error').removeClass('has-error');
        $.ajax({
            method: 'POST',
            url: formUrl,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {

                if (response.requestStatus) {

                    //check if response return from login controller

                    if (response.message == "login_done") {
                        location.reload();
                    }
                    if (form.hasClass('edit')) {

                        if (response.data != undefined) {
                            var data = response.data;
                            if (data.images != undefined) {

                                $.each(data.images, function(inputName, inputData) {

                                    if (inputData.type == 'single') {
                                        if (inputData.imageName) {
                                            var imgContainer = $('input[name="' + inputName + '"]').parents('div.img-media').find('div.img-container');

                                            if (imgContainer.find('a.single-image').length) {

                                                var smallImage = form.find('img.' + inputName + '-small-image');

                                                if (smallImage.data('imgName') != inputData.imageName) {

                                                    smallImage.attr('src', inputData.smImgUrl);
                                                    smallImage.data('imgName', inputData.imageName);
                                                    smallImage.parent('a.single-image').data('imgHref', inputData.imageHref);
                                                }
                                            } else {

                                                var imageCard = `
                                                    <a 
                                                        class='single-image' 
                                                        style='cursor: pointer;' 
                                                        data-popup='tooltip' 
                                                        data-img-href='${inputData.imageHref}' 
                                                        data-placement='bottom' 
                                                        data-original-title='View'>
                                                        
                                                        <img src='${inputData.smImgUrl}' data-img-name='${inputData.imageName}' class='${inputName}-small-image img-responsive'>
                                                    </a>
                                                `;
                                                imgContainer.html(imageCard);
                                            }

                                            // for admin profile image changes in sidebar.
                                            if (form.hasClass('admin-profile') && inputName == 'image') {
                                                $('div.side-header img.profile-img').attr('src', inputData.sideImgUrl);
                                                // $('div.sidebar-user img.user-profile-img').parent('a').addClass('show-user-image');
                                            }

                                        }

                                    } else if (inputData.type == 'multiple') {
                                        var realInputName = inputName + '[]'; // its multiple files ( array )
                                        if (Object.keys(data.images[inputName].images).length) {
                                            $.each(data.images[inputName].images, function(key, value) {

                                                var imagesHref = $('input[name="' + realInputName + '"]').siblings('input#' + inputName + '-href').val() + '/' + key;

                                                if ($('#' + inputName + '-additional-images img#img-' + key).length == 0) {
                                                    var additionalImageDiv = `
                                                            <div class="col-xs-4 gallery-img-${key}">
                                                                <a class='img-link additional-imgs-item' data-img-href = '${imagesHref}' data-img-id='${key}' data-popup='tooltip' data-popup='tooltip' data-placement='bottom' data-original-title='View' style="cursor: pointer;">
                                                                    <img class="img-responsive" id='img-${key}' src='${data.images[inputName].thumbUrl}/${value}' >        
                                                                </a>
                                                            </div>`;

                                                    $('#' + inputName + '-additional-images').find('.js-gallery').append(additionalImageDiv);
                                                }

                                            });
                                        }

                                    }
                                    $('[data-popup="tooltip"]').tooltip();

                                });
                            }

                            // for admin profile image changes in sidebar.
                            if (form.hasClass('admin-profile')) {
                                $('div.side-header .profile-name').html(form.find('input[name=name]').val());
                            }

                            form.find('input[type=password]').val('');

                        }

                        // $('#ajax-messages').html("<div class='alert alert-success alert-styled-left alert-arrow-left alert-bordered'><button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button><p>" + response.message + "</p></div>");

                        $.notify({
                            message: response.message,
                        }, {
                            // settings
                            type: 'success'
                        });

                    } else {

                        // create forms.

                        form.trigger("reset");
                        form.find('select').val('').trigger('change');

                        if ($('.js-ckeditor').length) {
                            $.each(CKEDITOR.instances, function(key, value) {
                                value.setData('');
                            });
                        }

                        if (response.redirect != undefined) {
                            window.location = originPath + '/' + locale + '/' + response.redirect;
                        } else {

                            $('#ajax-messages').html("<div class='alert alert-success alert-styled-left alert-arrow-left alert-bordered'><button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button><p>" + response.message + "</p></div>");
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                        }

                    }


                    if (form.find('input[type="file"]').length) {

                        form.find('input[type="file"]').val('');

                        var fileInputs = form.find('input[type="file"]').parents('.media-body').find('span.filename');
                        for (var i = 0; i < fileInputs.length; i++) {
                            form.find('input[type="file"]').parents('.media-body').find('span.filename')[i].innerHTML = "No file selected";
                        }

                    }


                    /**** callback here ****/

                    /**** callback End ****/



                } else {
                    // $('#ajax-messages').html("<div class='alert alert-danger alert-styled-left alert-bordered'><button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button><p>" + response.message + "</p></div>");

                    crud_handle_server_errors(response, form);

                }


            },
            error: function(data) {

                crud_handle_server_errors(data, form);
            },
            complete: function(data) {
                formButton.attr('disabled',false);
            }

        });

        return false;
    });


    window.crud_handle_validation_errors = function(data, form = null) {
        // $('#ajax-messages').html("<div class='alert alert-danger alert-styled-left alert-bordered'><button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button><p>تحقق من القيم المدخلة.</p></div>");

        $.notify({
            message: 'Validation error',
            // message: Lang.get('forms.validation-error'),
        }, {
            // settings
            type: 'danger'
        });

        var errors = data.responseJSON.errors;
        $.each(errors, function(key, value) {
            var input = form != null ? form.find(':input[name="' + key + '"]') : $(':input[name="' + key + '"]');
            if (input.length == 0) input = $(':input[name="' + key + '[]"]'); // for multiple inputs

            if (input.length == 0 && key.indexOf(".") != -1) { // for multiple inputs nested names
                var nestedNames = key.split(".");
                var inputName = '';

                for (var i = 0; i < nestedNames.length; i++) {

                    if (i != 0) {
                        inputName += '[' + nestedNames[i] + ']';
                    } else {
                        inputName += nestedNames[i];
                    }

                }

                input = form != null ? form.find(':input[name="' + inputName + '"]') : $(':input[name="' + inputName + '"]');
            }

            if (input.length) {

                if (input[0].nodeName == 'TEXTAREA') {
                    input.parent('div.form-valid').parent('div').addClass('has-error');
                    input.parent('div.form-valid ').after("<div class='help-block text-right animated fadeInDown val-error'>" + value[0] + "</div>");
                }
                // else if(input[0].nodeName == 'TEXTAREA'){
                //   input.parents('.form-group').append("<p class='validation-error-label val-error'>:"+value[0]+"</p>");
                // }
                // else if(input.parent('div.input-group').length){
                //   input.parents('.form-group').append("<p class='validation-error-label val-error'>:"+value[0]+"</p>");
                // }
                else if (input.attr('type') == 'file') {
                    input.val('');
                    input.parent('div.form-valid').parent('div').addClass('has-error');
                    input.parent('div.form-valid ').after("<div class='help-block text-left animated fadeInDown val-error'>" + value[0] + "</div>");
                } else {
                    input.parent('div.form-valid').parent('div').addClass('has-error');

                    if (input.hasClass('js-colorpicker')) { // for color picker inputs.
                        input.parents('div.js-colorpicker ').after("<div class='help-block text-right animated fadeInDown val-error' style='color:#d26a5c;'>" + value[0] + "</div>");
                    } else {
                        input.parent('div.form-valid ').after("<div class='help-block text-right animated fadeInDown val-error'>" + value[0] + "</div>");
                    }

                }

                // for form wizard tabs.

                if (input.parents('.tab-pane').length) {

                    var tabPane = input.parents('.tab-pane');
                    var navTab = $('a[href="#' + $(tabPane[0]).attr('id') + '"]');

                    navTab.find('.nav-tab-title-js').addClass('text-danger');

                    if (navTab.find('.val-error-icon').length == 0) {
                        navTab.find('.nav-tab-title-js').after(' <i class="fa fa-exclamation-circle text-danger val-error val-error-icon"></i>')
                    }

                }

                //End wizard tabs.

            } else {
                console.log(key + ' input not found to show its error validation');
            }

        });
    }

    $('body').on('click', 'a.additional-imgs-item, form a.single-image, div.sidebar-user a.show-user-image', function() {
        var clickedImgAnchor = $(this);
        var imgHref = clickedImgAnchor.data('imgHref');
        $.ajax({
            type: 'POST',
            url: imgHref,
            success: function(response) {
                $('div#imgs-modal').html(response);
                if (response.noImage) {
                    $('div#imgs-modal').html('');
                } else {
                    $('#view_single_image').modal('show');
                }
            },
            error: function(x) {
                crud_handle_server_errors(x);
            }
        });
        return false;
    });



    $('body').on('submit', 'form.delete-img-ajax', function(e) {
        var form = $(this);

        bootbox.confirm({
            title: Lang.get('responseMessages.confirmation'),
            size: "small",
            message: Lang.get('responseMessages.confirm-deletion'),
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ' + Lang.get('responseMessages.cancel')
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ' + Lang.get('responseMessages.confirm'),
                    className: "btn-danger"
                }
            },
            callback: function(result) {
                if (result) {
                    $.ajax({
                        type: 'POST',
                        data: form.serialize(),
                        url: form.attr('action'),
                        success: function(response) {

                            if (response.deleteStatus) {
                                var inputName = response.inputName;

                                if (response.type == 'single') {
                                    if ($('input[name="' + response.inputName + '"]').length) {
                                        $('input[name="' + response.inputName + '"]').parents('div.img-media').find('div.img-container').html("");
                                    }

                                    // for delete profile img from sidebar
                                    if (form.hasClass('delete-admin-profile-image') && inputName == 'image') {
                                        $('div.side-header img.profile-img').attr('src', originPath + '/backend/assets/img/avatars/avatar10.jpg');
                                    }

                                } else if (response.type == 'multiple') {
                                    $('#' + inputName + '-additional-images').find('.gallery-img-' + response.imgId).remove();
                                }

                                $('#view_single_image').modal('hide');

                                $.notify({
                                    message: response.message,
                                }, {
                                    // settings
                                    type: 'success'
                                });

                            } else {

                                $.notify({
                                    message: response.message,
                                }, {
                                    // settings
                                    type: 'danger'
                                });
                            }
                        },
                        error: function(x) {
                            crud_handle_server_errors(x);
                        },
                        complete: function(data) {

                            /**** callback****/

                            /**** callback****/
                        }
                    });
                }
            }
        });

        return false;
    });


    // send delete action request using bootbox and ajax.
    $(".table-delete-action").on("click",
        ".delete-action",
        function() {
            var clickedBtn = $(this);

            var datatable = clickedBtn.parents('table').dataTable();
            bootbox.confirm({
                title: "<div class='text-center'>" + Lang.get('responseMessages.confirmation') + "</div>",
                message: "<div>" + Lang.get('responseMessages.confirm-deletion') + "</div>",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> ' + Lang.get('responseMessages.cancel')
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> ' + Lang.get('responseMessages.confirm'),
                        className: "btn-danger"
                    }
                },
                callback: function(result) {
                    if (result) {
                        $.ajax({
                            url: clickedBtn.attr("href"),
                            method: "POST",
                            data: {
                                "_method": "DELETE"
                            },
                            success: function(responseData) {

                                if (responseData.deleteStatus) {

                                    var clickedTr = clickedBtn.parents('tr');
                                    clickedTr.fadeOut('slow', function() {
                                        datatable.fnDeleteRow($(this)); //this for clickedTr
                                    });

                                } else {

                                    var errorMsg = responseData.error;
                                    bootbox.alert({
                                        size: "small",
                                        title: "<p class='text-danger'>" + Lang.get('responseMessages.error') + "</p>",
                                        message: "<p class='text-danger'>" + errorMsg + "<p>",
                                        buttons: {
                                            ok: {
                                                label: '<i class="fa fa-check"></i> ' + Lang.get('responseMessages.cancel'),
                                            }
                                        }
                                    });

                                }
                            },
                            error: function(x) {
                                crud_handle_server_errors(x);
                            },
                            complete: function(data) {

                                /**** callback****/

                                /**** callback****/
                            }
                        });
                    }
                }
            });

            return false;
        });


    window.crud_handle_server_errors = function(data, form = null) {

        var statusCode = data.status;

        switch (statusCode) {

            case 422: // validation error.

                crud_handle_validation_errors(data, form);
                break;

            case 401: // Authentication error.

                $.notify({
                    message: 'Unauthenticated, please refresh the page.'
                    // message: Lang.get('responseMessages.some-error-happend'),
                }, {
                    // settings
                    type: 'danger'
                });
                break;

            case 419: // CSRF Token error.

                $.notify({
                    message: 'Token Expired, Please refresh the page.'
                    // message: Lang.get('responseMessages.some-error-happend'),
                }, {
                    // settings
                    type: 'danger'
                });
                break;

            case 500: // server error.

                $.notify({
                    message: 'Server Error.'
                    // message: Lang.get('responseMessages.some-error-happend'),
                }, {
                    // settings
                    type: 'danger'
                });
                break;

            default: // unknown error

                $.notify({
                    message: 'Something error happened.'
                    // message: Lang.get('responseMessages.some-error-happend'),
                }, {
                    // settings
                    type: 'danger'
                });
                break;
        }
    }

})(jQuery);
