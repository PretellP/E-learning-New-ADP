"use strict";

$(function() {

    /*---- NAVBAR SCROLL ----*/

    var recomendedCourses = $(".recomended-courses");
    var navbar = $(".navbar")
    var navbarBg = $(".navbar-bg")

    $(window).scroll(function() {    
        var scroll_height = $(window).scrollTop();

        if(scroll_height >= 70){
            navbar.addClass('fixed')
            navbarBg.addClass('fixed')
        }else{
            navbarBg.removeClass('fixed')
            navbar.removeClass('fixed')
        }
    
        if (scroll_height >= 180) {
            recomendedCourses.addClass('fixed')
        } else {
            recomendedCourses.removeClass("fixed")
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