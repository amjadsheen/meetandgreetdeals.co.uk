/*global jQuery */
(function ($) {
    "use strict";

    jQuery(document).ready(function ($) {



        $("#collapsesssExamplebtn").on('click', (function (e) {
            $("#collapsesssExample").toggle();
        }));

        /*---------------------------------
         All Window Scroll Function Start
        --------------------------------- */
        $(window).scroll(function () {
            // Header Fix Js Here
            if ($(window).scrollTop() >= 200) {
                $('#header-area').addClass('fixTotop');
                // $(".logo").hide();
            } else {
                $('#header-area').removeClass('fixTotop');
                $(".logo").show();
            }

            // Scroll top Js Here
            if ($(window).scrollTop() >= 400) {
                $('.scroll-top').slideDown(400);
            } else {
                $('.scroll-top').slideUp(400);
            }
        });
        /*--------------------------------
         All Window Scroll Function End
        --------------------------------- */

        // Home Page 0ne Date Picker JS
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: today,
            maxDate: function () {
                return $('#endDate').val();
            }
        });

        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#startDate').val();
            }
        });

        // Partner Carousel
        if ($('.partner-content-wrap').length > 0) {
            $(".partner-content-wrap").owlCarousel({
                loop: true,
                margin: 15,
                autoplay: true,
                autoplayTimeout: 1500,
                nav: false,
                dots: false,
                rtl: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            }); // Partner Carousel End
        }
        // Partner Carousel
        /*$(".partner-content-wrap-news").owlCarousel({
            items: 1,
            margin: 15,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: false,
            dots: false,
            rtl: true,
            slideTransition: 'linear',
            autoplayHoverPause: true
        }); // Partner Carousel End*/


        // Funfact Count JS

        if ($('.counter').length > 0) {
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        }


        // Choose Popular Car Isotope
        $(".popucar-menu a, .home2-car-filter a").click(function () {

            $(".popucar-menu a, .home2-car-filter a").removeClass('active');
            $(this).addClass('active');

            var filterValue = $(this).attr('data-filter');
            $(".popular-car-gird").isotope({
                filter: filterValue
            });

            return false;
        }); // Choose Popular Car Isotope End


        // Choose Newest Car Isotope
        $(".newcar-menu a").click(function () {

            $(".newcar-menu a").removeClass('active');
            $(this).addClass('active');

            var filterValue = $(this).attr('data-filter');
            $(".newest-car-gird").isotope({
                filter: filterValue
            });

            return false;
        }); // Choose Newest Car Isotope End


        // Choose Car Maginific Popup
        if ($('.car-hover').length > 0) {
            $('.car-hover').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade'
            }); // Maginific Popup End
        }

        // Testimonial Carousel
        if ($('.testimonial-content').length > 0) {
            $(".testimonial-content").owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 3000,
                nav: false,
                dots: true
            });
        }
        // Testimonial Carousel End


        // Video Bg JS
        /*$('#mobileapp-video-bg').YTPlayer({
            fitToBackground: true,
            videoURL: 'm5_AKjDdqaU',
            containment: '#mobile-app-area',
            quality: 'highres',
            loop: true,
            showControls: false,
            opacity: 1,
            mute: true
        }); // Video Bg End*/

        // Click to Scroll TOP
        $(".scroll-top").click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 1500);
        }); //Scroll TOP End

        if ($('.mainmenu').length > 0) {
            // SlickNav or Mobile Menu
            $(".mainmenu").slicknav({
                'label': '',
                'prependTo': '#header-bottom .container .row'
            }); // SlickNav End
        }

        // Home Page Two Slideshow
        /*$("#slideslow-bg").vegas({
            overlay: true,
            transition: 'fade',
            transitionDuration: 2000,
            delay: 4000,
            color: '#000',
            animation: 'random',
            animationDuration: 20000,
            slides: [
                {
                    src: 'assets/img/slider-img/slider-img-1.jpg'
                },
                {
                    src: 'assets/img/slider-img/slider-img-2.jpg'
                },
                {
                    src: 'assets/img/slider-img/slider-img-3.jpg'
                },
                {
                    src: 'assets/img/slider-img/slider-img-4.jpg'
                }
            ]
        }); //Home Page Two Slideshow*/

        // Home Page Two Date Picker JS






        // Home Page 3 Slider Start
        /*$("#home-slider-area").owlCarousel({
            loop: true,
            items: 1,
            autoplay: true,
            autoplayHoverPause: false,
            autoplayTimeout: 3000,
            nav: false,
            dots: true,
            animateOut: 'slideOutDown',
            animateIn: 'slideInDown'
        });*/
        // Home Page 3 Slider End

        // Car Details Slider Start
        /*$(".car-preview-crousel").owlCarousel({
            loop: true,
            items: 1,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 2000,
            nav: false,
            dots: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn'
        });*/

        // Home 2 Service Carousel
        /*$(".service-container-wrap").owlCarousel({
            loop: true,
            items: 3,
            margin: 20,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 2000,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });*/


    }); //Ready Function End

    /*jQuery(window).load(function () {
        jQuery('.preloader').fadeOut();
        jQuery('.preloader-spinner').delay(350).fadeOut('slow');
        jQuery('body').removeClass('loader-active');
        jQuery(".popular-car-gird").isotope();
    }); //window load End
    */


}(jQuery));

jQuery(document).ready(function ($) {

    $(".btnrating").on('click', (function (e) {

        var previous_value = $("#rate").val();

        var selected_value = $(this).attr("data-attr");
        $("#rate").val(selected_value);

        $(".selected-rating").empty();
        $(".selected-rating").html(selected_value);

        for (i = 1; i <= selected_value; ++i) {
            $("#rating-star-" + i).toggleClass('btn-warning');
            $("#rating-star-" + i).toggleClass('btn-default');
        }

        for (ix = 1; ix <= previous_value; ++ix) {
            $("#rating-star-" + ix).toggleClass('btn-warning');
            $("#rating-star-" + ix).toggleClass('btn-default');
        }

    }));


});


// Disable form submissions if there are invalid fields
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



//$(".btn-submit").click(function(e){
$("#rev-form").submit(function (e) {

    e.preventDefault();
    //var data = $('rev-form').serialize();
    $.ajax({
        type: 'POST',
        url: '/reviews',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: $('#rev-form').serialize(),
        success: function (data) {
            // alert(data.success);
            $("#msg").html(data.success);
            $("#msg").show();
            $("#collapseExample").hide();
            $("#rev-form").trigger('reset');
        }
    });
});


function getTerminals() {
    var airport = document.getElementById("airport1").value;
    document.getElementById("discount_coupon").value = "";
    //document.getElementById("discount_value").innerHTML = "";
    document.getElementById("terminal").style.visibility = 'hidden';
    document.getElementById("return_terminal").style.visibility = 'hidden';
    document.getElementById("currency1").style.display = 'none';
    $('#loader').addClass('loader');
    $('#terminal').find('option').not(':first').remove();
    $('#return_terminal').find('option').not(':first').remove();
    $.ajax({
        url: 'getTerminals/' + airport,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        dataType: 'json',
        success: function (response) {
            $('#loader').removeClass('loader');
            document.getElementById("terminal").style.visibility = 'visible';
            document.getElementById("return_terminal").style.visibility = 'visible';
            var len = 0;
            if (response['data'] != null) {
                len = response['data'].length;
            }

            if (len > 0) {
                // Read data and create <option >
                for (var i = 0; i < len; i++) {
                    var id = response['data'][i].id;
                    var name = response['data'][i].ter_name;
                    var ter_disable = response['data'][i].ter_disable;
                    if (ter_disable == 1) {
                        var option = "<option disabled=\"disabled\" value='" + id + "'>" + name + '(booking closed)' + "</option>";
                    } else {
                        var option = "<option value='" + id + "'>" + name + "</option>";
                    }

                    $("#terminal").append(option);
                    $("#return_terminal").append(option);
                }
                document.getElementById("displayprice").innerHTML = "&nbsp;";
                document.getElementById("submit-errors").innerHTML = "&nbsp;";
                //document.getElementById("submit").disabled = true;
                //document.getElementById("terpro").innerHTML = "";
                document.getElementById("terminal").disabled = false;
            }
            //document.getElementById("terminal").style.visibility = 'visible';
        }
    });
}


function getairports() {
    var country =1;
    document.getElementById("discount_coupon").value = "";
    //document.getElementById("discount_value").innerHTML = "";
    document.getElementById("airport1").style.visibility = 'hidden';
    //document.getElementById("terminal").style.visibility = 'hidden';
    //document.getElementById("return_terminal").style.visibility = 'hidden';
    document.getElementById("currency1").style.display = 'none';
    //$('#loader').addClass('loader');
    $('#airport1').find('option').not(':first').remove();
    $('#terminal').find('option').not(':first').remove();
    $('#return_terminal').find('option').not(':first').remove();
    $.ajax({
        url: 'getairorts/' + country,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        dataType: 'json',
        success: function (response) {
            //$('#loader').removeClass('loader');
            document.getElementById("airport1").style.visibility = 'visible';
            var len = 0;
            if (response['data'] != null) {
                len = response['data'].length;
            }

            if (len > 0) {
                // Read data and create <option >
                for (var i = 0; i < len; i++) {
                    var id = response['data'][i].id;
                    var name = response['data'][i].airport_name;
                    var ter_disable = response['data'][i].airport_disable;
                    if (ter_disable == 1) {
                        var option = "<option disabled=\"disabled\" value='" + id + "'>" + name + '(booking closed)' + "</option>";
                    } else {
                        var option = "<option value='" + id + "'>" + name + "</option>";
                    }

                    $("#airport1").append(option);

                }
                document.getElementById("displayprice").innerHTML = "&nbsp;";
                document.getElementById("submit-errors").innerHTML = "&nbsp;";
                //document.getElementById("submit").disabled = true;
                //document.getElementById("terpro").innerHTML = "";
                document.getElementById("airport1").disabled = false;
            }
            //document.getElementById("terminal").style.visibility = 'visible';
        }
    });
}

function GetTef() {
    if ($('#tef').length > 0) {
        document.getElementById("mini-cart").style.visibility = 'hidden';
        document.getElementById("cart-content").style.visibility = 'hidden';
        var terminal_parking_fee =  document.getElementById('terminal_parking_fee').value;
        console.log('HERER');
        document.getElementById("tef").innerHTML = "";

        //var service = document.getElementById("service").value;
        
        //document.getElementById("terminal_parking_fee_div").style.display = "block";
        //var country =1;
       // var terminal = document.getElementById("terminal").value;
        //var currency1 = document.getElementById("currency1").value;
        //var bookingeditpage = 0;
        //if (service != "" && terminal != "") {

            $.ajax({
                type: 'GET',
                url: '/gettef',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    terminal_parking_fee: terminal_parking_fee,
                },
                success: function (res) {
                    console.log(res);

                    document.getElementById("tef").innerHTML = res.tef;
                    document.getElementById("mini-cart").innerHTML = res.mini_cart;
                    document.getElementById("cart-content").innerHTML = res.cart;
                    document.getElementById("apc").innerHTML = res.msg;
                    document.getElementById("mini-cart").style.visibility = 'visible';
                    document.getElementById("cart-content").style.visibility = 'visible';
                }
            });
        //}
    }
}

function calculatePrice() {
    document.getElementById("displayprice").innerHTML = "";
    var airport1 = document.getElementById("airport1").value;
    var service = document.getElementById("service").value;
    var country = 1;
    var terminal = document.getElementById("terminal").value;
    var date1 = document.getElementById("date1").value;
    var date2 = document.getElementById("date2").value;
    var discount_coupon = document.getElementById("discount_coupon").value;
    //var vip = $('input[name="vip"]:checked').val();
    var currency1 = document.getElementById("currency1").value;
    var terminal_parking_fee = document.getElementById("terminal_parking_fee").value;
    var vehical_num = document.getElementById("vehical_num").value;
    var bookingeditpage = 0;
    var vehical_type_id = 0;
    var carwash = 0;
    if (bookingeditpage > 0) {
        //var vehical_type_id = document.getElementById("vehical_type_id").value;
        var vehical_type_id = $("input[name='vehical_type_id']:checked").val();
        if ($('input[name="cwash"]').length > 0) {
            var rates = document.getElementsByName('cwash');
            for (var i = 0; i < rates.length; i++) {
                if (rates[i].checked) {
                    carwash = rates[i].value;
                }
            }
        }
    } else {
        //GetTef();
    }
    if (date1 != "" && date2 != "") {
        $('#loader').addClass('loader');
        $.ajax({
            type: 'GET',
            url: '/getprice',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                bookingeditpage: bookingeditpage,
                service: service,
                country: country,
                airport1: airport1,
                terminal: terminal,
                date1: date1,
                date2: date2,
                discount_coupon: discount_coupon,
                terminal_parking_fee: terminal_parking_fee,
                vehical_num: vehical_num,
                //vip: vip,
                cur_id: currency1,
                carwash: carwash,
                vehical_type_id: vehical_type_id
            },
            success: function (res) {
                // console.log(res);
                //GetTef();
                $('#loader').removeClass('loader');
                if (res.data == "1") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Select airport</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "2") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Airport closed for booking</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "4") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Select terminal</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "5") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Terminal closed for booking</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "3") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Select proper dates</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "6") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Departure date/time too close</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "7") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Current date/time past departure date/time</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "8") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Space not available on these date(s)</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "9") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Please Select Service</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "10") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Service Not Available</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                } else if (res.data == "11") {
                    document.getElementById("displayprice").innerHTML = "<span style='color:red;'><strong>Please Select Terminal Access Fee</strong></span>";
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = true;
                    }
                    document.getElementById("currency1").style.display = 'none';
                }

                else {


                    if (res.bookingeditpage == "1") {
                        if (res.showhide == "1") {
                            document.getElementById("edit-payment-methods").style.display = 'block';
                        } else {
                            document.getElementById("edit-payment-methods").style.display = 'none';
                        }
                        //document.getElementById("displaypricebottom").innerHTML = "<span style='color:green;'><strong>" + res.data + "</strong></spam>";
                    }

                    //document.getElementById("displayprice").innerHTML = "<span style='color:green;'><strong>" + res.data + "</strong></spam>";

                    //getallservicesprices(bookingeditpage, service, country, airport1, terminal, date1, date2, discount_coupon, currency1, carwash, vehical_type_id, terminal_parking_fee, vehical_num);
                    if (res.bookingeditpage == "0") {
                        //document.getElementById("submit").disabled = false;
                    }
                    document.getElementById("currency1").style.display = 'block';
                }
            }
        });
    }
}

function getallservicesprices(bookingeditpage, service, country, airport1, terminal, date1, date2, discount_coupon, currency1, carwash, vehical_type_id, terminal_parking_fee, vehical_num) {
    //document.getElementById("ajaxservice").innerHTML = '';
    $.ajax({
        type: 'GET',
        url: '/getallservicesprice',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            bookingeditpage: bookingeditpage,
            service: service,
            country: country,
            airport1: airport1,
            terminal: terminal,
            date1: date1,
            date2: date2,
            discount_coupon: discount_coupon,
            terminal_parking_fee: terminal_parking_fee,
            vehical_num: vehical_num,
            //vip: vip,
            cur_id: currency1,
            carwash: carwash,
            vehical_type_id: vehical_type_id
        },
        success: function (res) {
            document.getElementById("ajaxservice").innerHTML = res;
        }
    }
    );

}
function getDiscountCouponVip() {
    var terminal = document.getElementById("terminal").value;
    // var vip = $('input[name="vip"]:checked').val();
    var vip = document.getElementById("service").value;
    $('#loader').addClass('loader');
    $.ajax({
        type: 'GET',
        url: '/getDiscountCouponVip',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { terminal: terminal, vip: vip },
        success: function (data) {

            $('#loader').removeClass('loader');
            if (data == "0") {
                document.getElementById("discount_coupon").value = "";
                //document.getElementById("discount_value").innerHTML = "";

                calculatePrice();
            } else {
                var mystr = data;
                var myarr = mystr.split("|");
                document.getElementById("discount_coupon").value = myarr[0];
                //document.getElementById("discount_value").innerHTML = "<span style='color:blue;'><strong>" + myarr[1] + "% discount</span>";
                calculatePrice();
            }
            GetTef();
        }
    });
}

function updatecharging(charging) {
   
    // var charging = document.getElementById("charging").value;
     document.getElementById("mini-cart").style.visibility = 'hidden';
     document.getElementById("cart-content").style.visibility = 'hidden';
     $.ajax({
         type: 'GET',
         url: '/updatecharging',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         data: {
             charging:charging,
         },
         success: function (response) {
             console.log(response)
             document.getElementById("mini-cart").innerHTML = response.mini_cart; 
             document.getElementById("charging_fee").innerHTML = response.charging_fee;
             document.getElementById("mini-cart").style.visibility = 'visible';
             document.getElementById("cart-content").innerHTML = response.cart; 
             document.getElementById("cart-content").style.visibility = 'visible';
         },
         error: function (response) {
             //var error = "Username / Password not found";
             //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
         },
     });
     console.log('charging ---- ' + charging + ' --- ');
 }

$("#step_1_old").submit(function (e) {
    $('#loader').addClass('loader');
    //var redirect = document.getElementById("redirect").value;
    e.preventDefault();
    //var data = $('rev-form').serialize();
    $.ajax({
        type: 'POST',
        url: '/booking',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: $('#step_1').serialize(),
        success: function (data) {
            //alert(data);
            //document.getElementById("submit").disabled = true;
            $('#loader').removeClass('loader');
            if (data == "1") {
                document.getElementById("submit-errors").innerHTML = "<span style='color:green;'><strong>" + "Redirecting to Next Step..." + "</strong></spam>";
                //window.location.href = "/" + redirect;
            } else {
                document.getElementById("submit-errors").innerHTML = "<span style='color:red;'><strong>" + data + "</strong></spam>";
            }
        }
    });
});


$("#step_2").submit(function (e) {
    //alert("sdfsdfsdfsdf");
    // $('#loader').addClass('loader');
    document.getElementById("cardexceptionmsg").innerHTML = "";
    document.getElementById("cardexceptionmsg").style.display = 'none';

    document.getElementById("paylaterexceptionmsg").innerHTML ="";
    document.getElementById("paylaterexceptionmsg").style.display = 'none';

    e.preventDefault();
    if ($("#step_2").validationEngine('validate')) {
        e.preventDefault();

        if (document.getElementById("usestripe").value == "1") {
            Stripe.setPublishableKey($('#step_2').data('stripe-publishable-key'));
            Stripe.createToken({
              number: $('.card-number').val(),
              cvc: $('.card-cvc').val(),
              exp_month: $('.card-expiry-month').val(),
              exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);

        }else{
            document.getElementById("final-notice").style.display = 'block';
            $.ajax({
                type: 'POST',
                url: '/booking',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: $('#step_2').serialize(),
                success: function (data) {
                    
                    console.log(data.cardexception);
                    if (data.cardexception !== undefined) {
                        document.getElementById("cardexceptionmsg").innerHTML = data.message;
                        document.getElementById("cardexceptionmsg").style.display = 'block';
                        document.getElementById("final-notice").style.display = 'none';
                    }else if(data.paylaterexception == '1'){
                        document.getElementById("paylaterexceptionmsg").innerHTML = data.message;
                        document.getElementById("paylaterexceptionmsg").style.display = 'block';
                        
                    } else {
                        window.location.href = data.redirect;
                    }
                }
            });
        }
       
       
    }else{
         // Validation failed, scroll to the first error field immediately
         var firstErrorField = $(".formError").first(); // Assuming error messages have the "formError" class

         if (firstErrorField.length > 0) {
             $('html, body').animate({
             scrollTop: firstErrorField.offset().top
             }, 10);
         }
    }
});

function stripeResponseHandler(status, response) {
    if (response.error) {
            document.getElementById("cardexceptionmsg").innerHTML = response.error.message;
            document.getElementById("cardexceptionmsg").style.display = 'block';
            document.getElementById("final-notice").style.display = 'none';
    } else {
        /* token contains id, last4, and card type */
        var token = response['id'];
        $("#stripeToken").val(token)

        document.getElementById("final-notice").style.display = 'block';
        $.ajax({
            type: 'POST',
            url: '/booking',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $('#step_2').serialize(),
            success: function (data) {
                
                console.log(data.cardexception);
                if (data.cardexception !== undefined) {
                    document.getElementById("cardexceptionmsg").innerHTML = data.message;
                    document.getElementById("cardexceptionmsg").style.display = 'block';
                    document.getElementById("final-notice").style.display = 'none';
                } else {
                    window.location.href = data.redirect;
                }
            }
        });
    }
}

$(window).scroll(function (e) {
    // if($(window).width() >= 780) {
    //     var $el = $('.fixedElement');
    //     var isPositionFixed = ($el.css('position') == 'fixed');
    //     if ($(this).scrollTop() > 700 && !isPositionFixed) {
    //         $el.css({'position': 'fixed', 'top': '0px'});
    //     }
    //     if ($(this).scrollTop() < 700 && isPositionFixed) {
    //         $el.css({'position': 'static', 'top': '0px'});
    //     }
    // }
});


$("#login-customer").click(function (e) {
    returntype = true;
    document.getElementById("loginerror").innerHTML = "";
    document.getElementById("error-username").innerHTML = " ";
    document.getElementById("error-passwrd").innerHTML = " ";
    var username = document.getElementById("username").value;
    var passwrd = document.getElementById("passwrd").value;
    var redirect = document.getElementById("redirect").value;

    if (username == '') {
        document.getElementById("error-username").innerHTML = "Please Enter Username.";
        returntype = false;
    } else {
        document.getElementById("error-username").innerHTML = "";
    }

    if (passwrd == '') {
        document.getElementById("error-passwrd").innerHTML = "Please Enter Password.";
        returntype = false;
    } else {
        document.getElementById("error-passwrd").innerHTML = "";
    }
    if (returntype) {
        $.ajax({
            type: 'GET',
            url: '/logincustomers',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { username: username, passwrd: passwrd },
            success: function (response) {
                //alert(redirect)
                if(redirect == 'samepage'){
                    window.location.reload();
                }else{
                    window.location.href = "/" + redirect;
                }
                
            },
            error: function (response) {
                var error = "Username / Password not found";
                document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
            },
        });
    }
});

$("#reset-pass").click(function (e) {
    returntype = true;
    document.getElementById("reseterror").innerHTML = "<span style='color:coral;'><strong>Processing Please Wait....... </strong></span> ";
    document.getElementById("error-email").innerHTML = " ";
    var email = document.getElementById("email").value;
    if (email == '') {
        document.getElementById("error-email").innerHTML = "Please Enter Email.";
        returntype = false;
    } else {
        document.getElementById("error-email").innerHTML = "";
    }
    if (returntype) {
        $.ajax({
            type: 'GET',
            url: '/reset_customer_password',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { email: email },
            success: function (response) {
                var success = "Success ! Password Sent Please Check Your Email Address....";
                document.getElementById("reseterror").innerHTML = "<span style='color:#3aa13a;'><strong>" + success + "</strong></span>";
            },
            error: function (response) {
                var error = "Failed ! We can't find a user with that e-mail address....";
                document.getElementById("reseterror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></span>";
            },
        });
    }
});

function addcarwash() {
    var carwash_out_only = document.getElementById("carwash_out_only");
    var carwash_in_only = document.getElementById("carwash_in_only");
    var carwash_in_and_out = document.getElementById("carwash_in_and_out");
    // var vehical_type_id = document.getElementById("vehical_type_id").value;;
    var vehical_type_id = $("input[name='vehical_type_id']:checked").val();
    if (vehical_type_id > 0) {
        no_thanks = 1;
        if (carwash_out_only.checked == true) {
            carwash_out_only = 1
            no_thanks = 0;
        } else {
            carwash_out_only = 0;
        }
        if (carwash_in_and_out.checked == true) {
            carwash_in_and_out = 1
            no_thanks = 0;
        } else {
            carwash_in_and_out = 0;
        }
        if (carwash_in_only.checked == true) {
            carwash_in_only = 1
            no_thanks = 0;
        } else {
            carwash_in_only = 0;
        }

        document.getElementById("mini-cart").style.visibility = 'hidden';
        document.getElementById("cart-content").style.visibility = 'hidden';
        $.ajax({
            type: 'GET',
            url: '/addcarwash',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                vehical_type_id: vehical_type_id,
                carwash_in_and_out: carwash_in_and_out,
                carwash_out_only: carwash_out_only,
                no_thanks: no_thanks,
                carwash_in_only: carwash_in_only,
                add_car_wash: 1
            },
            success: function (response) {
                document.getElementById("mini-cart").innerHTML = response.mini_cart;
                document.getElementById("mini-cart").style.visibility = 'visible';
                document.getElementById("cart-content").innerHTML = response.cart;
                document.getElementById("cart-content").style.visibility = 'visible';
            },
            error: function (response) {
                //var error = "Username / Password not found";
                //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
            },
        });
        console.log('carwash_out_only ' + carwash_out_only + ' carwash_in_and_out' + carwash_in_and_out + ' no_thanks ' + no_thanks);
    }
}


function getcarwashhtml() {

    //var vehical_type_id = document.getElementById("vehical_type_id").value;;
    var vehical_type_id = $("input[name='vehical_type_id']:checked").val();
    if (vehical_type_id > 0) {
        $.ajax({
            type: 'GET',
            url: '/getcarwashhtml',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { vehical_type_id: vehical_type_id },
            success: function (response) {
                document.getElementById("carwash-radio-options").innerHTML = response;
                //document.getElementById("mini-cart").style.visibility = 'visible';
            },
            error: function (response) {
                //var error = "Username / Password not found";
                //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
            },
        });
    } else {
        RemoveCarWash();
        hideveh();
        document.getElementById("carwash-radio-options").innerHTML = "";

    }
}
function RemoveCarWash() {

    no_thanks = 1;
    carwash_out_only = 0;
    carwash_in_and_out = 0;
    carwash_in_only = 0;

    document.getElementById("mini-cart").style.visibility = 'hidden';
    document.getElementById("cart-content").style.visibility = 'hidden';
    $.ajax({
        type: 'GET',
        url: '/addcarwash',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            vehical_type_id: 0,
            carwash_in_and_out: carwash_in_and_out,
            carwash_out_only: carwash_out_only,
            no_thanks: no_thanks,
            carwash_in_only: carwash_in_only,
            add_car_wash: 1
        },
        success: function (response) {
            document.getElementById("mini-cart").innerHTML = response.mini_cart;
            document.getElementById("mini-cart").style.visibility = 'visible';
            document.getElementById("cart-content").innerHTML = response.cart;
            document.getElementById("cart-content").style.visibility = 'visible';
        },
        error: function (response) {
            //var error = "Username / Password not found";
            //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
        },
    });
}
function checkverify() {
    var str = document.getElementById("promotion_code").value;
    var n = str.length;
    if (n > 0) {
        document.getElementById("verify").disabled = false;
    } else {
        document.getElementById("verify").disabled = true;
    }
}
function applypromotion() {
    var pc = document.getElementById("promotion_code").value;
    document.getElementById("apc").innerHTML = "";
    document.getElementById("mini-cart").style.visibility = 'hidden';
    document.getElementById("cart-content").style.visibility = 'hidden';
    //alert(pc);
    $.ajax({
        type: 'GET',
        url: '/addpromocode',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            pc: pc,
        },
        success: function (response) {
            console.log(response);
            document.getElementById("mini-cart").innerHTML = response.mini_cart;
            document.getElementById("apc").innerHTML = response.msg;
            document.getElementById("mini-cart").style.visibility = 'visible';
            document.getElementById("cart-content").innerHTML = response.cart
            document.getElementById("cart-content").style.visibility = 'visible';
        },
        error: function (response) {
            //something went wrong reload the page
        },
    });
}



$("#step_3").submit(function (e) {

    // $('#loader').addClass('loader');
    document.getElementById("cardexceptionmsg").innerHTML = "";
    document.getElementById("cardexceptionmsg").style.display = 'none';
    //document.getElementById("final-notice").innerHTML ="Processing Please Wait Redirecting to Payment Section";
    e.preventDefault();
    if ($("#step_3").validationEngine('validate')) {
        //var data = $('rev-form').serialize();
        document.getElementById("final-notice").style.display = 'block';
        $.ajax({
            type: 'POST',
            url: '/booking',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $('#step_3').serialize(),
            success: function (response) {
                console.log(response.cardexception);
                if (response.cardexception !== undefined) {
                    document.getElementById("cardexceptionmsg").innerHTML = response.message;
                    document.getElementById("cardexceptionmsg").style.display = 'block';
                } else {
                    //document.getElementById("final-notice").innerHTML ="Processing Please Wait Redirecting to Payment Section";
                    //alert('jjjj' + response.data + ' KLLLDDDD' + response.redirect )
                    window.location.href = response.redirect;
                }

            }
        });
    }
});



$("#update_user_profile").submit(function (e) {
    //alert('hhhhh');
    // $('#loader').addClass('loader');
    e.preventDefault();
    if ($("#update_user_profile").validationEngine('validate')) {
        //var data = $('rev-form').serialize();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/updateprofile',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $('#update_user_profile').serialize(),
            success: function (data) {
                //alert(data.redirect)
                //window.location.href = "booking-confirm";
                // document.getElementById("submit").disabled = true;
                //$('#loader').removeClass('loader');
                if (data.updated) {
                    window.location.href = "/" + data.redirect;
                } else {
                    alert('something went wrong try again later')
                }
            }
        });
    }
});
$("#register-customer").submit(function (e) {
    //alert('hhhhh');
    // $('#loader').addClass('loader');
    e.preventDefault();
    if ($("#register-customer").validationEngine('validate')) {
        //var data = $('rev-form').serialize();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/registercustomer',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $('#register-customer').serialize(),
            success: function (data) {
                if (data.created == '-1') {
                    alert('Email Already Exist. Please Login Or Use Differnet Email For SignUp...');
                } else if (data.created == '1') {
                    alert('Account Created Sussessfully.. Redirecting To Profile Page');
                    window.location.href = "/" + data.redirect;
                } else {
                    alert('Something Went Wrong Try Again Later');
                }

            }
        });
    }
});



$("#update_booking_1").submit(function (e) {

    //document.getElementById("final-notice").innerHTML ="Processing... Please Wait";
    $('#loader').addClass('loader');
    e.preventDefault();
    if ($("#update_booking_1").validationEngine('validate')) {
        document.getElementById("final-notice").style.display = 'block';
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $('#update_booking_1').serialize(),
            success: function (response) {
                document.getElementById("continue").disabled = true;
                $('#loader').removeClass('loader');
                if (response.success == 1 && response.redirectionflag == 1) {
                    //document.getElementById("final-notice").innerHTML ="Booking Modified Successfully Please Wait Redirecting to Payment Section";
                    //document.getElementById("final-notice").style.display = 'block';
                    window.location.href = response.redirect;
                } else {
                    //document.getElementById("final-notice").innerHTML ="Booking Modified Successfully Reloading Please Wait.";
                    //document.getElementById("final-notice").style.display = 'block';
                    //window.location.reload()
                    window.location.href = response.redirect;
                    //window.scrollTo(0, 20);
                }
            }
        });
    }
});

function getcarwashhtmleditpage() {
    document.getElementById("carwash-radio-options").innerHTML = "";
    //var vehical_type_id = document.getElementById("vehical_type_id").value;
    var vehical_type_id = $("input[name='vehical_type_id']:checked").val();
    var bkcurrency = document.getElementById("bkcurrency").value;
    if (vehical_type_id > 0) {
        $.ajax({
            type: 'GET',
            url: '/getcarwashhtmleditpage',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { vehical_type_id: vehical_type_id, bkcurrency: bkcurrency },
            success: function (response) {
                document.getElementById("carwash-radio-options").innerHTML = response;
                //document.getElementById("mini-cart").style.visibility = 'visible';
            },
            error: function (response) {
                //var error = "Username / Password not found";
                //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
            },
        });
    } else {
        document.getElementById("carwash-radio-options").innerHTML = "";
    }
    calculatePrice();
}

$(document).on("click", 'input.ccheck', function () {
    $('input:radio').click(function () {
        $('label:has(input:radio:checked)').addClass('active-w');
        $('label:has(input:radio:not(:checked))').removeClass('active-w');
    });
});


function showveh() {
    $("#vehicaldiv").show();
    document.getElementById('ww-0').checked = false;
}
function hideveh() {

    //$("#showhideveh").trigger('click');
    $('#showhideveh').attr('checked', false)
    document.getElementById('showhideveh').checked = false;
    $("#vehicaldiv").hide();
}