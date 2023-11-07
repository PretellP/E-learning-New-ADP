$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    const ToastError = Swal.mixin({
        icon: 'error',
        text: '¡Ocurrió un error inesperado!',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    // $('.select2').select2();


    var UserSelfEventRegisterForm;
    var loginModalForm;
    var registerModalForm;

    const UserSelfEventRegisterRules = {
        dni: {
            required: true,
            maxlength: 11,
        },
        password: {
            required: true,
            maxlength: 255,
        },
    }


    if ($('#login_register_modal').length) {

        var loginRegisterModal;

        $('html').on('click', '.event_btn_register', function (e) {
            e.preventDefault();

            var url = $(this).data('url')
            var getDataUrl = $(this).data('send')

            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function (data) {

                    $('#login_register_modal').html(data.html)

                    loginRegisterModal = $('#login_register_modal').iziModal({
                        overlayClose: false,
                        overlayColor: 'rgba(0, 0, 0, 0.6)'
                    })
                },
                complete: function (data) {

                    UserSelfEventRegisterForm = $('#user-self-event-register-form')
                    loginModalForm = $('#form-modal-login')
                    registerModalForm = $('#register-form-modal')

                    $('.select2').select2()

                    if (UserSelfEventRegisterForm.length) {

                        UserSelfEventRegisterForm.attr('action', url)

                        var userCertRegister = UserSelfEventRegisterForm.validate({

                            rules: UserSelfEventRegisterRules,
                            submitHandler: function (form, event) {
                                event.preventDefault()
                                var form = $(form)
                                var loadSpinner = form.find('.loadSpinner')

                                form.find('.error-credentials-message').addClass('hide')

                                loadSpinner.toggleClass('active')
                                form.find('.btn-save').attr('disabled', 'disabled')

                                $.ajax({
                                    method: form.attr('method'),
                                    url: form.attr('action'),
                                    data: form.serialize(),
                                    dataType: 'JSON',
                                    success: function (data) {

                                        if (data.success) {

                                            var modalContent = $('#login_register_modal')
                                            var eventsList = $('#events-list-container')
                                            modalContent.html(data.html)
                                            eventsList.html(data.htmlEvents)

                                        }
                                        else {
                                            form.find('.error-credentials-message').removeClass('hide')
                                        }
                                    },
                                    complete: function (data) {
                                        userCertRegister.resetForm()
                                        form.trigger('reset')

                                        loadSpinner.toggleClass('active')
                                        form.find('.btn-save').removeAttr('disabled')
                                    },
                                    error: function (data) {
                                        console.log(data)
                                        ToastError.fire()
                                    }
                                })
                            }
                        })
                    }

                    if (loginModalForm.length) {

                        var userLoginForm = loginModalForm.validate({
                            rules: UserSelfEventRegisterRules,
                            submitHandler: function (form, event) {
                                event.preventDefault()
                                var form = $(form)
                                var loadSpinner = form.find('.loadSpinner')

                                form.closest('section').find('.error-credentials-message').addClass('hide')

                                loadSpinner.toggleClass('active')
                                form.find('.btn-save').attr('disabled', 'disabled')

                                $.ajax({
                                    method: form.attr('method'),
                                    url: form.attr('action'),
                                    data: {
                                        form: form.serialize(),
                                    },
                                    dataType: 'JSON',
                                    success: function (data) {

                                        if (data.success) {

                                            window.location.reload()
                                        }
                                        else {
                                            form.closest('section').find('.error-credentials-message').removeClass('hide')
                                        }
                                    },
                                    complete: function (data) {

                                        userLoginForm.resetForm()

                                        loadSpinner.toggleClass('active')
                                        form.find('.btn-save').removeAttr('disabled')
                                    },
                                    error: function (data) {
                                        console.log(data)
                                        ToastError.fire()
                                    }
                                })
                            }
                        })
                    }

                    if (registerModalForm.length) {

                        $('#registerCompanySelect').select2({
                            placeholder: 'Selecciona una empresa',
                            allowClear: true
                        })

                        // $('#registerMiningUnitsSelect').select2({
                        //     placeholder: 'Selecciona una o más unidades mineras',
                        //     closeOnSelect: false
                        // })

                        var userRegisterModalForm = registerModalForm.validate({
                            rules: {
                                dni: {
                                    required: true,
                                    maxlength: 11,
                                    remote: {
                                        url: $('#register-form-modal').data('validate'),
                                        type: 'GET',
                                        dataType: 'JSON',
                                        data: {
                                            dni: function () {
                                                return $('#register-form-modal').find('input[name=dni]').val()
                                            }
                                        }
                                    }
                                },
                                name: {
                                    required: true,
                                    maxlength: 255,
                                },
                                paternal: {
                                    required: true,
                                    maxlength: 255
                                },
                                maternal: {
                                    required: true,
                                    maxlength: 255
                                },
                                email: {
                                    required: true,
                                    maxlength: 255,
                                    email: true
                                },
                                // company_id: {
                                //     required: true
                                // },
                                // "mining_units_ids[]": {
                                //     required: true
                                // }
                            },
                            messages: {
                                dni: {
                                    remote: 'Este usuario ya está registrado'
                                }
                            },
                            submitHandler: function (form, event) {
                                event.preventDefault()
                                var form = $(form)
                                var loadSpinner = form.find('.loadSpinner')

                                form.closest('section').find('.error-credentials-message').addClass('hide')

                                loadSpinner.toggleClass('active')
                                form.find('.btn-save').attr('disabled', 'disabled')

                                $.ajax({
                                    method: form.attr('method'),
                                    url: form.attr('action'),
                                    data: form.serialize(),
                                    dataType: 'JSON',
                                    success: function (data) {

                                        if (data.success) {

                                            userRegisterModalForm.resetForm()
                                            form.trigger('reset')
                
                                            let messageContainer = $('#modal-register-form-container')
                                            messageContainer.html(data.html);
                                        }
                                        else {
                                            form.closest('section').find('.error-credentials-message').removeClass('hide')
                                        }
                                    },
                                    complete: function (data) {

                                        userRegisterModalForm.resetForm()

                                        loadSpinner.toggleClass('active')
                                        form.find('.btn-save').removeAttr('disabled')
                                    },
                                    error: function (data) {
                                        console.log(data)
                                        ToastError.fire()
                                    }
                                })
                            }
                        })
                    }

                    loginRegisterModal.iziModal('open')
                },
                error: function (data) {
                    console.log(data)
                    ToastError.fire()
                }
            })
        })

    }

    $("#login_register_modal").on('click', 'header a', function (event) {
        event.preventDefault();
        var index = $(this).index();
        $(this).addClass('active').siblings('a').removeClass('active');
        $(this).parents("div").find("section").eq(index).css('opacity', 0).fadeTo(1500, 1);

        $(this).parents("div").find("section").eq(index).removeClass('hide').siblings('section').addClass('hide').css('opacity', 0);

        if ($(this).index() === 0) {
            $("#login_register_modal .iziModal-content .icon-close").css('background', '#ddd');
        } else {
            $("#login_register_modal .iziModal-content .icon-close").attr('style', '');
        }
    });

    $(document).on('closed', '#login_register_modal', function (e) {
        $('#login_register_modal').iziModal('destroy')
    });







    jQuery.extend(jQuery.validator.messages, {
        required: '<i class="fa-solid fa-circle-exclamation"></i> &nbsp; Este campo es obligatorio',
        email: 'Ingrese un email válido',
        number: 'Por favor, ingresa un número válido',
        url: 'Por favor, ingresa una URL válida',
        max: jQuery.validator.format('Por favor, ingrese un valor menor o igual a {0}'),
        min: jQuery.validator.format('Por favor, ingrese un valor mayor o igual a {0}'),
        step: jQuery.validator.format("Ingrese un número múltiplo de {0}"),
        maxlength: jQuery.validator.format("Ingrese menos de {0} caracteres.")
    });

})