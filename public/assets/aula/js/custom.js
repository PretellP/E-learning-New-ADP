"use strict";

$(function() {

    /*---- NAVBAR SCROLL ----*/

    var videContainer = $(".video-container")
    var lateralMenu = $(".lateral-menu")

    $(window).scroll(function() {    
        var scroll_height = $(window).scrollTop();

        if(scroll_height >= 275){
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
                flginputSelect = false;
                return false;
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


});





// Drop and Drag QUIZ


const draggableElements = document.querySelectorAll(".draggable");
const droppableElements = document.querySelectorAll(".droppable");

window.addEventListener("load", function() {
    droppableElements.forEach(e =>{
        const input_value_slc = e.querySelector("input").value;

        if(input_value_slc != "")
        {
            const draggable_select = document.getElementById(input_value_slc);
            const draggableImgUrl = draggable_select.querySelector("img").src;
            const draggableSelectBgColor = (getComputedStyle(draggable_select)).backgroundColor;

            draggable_select.classList.add("dragged");
            draggable_select.setAttribute("draggable", "false");
            e.querySelector("img").src = draggableImgUrl;
            e.setAttribute("draggable", "true");
            e.querySelector("span").textContent = draggable_select.querySelector("span").textContent;
            e.style.backgroundColor = draggableSelectBgColor;
            e.classList.add("dropped");
        }
        
    });
});

draggableElements.forEach(elem => {
    elem.addEventListener("dragstart", dragStart);
});

droppableElements.forEach(elem => {
    elem.addEventListener("dragstart", droppableDragStart);
    elem.addEventListener("dragenter", dragEnter);
    elem.addEventListener("dragleave", dragLeave);
    elem.addEventListener("dragover", dragOver);
    elem.addEventListener("drop", drop);
});

function dragStart(event){
    event.dataTransfer.clearData();
    event.dataTransfer.setData("id", event.target.getAttribute('id'));
}

function droppableDragStart(event){
    event.dataTransfer.clearData();
    const droppableInput = event.target.querySelector("input");
    const inputValue = droppableInput.value;
    const dpDgElementValue = event.target.getAttribute("id");
    event.dataTransfer.setData("id", inputValue);
    event.dataTransfer.setData("text", dpDgElementValue);
}

function dragEnter(event){
    event.target.classList.add("droppable-hover");

}

function dragLeave(event){
    event.target.classList.remove("droppable-hover");
}

function dragOver(event){

    event.preventDefault();
}

function drop(event){

    let draggableElementdata; 
    let draggableElement; 

    draggableElementdata = event.dataTransfer.getData("id");

    if(draggableElementdata != "")
    {
        if(!(event.dataTransfer.getData("text") == ''))
        {
            const dpDgElementData = event.dataTransfer.getData("text");
            draggableElement = document.getElementById(dpDgElementData);
        }
        else
        {
            draggableElement =  document.getElementById(draggableElementdata);
        }


        if(!(event.target.classList.contains("dropped")) || !(draggableElement.classList.contains("draggable")))
        {
            event.preventDefault();
            event.target.setAttribute("draggable", "true");

            const droppableInputElement = event.target.querySelector("input");
            const droppableImgElement = event.target.querySelector("img");
            const droppableImgUrl = droppableImgElement.src;
            const draggableElementBgColor = (getComputedStyle(draggableElement)).backgroundColor;
            const draggableSpanTextContext = draggableElement.querySelector("span").textContent;
            const draggableImgElement = draggableElement.querySelector("img");
            const draggableImgUrl = draggableImgElement.src;

            if(draggableElement.classList.contains("droppable"))
            {
                const droppableBgColor = (getComputedStyle(event.target)).backgroundColor;
                
                draggableElement.style.backgroundColor = droppableBgColor;

                if(!(event.target.classList.contains("dropped")))
                {
                    draggableElement.classList.remove("dropped");
                }
                if(droppableInputElement.value == "")
                {
                    draggableElement.setAttribute("draggable", "false");
                }

                draggableImgElement.src = droppableImgUrl;
                draggableElement.querySelector("input").value = droppableInputElement.value;
                draggableElement.querySelector("span").textContent = event.target.querySelector("span").textContent;
            }
            else
            {
                draggableElement.classList.add("dragged");
                draggableElement.setAttribute("draggable", "false");
            }

            droppableInputElement.value = draggableElementdata;
            droppableImgElement.src = draggableImgUrl;

            event.target.classList.add("dropped");
            event.target.style.backgroundColor = draggableElementBgColor;

            event.target.querySelector("span").textContent = draggableSpanTextContext;
        }
    }
    
    

    event.target.classList.remove("droppable-hover");

}