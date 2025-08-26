(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();
    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Team carousel
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: false,
        dots: false,
        loop: true,
        margin: 50,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });


    // Testimonial carousel

    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: true,
        dots: true,
        loop: true,
        margin: 0,
        nav : true,
        navText: false,
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });


     // Fact Counter

     $(document).ready(function(){
        $('.counter-value').each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            },{
                duration: 2000,
                easing: 'easeInQuad',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });

        var form = $("#signup-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                email: {
                    email: true
                }
            },
            onfocusout: function(element) {
                $(element).valid();
            },
        });
        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            stepsOrientation: "vertical",
            titleTemplate: '<div class="title"><span class="step-number">#index#</span><span class="step-text">#title#</span></div>',
            labels: {
                previous: 'Previous',
                next: 'Next',
                finish: 'Finish',
                current: ''
            },
            onStepChanging: function(event, currentIndex, newIndex) {
                if (currentIndex === 0) {
                    form.parent().parent().parent().append('<div class="footer footer-' + currentIndex + '"></div>');
                }
                if (currentIndex === 1) {
                    form.parent().parent().parent().find('.footer').removeClass('footer-0').addClass('footer-' + currentIndex + '');
                }
                if (currentIndex === 2) {
                    form.parent().parent().parent().find('.footer').removeClass('footer-1').addClass('footer-' + currentIndex + '');
                }
                if (currentIndex === 3) {
                    form.parent().parent().parent().find('.footer').removeClass('footer-2').addClass('footer-' + currentIndex + '');
                }
                // if(currentIndex === 4) {
                //     form.parent().parent().parent().append('<div class="footer" style="height:752px;"></div>');
                // }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                alert('Submited');
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
    
                return true;
            }
        });
    
        jQuery.extend(jQuery.validator.messages, {
            required: "",
            remote: "",
            email: "",
            url: "",
            date: "",
            dateISO: "",
            number: "",
            digits: "",
            creditcard: "",
            equalTo: ""
        });
    
        $.dobPicker({
            daySelector: '#birth_date',
            monthSelector: '#birth_month',
            yearSelector: '#birth_year',
            dayDefault: '',
            monthDefault: '',
            yearDefault: '',
            minimumAge: 0,
            maximumAge: 120
        });
        var marginSlider = document.getElementById('slider-margin');
        if (marginSlider != undefined) {
            noUiSlider.create(marginSlider, {
                  start: [1100],
                  step: 100,
                  connect: [true, false],
                  tooltips: [true],
                  range: {
                      'min': 100,
                      'max': 2000
                  },
                  pips: {
                        mode: 'values',
                        values: [100, 2000],
                        density: 4
                        },
                    format: wNumb({
                        decimals: 0,
                        thousand: '',
                        prefix: '$ ',
                    })
            });
            var marginMin = document.getElementById('value-lower'),
            marginMax = document.getElementById('value-upper');
    
            marginSlider.noUiSlider.on('update', function ( values, handle ) {
                if ( handle ) {
                    marginMax.innerHTML = values[handle];
                } else {
                    marginMin.innerHTML = values[handle];
                }
            });
        }
   


})(jQuery);

