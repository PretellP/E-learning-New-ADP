"use strict";

$(function() {

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

    const SwalDelete = Swal.mixin({
        title: '¿Estás seguro?',
        text: "¡Esta acción no podrá ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '¡Sí!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
    })

    /*---- NAVBAR SCROLL ----*/

    var videContainer = $(".video-container")
    var lateralMenu = $(".lateral-menu")

    $(window).scroll(function() {    
        var scroll_height = $(window).scrollTop();
        var windows_width = $(window).width();

        if(scroll_height >= 150 && windows_width >= 1200){
            lateralMenu.addClass('fixed')
            videContainer.addClass('fixed')
        }else{
            lateralMenu.removeClass('fixed')
            videContainer.removeClass('fixed')
        }
    })


    /* ------- MODALS GET DATA ------------*/



    $('#instructions-modal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var url = button.data('url')
        var sendUrl = button.data('send')
        var modal = $(this)

        $.ajax({
            type: "GET",
            url: sendUrl,
            dataType: "JSON",
            success: function (response) 
            {
                var ev_time = response.total_time
                var qst_time = response.question_time

                modal.find('.ev-time').text(ev_time)  
                modal.find('.qst-time').text(qst_time)
            },
            error: function(response){
            },
        });

        modal.find('.evaluation-start-form').attr('action', url)
    })

    $('.evaluation-start-form').on('submit', function () {
        var button = $(this).find('#btn-start-evaluation')
        button.attr('disabled', 'disabled')
    })



    /*--------- PROFLE USER AVATAR -----------*/


    if ($('#user_avatar_edit_modal').length) {

        var avatarEditModal = $('#user_avatar_edit_modal').iziModal({
            overlayColor: 'rgba(0, 0, 0, 0.6)',
            theme: 'light',
            headerColor: '#53afbe',
            closeButton: true,
            iconText: '<i class="fa-solid fa-pen-to-square"></i>',
            padding: 25,
            width: 400,
        })  

        var userAvatarForm = $('#edit-user-avatar-form').validate({
            rules: {
                image: {
                    required: true
                },
            },
            submitHandler: function (form, event) {
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#user_avatar_edit_modal')
                var img_holder = form.find('.img-holder')

                loadSpinner.toggleClass('active')
                form.find('.btn-save').attr('disabled', 'disabled')

                var formData = new FormData(form[0])

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {

                        if (data.success) {

                            let avatarContainer = $('#profile-avatar-container')
                            let sidebarImageContainer = $('#sidebar-avatar-img')
    
                            avatarContainer.html(data.htmlAvatar)
                            sidebarImageContainer.html(data.htmlSidebarAvatar)
    
                            $(img_holder).empty()
    
                            Toast.fire({
                                icon: 'success',
                                text: data.message
                            })
                        } 
                        else {
                            Toast.fire({
                                icon: 'error',
                                text: data.message
                            })
                        }
                    },
                    complete: function (data) {
                        avatarEditModal.iziModal('close')
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

        $('html').on("change", '#input-user-avatar-edit', function () {

            var inputAvatarEdit = $(this)

            $('#edit-user-avatar-form').validate()
            $('#input-user-avatar-edit').rules('add', { required: true })
    
            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#edit-user-avatar-form').find('.img-holder');
            var currentImagePath = $(this).data('value');
            var img_extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();
    
            if (img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png') {
                if (typeof (FileReader) != 'undefined') {
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('<img/>', { 'src': e.target.result, 'class': 'img-fluid avatar_img' }).
                            appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            } else {
                $(img_holder).html(currentImagePath);
                inputAvatarEdit.val('')
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!',
                });
            }
        })

        $('html').on('click', '.edit-avatar-btn', function () {

            $('#edit-user-avatar-form').validate()
            $('#input-user-avatar-edit').rules('remove', 'required')

            var form = avatarEditModal.find('#edit-user-avatar-form')

            $.ajax({
                type: 'GET',
                url: $(this).data('url'),
                dataType: 'JSON',
                success: function (data) {

                    avatarEditModal.find('.img-holder').html('<img class="img-fluid avatar_img" id="image-user-avatar-edit" src="' + data.url_img + '"></img>');
                    avatarEditModal.find('#input-user-avatar-edit').attr('data-value', '<img scr="' + data.url_img + '" class="img-fluid avatar_img"');
                    avatarEditModal.find('#input-user-avatar-edit').val('');

                },
                complete: function (data) {
                    avatarEditModal.iziModal('open')
                },
                error: function (data) {
                    ToastError.fire()
                }
            })
        })

    }

    /* --------- EDIT PASSWORD -------*/

    $('html').on('click', '.btn-unlock-edit', function () {
        var form = $(this).closest('form')
        let icon = $(this).find('i')

        if (icon.hasClass('active')) {
            icon.removeClass('active')
            form.find('input').attr('disabled', 'disabled')
            form.find('button').attr('disabled', 'disabled')
        }
        else {
            icon.addClass('active')

            form.find('input').removeAttr('disabled')
            form.find('button').removeAttr('disabled')

        }
    })

    const iconView = '<i class="fa-solid fa-eye"></i>'
    const iconHide = '<i class="fa-solid fa-eye-slash"></i>'


    /* --------- CHANGE VIEW PASSWORD ----------*/

    $('html').on('click', '.change-view-password', function () {

        var iconCont = $(this).find('.input-group-text')
        var input = $(this).siblings('input')

        if (!input.attr('disabled')) {
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text')
                iconCont.html(iconHide)
            }
            else {
                input.attr('type', 'password')
                iconCont.html(iconView)
            }
        }


    })

    if ($('#user_password_update_form').length) {

        var updatePasswordForm = $('#user_password_update_form').validate({
            rules: {
                old_password: {
                    required: true,
                    maxlength: 100
                },
                new_password: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function (form, event) {
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
    
                loadSpinner.toggleClass('active')
                form.find('.btn-save').attr('disabled', 'disabled')
                form.find('.error-credentials-message').addClass('hide')
    
                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function (data) {
    
                        if (data.success) {
    
                            let formContainer = $('#user_password_update_form')
                            formContainer.html(data.htmlForm)
    
                            Toast.fire({
                                icon: 'success',
                                text: data.message
                            })
                        } 
                        else {
                            form.find('.error-credentials-message').removeClass('hide')
                            form.find('.btn-save').removeAttr('disabled')
                        }
                    },
                    complete: function (data) {
                        loadSpinner.toggleClass('active')
                        updatePasswordForm.resetForm()
                        form.trigger('reset')

                    },
                    error: function (data) {
                        console.log(data)
                        ToastError.fire()
                    }
                })
            }
        })
    }

   
   
 


  





    
    // QUIZ ---------------------------------

    // Aviso para seleccionar al menos una opción 


    $('.button-submit').click(function(){
        if(!$("input[name='alternative[]']:checked").val())
        {
            $(".alert-container").addClass("active");
        }
    })

    $('#quizStep').submit(function(e){
        if (!$('.alternative').is(':checked')){
            e.preventDefault();
        }
    })

    $('#matchingQuiz').submit(function (e) {
        var flgSelected = false;
        $(".droppable_input").each(function(){
            if ($(this).val())
            {
                flgSelected = true;
                return false;
            }
        })
        if(!flgSelected)
        {
            $(".alert-container").addClass("active");
            e.preventDefault();
        }
    })




    /* ---- ACTIVE SECTIONS TAB -----*/




    $(".collapse-sections").each(function(){

        if($(this).hasClass('show'))
        {
           $(this).parent().find('.card-header').addClass('active');
        }
    })

    $(".button-section-tab").click(function(){

        var collapseSection = $(this).closest(".section-accordion").find(".collapse-sections");

        if(collapseSection.hasClass('show'))
        {
            $(this).closest(".card-header").removeClass('active');
        }
        else{
            $(this).closest(".card-header").addClass('active');
        }

        $(this).closest(".section-accordion").siblings().find('.card-header').removeClass('active');

    })



      /*----- VIDEO GET CURRENT PLAY TIME ------*/


    var videoElement = videojs.getPlayer('chapter-video');

    if(jQuery.type(videoElement) != 'undefined')
    {
        var dataChapterInput = $('#url-input-video');
        var url = dataChapterInput.val();
        var setTime = dataChapterInput.data('time');
        var chapterId = dataChapterInput.data('id');
        var iconCheck = '<i class="fa-solid fa-circle-check"></i>';
        var iconNoCheck = '<i class="fa-regular fa-circle"></i>';

        function SetTimeProgress()
        {
            var totalVideoDuration = videoElement.duration();
            var currentTime = videoElement.currentTime();
            var data = {time: currentTime, duration: totalVideoDuration};
            var headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
    
            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                dataType: "JSON",
                headers: headers,
                success: function (response)
                { 
                    if(response.check)
                    {
                        $('#check-chapter-icon-'+chapterId).html(iconCheck);
                    }
                    else{
                        $('#check-chapter-icon-'+chapterId).html(iconNoCheck);
                    }
                }
            })
        }
    
        let timeVideoUpdate;
    
        videoElement.on('playing', () => {
            timeVideoUpdate = setInterval(SetTimeProgress, 5000);
            $('.video-label-top').removeClass('paused')
            $('.btn-navigation-chapter').removeClass('paused')
            $('.btn-next-chapter-video').removeClass('ended')
        })
    
        videoElement.on('pause', () =>{
            clearInterval(timeVideoUpdate);
            $('.video-label-top').addClass('paused')
            $('.btn-navigation-chapter').addClass('paused')
        }) 
    
        videoElement.on('ended', ()=>{
            $('.btn-next-chapter-video').addClass('ended')
        })
    
        videoElement.currentTime(setTime);
    }



    /* ------- OWL CAROUSEL 2 ---------*/

    var publiCarousel = $('#publishings-owlcarousel');

    if(publiCarousel.length)
    {
        publiCarousel.owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>']
        });
    }




    /*------------ IZITOAST ------------*/
    
    $('#survey-form').submit(function(e){
        var flginputSelect = true;
        $('.input-radio-survey').each(function(){
            var name = $(this).attr('name');
            if(!$("input[name='"+name+"']").is(':checked'))
            {
                flginputSelect = false
                return false
            }
        })
        $('.input-commentary-survey').each(function(){
            if (!$(this).val()) {
                flginputSelect = false
                return false
            }
        })

        if(!flginputSelect)
        {
            e.preventDefault();
            iziToast.warning({
                        title: '¡Responde todas las preguntas antes de continuar!',
                        position: 'topRight'
                    })
        }
    })





// Drop and Drag QUIZ


    const draggable_options = {
        addClasses: true,
        revert: 'invalid',
        revertDuration: 200,
        helper: 'clone',
        start: function (event, ui) {
            $(this).addClass('dragged')
        },
        stop: function (event, ui) {
            if(!$(this).hasClass('dropped')){
                $(this).removeClass('dragged')
            }
        }
    }

    $('#draggable-section').droppable({
        accept: '.drag-drop'
    })

    // $( ".drag" ).draggable(draggable_options);

    $('.drag-drop').draggable({
        revert: 'invalid',
        revertDuration: 200,
    })


    $( ".drag:not(.dragged.dropped, .drag-drop)" ).draggable(draggable_options);


    $( ".drop" ).droppable({
        accept: ".drag",
        over: function(event, ui){
            $(this).addClass('droppable-hover')
        },
        out: function(event, ui){
            $(this).removeClass('droppable-hover')
        }
    });
    

    $( ".drop" ).on( "drop", function( event, ui ) {
        var drag = ui.draggable
        let id = drag.attr('id')
        var currentValue = $(this).find('input').val()

        if($(this).find('.drag-drop').length){

            let currentDrop = $(this).find('.drag-drop')
            let currentId = currentDrop.attr('id')

            if(drag.hasClass('drag-drop')){
                let parent = drag.closest('.drop')

                currentDrop.appendTo(parent)
                parent.find('input').val(currentValue)
            } 
            else {
                let cont_box = $('#draggable-section')
                let related_drag = cont_box.find('.drag#'+currentId)
                related_drag.removeClass('dropped dragged')
                related_drag.draggable(draggable_options)
                currentDrop.remove()
            }
        }

        $(this).removeClass('droppable-hover').find('input').val(id)

        var clone = drag.clone()

        clone.removeClass('dragged')
        clone.addClass('drag-drop').appendTo($(this))
        clone.css({
            top: 0,
            left: 0,
        })

        $(this).addClass('dropped without-img')

        clone.draggable({
            revert: 'invalid',
            revertDuration: 200,
        })


        if (drag.hasClass('drag-drop')) {
            let parent = drag.closest('.drop')
            parent.find('input').val(currentValue)
            if(parent.attr('id') != $(this).attr('id')){
                parent.removeClass('dropped')
            }
            drag.remove()
        }
        else{
            drag.addClass('dropped')
            drag.draggable('option', 'revert', true)
            drag.draggable('option', 'revertDuration', 0)
            drag.draggable('destroy')    
        }

    });

    $("#draggable-section").on('drop', function (event, ui){
        var drag = ui.draggable
        var parent = drag.closest('.drop')
        parent.find('input').val('')
        parent.removeClass('dropped')

        var related_drag = $(this).find('.drag#'+drag.attr('id'))
        related_drag.removeClass('dropped dragged')
        related_drag.draggable(draggable_options)

        drag.remove()
        console.log('si funka')
    })





    
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

});





// Drop and Drag QUIZ - OLD


// const draggableElements = document.querySelectorAll(".draggable");
// const droppableElements = document.querySelectorAll(".droppable");

// window.addEventListener("load", function() {
//     droppableElements.forEach(e =>{
//         const input_value_slc = e.querySelector("input").value;

//         if(input_value_slc != "")
//         {
//             const draggable_select = document.getElementById(input_value_slc);
//             const draggableImgUrl = draggable_select.querySelector("img").src;
//             const draggableSelectBgColor = (getComputedStyle(draggable_select)).backgroundColor;

//             draggable_select.classList.add("dragged");
//             draggable_select.setAttribute("draggable", "false");
//             e.querySelector("img").src = draggableImgUrl;
//             e.setAttribute("draggable", "true");
//             e.querySelector("span").textContent = draggable_select.querySelector("span").textContent;
//             e.style.backgroundColor = draggableSelectBgColor;
//             e.classList.add("dropped");
//         }
        
//     });
// });

// draggableElements.forEach(elem => {
//     elem.addEventListener("dragstart", dragStart);
// });

// droppableElements.forEach(elem => {
//     elem.addEventListener("dragstart", droppableDragStart);
//     elem.addEventListener("dragenter", dragEnter);
//     elem.addEventListener("dragleave", dragLeave);
//     elem.addEventListener("dragover", dragOver);
//     elem.addEventListener("drop", drop);
// });

// function dragStart(event){
//     event.dataTransfer.clearData();
//     event.dataTransfer.setData("id", event.target.getAttribute('id'));
// }

// function droppableDragStart(event){
//     event.dataTransfer.clearData();
//     const droppableInput = event.target.querySelector("input");
//     const inputValue = droppableInput.value;
//     const dpDgElementValue = event.target.getAttribute("id");
//     event.dataTransfer.setData("id", inputValue);
//     event.dataTransfer.setData("text", dpDgElementValue);
// }

// function dragEnter(event){
//     event.target.classList.add("droppable-hover");

// }

// function dragLeave(event){
//     event.target.classList.remove("droppable-hover");
// }

// function dragOver(event){

//     event.preventDefault();
// }

// function drop(event){

//     let draggableElementdata; 
//     let draggableElement; 

//     draggableElementdata = event.dataTransfer.getData("id");

//     if(draggableElementdata != "")
//     {
//         if(!(event.dataTransfer.getData("text") == ''))
//         {
//             const dpDgElementData = event.dataTransfer.getData("text");
//             draggableElement = document.getElementById(dpDgElementData);
//         }
//         else
//         {
//             draggableElement =  document.getElementById(draggableElementdata);
//         }


//         if(!(event.target.classList.contains("dropped")) || !(draggableElement.classList.contains("draggable")))
//         {
//             event.preventDefault();
//             event.target.setAttribute("draggable", "true");

//             const droppableInputElement = event.target.querySelector("input");
//             const droppableImgElement = event.target.querySelector("img");
//             const droppableImgUrl = droppableImgElement.src;
//             const draggableElementBgColor = (getComputedStyle(draggableElement)).backgroundColor;
//             const draggableSpanTextContext = draggableElement.querySelector("span").textContent;
//             const draggableImgElement = draggableElement.querySelector("img");
//             const draggableImgUrl = draggableImgElement.src;

//             if(draggableElement.classList.contains("droppable"))
//             {
//                 const droppableBgColor = (getComputedStyle(event.target)).backgroundColor;
                
//                 draggableElement.style.backgroundColor = droppableBgColor;

//                 if(!(event.target.classList.contains("dropped")))
//                 {
//                     draggableElement.classList.remove("dropped");
//                 }
//                 if(droppableInputElement.value == "")
//                 {
//                     draggableElement.setAttribute("draggable", "false");
//                 }

//                 draggableImgElement.src = droppableImgUrl;
//                 draggableElement.querySelector("input").value = droppableInputElement.value;
//                 draggableElement.querySelector("span").textContent = event.target.querySelector("span").textContent;
//             }
//             else
//             {
//                 draggableElement.classList.add("dragged");
//                 draggableElement.setAttribute("draggable", "false");
//             }

//             droppableInputElement.value = draggableElementdata;
//             droppableImgElement.src = draggableImgUrl;

//             event.target.classList.add("dropped");
//             event.target.style.backgroundColor = draggableElementBgColor;

//             event.target.querySelector("span").textContent = draggableSpanTextContext;
//         }
//     }
    
    

//     event.target.classList.remove("droppable-hover");

// }