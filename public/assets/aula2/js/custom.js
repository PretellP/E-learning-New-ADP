"use strict";

$(function() {

    var recomendedCourses = $(".recomended-courses");
    var navbar = $(".navbar");
    var navbarBg = $(".navbar-bg");

    $(window).scroll(function() {    
        var scroll_height = $(window).scrollTop();

        if(scroll_height >= 70){
            navbar.addClass('fixed');
            navbarBg.addClass('fixed');
        }else{
            navbarBg.removeClass('fixed');
            navbar.removeClass('fixed');
        }
    
        if (scroll_height >= 180) {
            recomendedCourses.addClass('fixed');
        } else {
            recomendedCourses.removeClass("fixed");
        }
    });

});