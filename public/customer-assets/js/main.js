// convert english nums to persian nums
$(document).ready(function () {

    traverse(document.body);
});
// end convert
persian = { 0: '۰', 1: '۱', 2: '۲', 3: '۳', 4: '۴', 5: '۵', 6: '۶', 7: '۷', 8: '۸', 9: '۹' };
function traverse(el) {
    if (el.nodeType == 3) {
        var list = el.data.match(/[0-9]/g);
        if (list != null && list.length != 0) {
            for (var i = 0; i < list.length; i++)
                el.data = el.data.replace(list[i], persian[list[i]]);
        }
    }
    for (var i = 0; i < el.childNodes.length; i++) {
        traverse(el.childNodes[i]);
    }
}

$(document).ready(function () {
    $("#autocomplete-products").focusin(function () {
        $(".search-box").addClass("search-box-active");
    });
    $("#autocomplete-products").focusout(function () {
        debugger
        if (!$("#products-autocomplete-list").is(':focus')) {
            $("#products-autocomplete-list").fadeOut();
            $("#products-autocomplete-list").removeClass("search-box-active");
        }
    });
    $('#autocomplete-products').keyup(function () { 
        var search = $(this).val();
        if(search != '')
        {
            var _token = $(this).next().val();
            var url = $(this).data('url');
            $.ajax({
                type: "post",
                url: url,
                data: {"search":search, "_token":_token},
                success: function (response) {
                    $('#products-autocomplete-list').fadeIn();
                    $('#products-autocomplete-list').html(response);
                    $('.autocomplete-result').click(function(){
                        debugger
                        $('#autocomplete-products').val($(this).text());
                        $('#autocomplete-products').data('clicked', true);
                        $('#products-autocomplete-list').fadeOut();
                    });
                }
            });

        }
        else{
            var not_found = '<section class="search-result-item"><span class="search-no-result">موردی یافت نشد</span>';
            $('#products-autocomplete-list').fadeIn();
            $('#products-autocomplete-list').html(not_found);
        }
    });

    

});

//start search
$(document).ready(function () {


    


});
//end search




//start super navbar
$(document).ready(function () {

    $(".super-navbar-item").hover(function () {
        $(".sublist-item").removeClass("sublist-item-active");
        $(".sublist-item").first().addClass("sublist-item-active");
    }, function () {
        $(".sublist-item").removeClass("sublist-item-active");
    });

    $(".sublist-item-toggle").click(function () {
        $(".sublist-item").removeClass("sublist-item-active");
        $(this).parent().addClass("sublist-item-active");
    });

    $(".sublist-item-toggle").hover(function () {
        $(".sublist-item").removeClass("sublist-item-active");
        $(this).parent().addClass("sublist-item-active");
    });

});
//end super navbar



//start owlcarousel
$(document).ready(function () {
    $("#slideshow").owlCarousel({
        rtl: true,
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 1
    });

    $(".lazyload").owlCarousel({
        rtl: true,
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: false,
        autoHeight: false,
        items: 5,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                loop: true
            },
            450: {
                items: 2,
                nav: false,
                loop: true
            },
            767.9: {
                items: 3,
                nav: false,
                loop: true
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    });


    $(".brands").owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 5,
        responsive: {
            0: {
                items: 1,
                nav: true,
                loop: true
            },
            450: {
                items: 2,
                nav: false,
                loop: true
            },
            767.9: {
                items: 3,
                nav: false,
                loop: true
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    });



    // $(".owl-carousel").owlCarousel({
    //     rtl:true,
    //     loop:true,
    //     margin:0,
    //     nav:false,
    //     autoplay:true,
    //     autoplayTimeout:5000,
    //     autoplayHoverPause:true,
    //     animateOut: 'fadeOut',
    //     animateIn: 'fadeIn',
    //     items: 1
    // });
});
//end owlcarousel




//start tooltip
$(document).ready(function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });


});

//end tooltip


//start cart
$(document).ready(function () {

    $(".cart-number-up").click(function () {
        var value = parseInt($(this).parent().find('input[type=number]').val());
        if (value < 5) {
            $(this).parent().find('input[type=number]').val(value + 1);
        }
    });

    $(".cart-number-down").click(function () {
        var value = parseInt($(this).parent().find('input[type=number]').val());
        if (value > 1) {
            $(this).parent().find('input[type=number]').val(value - 1);
        }
    });

});
//end cart




//start address
$(document).ready(function () {

    $('input[name="address"]').change(function () {

        var address = $('input[name="address"]').is(":checked");
        var delivery_type = $('input[name="delivery_type"]').is(":checked");

        if (address == true && delivery_type == true) {
            $("#address-button").removeClass("d-block");
            $("#address-button").addClass("d-none");
            $("#next-level").removeClass("d-none");
            $("#next-level").addClass("d-block");
        }
    });

    $('input[name="delivery_type"]').change(function () {

        var address = $('input[name="address"]').is(":checked");
        var delivery_type = $('input[name="delivery_type"]').is(":checked");

        if (address == true && delivery_type == true) {
            $("#address-button").removeClass("d-block");
            $("#address-button").addClass("d-none");
            $("#next-level").removeClass("d-none");
            $("#next-level").addClass("d-block");
        }
    });


});
//end address


//start payment
$(document).ready(function () {

    $('input[name="payment_type"]').change(function () {

        var payment_type = $('input[name="payment_type"]').is(":checked");

        if (payment_type == true) {
            $("#payment-button").removeClass("d-block");
            $("#payment-button").addClass("d-none");
            $("#final-level").removeClass("d-none");
            $("#final-level").addClass("d-block");
        }
    });


});
//end payment



//start filter
$(document).ready(function () {

    $(".sidebar-nav-item-title").click(function () {
        $header = $(this);
        $content = $header.next();

        $(".sidebar-nav-sub-sub-wrapper").slideUp();
        $(".sidebar-nav-sub-item-title i").removeClass("rotate-angle-left-90-degrees");
        if ($content.is(":visible")) {
            $header.find("i").removeClass("rotate-angle-left-90-degrees");
            $content.slideUp();
        } else {
            $(".sidebar-nav-item-title i").removeClass("rotate-angle-left-90-degrees");
            $(".sidebar-nav-sub-wrapper").slideUp();
            $header.find("i").addClass("rotate-angle-left-90-degrees");
            $content.slideToggle(400);
        }
    });

    $(".sidebar-nav-sub-item-title").click(function () {
        $subHeader = $(this);
        $subContent = $subHeader.next();

        if ($subContent.is(":visible")) {
            $subHeader.find("i").removeClass("rotate-angle-left-90-degrees");
            $subContent.slideUp();
        } else {
            $(".sidebar-nav-sub-item-title i").removeClass("rotate-angle-left-90-degrees");
            $(".sidebar-nav-sub-sub-wrapper").slideUp();
            $subHeader.find("i").addClass("rotate-angle-left-90-degrees");
            $subContent.slideToggle(400);
        }
    });

});
//end filter


//start filter
$(document).ready(function () {

    $(".product-gallery-selected-image img").css("height", $(".product-gallery-selected-image img").css("width"));
    $(".product-gallery-thumb").click(function () {
        var selectedImageSrc = $(this).attr("data-input");
        $(".product-gallery-selected-image img").attr("src", selectedImageSrc);
        $(".product-gallery-selected-image img").css("height", $(".product-gallery-selected-image img").css("width"));
    });

});
//end filter



