var view, locationsArray = [], photoswipeImages = []
Company = {

    //All settings must go here
    settings: {
        PhotoSwipeSettings: {
            focus: true,
            shareButtons: [
                {
                    id: 'facebook',
                    label: 'Share photo on Facebook',
                    url: 'https://www.facebook.com/sharer/sharer.php?u={{url}}'
                },
                {
                    id: 'twitter',
                    label: 'Share photo on Twitter',
                    url: 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'
                }
            ]
        },
        PhotoSwipeImages: []
    },


    init: function () {
        view = this.settings;
        this.loadPhotoswipeSlider();
        this.bindUIActions();
        this.pageSettings();
    },
    carouselIntervalStartVideo: function (e) {
        $('.carousel').carousel({
            interval: 3
        });
    },
    loadPhotoswipeSlider: function () {
        if (photoswipeImages != null && photoswipeImages.length > 0) {

            var pswpElement = document.querySelectorAll('.pswp')[0];

            // define options (if needed)
            var options = {
                focus: true,
                shareButtons: [
                    {
                        id: 'facebook', label: 'Share tihs company photo office on Facebook', url: 'https://www.facebook.com/sharer/sharer.php?u={{url}}'
                    },
                    {
                        id: 'twitter', label: 'Tweet', url: 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'}
                ]
            };
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, photoswipeImages, options);
            gallery.init();
            gallery.listen('close', function () {
                $(".cd-header,.header-menu").fadeIn();
            });
            $(".cd-header,.header-menu").fadeOut();

        }

    },
    pageSettings: function () {
        $(window).scroll(this.sticky_relocate);
        $('[data-toggle="popover"]').popover({trigger: "hover"});
        $('.company-img').each(function () {
            var w = isMobile() ? 1024 : 1620;
            var h = isMobile() ? 768 : 1080;

            photoswipeImages.push({
                src: $(this).attr("src"),
                w: w,
                h: h
            });
        });


        if (!isMobile()) {
            $('.company-img').each(function () {
                //get img dimensions
                if (view.h == null) {
                    view.h = $(this).height();
                }
                //get div dimensions
                var div_h = $('#company-slider').height();
                //set img position
                this.style.top = Math.round((div_h - view.h) / 2) + 'px';
                this.style.position = "absolute";
                this.style.top = "-80px";
            });
        }


        if ($("#companyVideo").length > 0) {
            document.getElementById('companyVideo').addEventListener('ended', Company.carouselIntervalStartVideo(), false);
        }


        $('.carousel').bcSwipe({threshold: 50});

        if ($("#address")) {
            view.geocoder = new google.maps.Geocoder();


            view.geocoder.geocode({'address': $("#address").val()}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {


                    var myLatLng = {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng()
                    };
                    view.map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 9,
                        draggable: false,
                        center: myLatLng
                    });

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: view.map
                    });


                }

            });


        }


        var topMenu = $(".sub-header-menu .nav"),
            topMenuHeight = topMenu.outerHeight() + 50,
            menuItems = topMenu.find("a"),
            scrollItems = menuItems.map(function () {
                var item = $($(this).attr("href"));
                if (item.length) {
                    return item;
                }
            });


        $(window).scroll(function () {
            var fromTop = $(this).scrollTop() + topMenuHeight + 50;

            var cur = scrollItems.map(function () {
                if ($(this).offset().top < fromTop)
                    return this;
            });
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";
            menuItems.parent().removeClass("active");
            menuItems.parent().removeClass("active")
                .end().filter("[href=#" + id + "]").parent().addClass("active");
        });


        try {
            $(".sisti").each(function (index, element) {
                $("*[data-json-mod=" + element.id + "]").text(element.value);
            });

        } catch (e) {
        }
    },
    bindUIActions: function () {


        $(".vacancy-description").on("click", function () {
            if ($(this).hasClass("expanded")) {
                $(this).css("max-height", "95px");
                $(this).css("-webkit-line-clamp", "6");
                $(this).removeClass("expanded");
            } else {
                $(this).css("max-height", "1000px");
                $(this).css("-webkit-line-clamp", "40");
                $(this).addClass("expanded");
            }

        });


        $('a[href*=#]:not([href=#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $(this).closest("ul").find(".active").removeClass("active");
                    $(this).parent().addClass("active");
                    $('html,body').animate({
                        scrollTop: target.offset().top - 90
                    }, 600);
                    return false;
                }
            }
        });


    }

    ,
    goToByScroll: function (id) {
        // Remove "link" from the ID
        id = id.replace("link", "");
        // Scroll
        $('html,body').animate({
                scrollTop: $("#" + id).offset().top
            },
            'slow');
    }
    ,
    sticky_relocate: function () {


        if ($('#sticky-anchor').length) {
            $('html,body').css('overflow', 'visible');
            var window_top = $(window).scrollTop();
            var div_top = $('#sticky-anchor').offset().top;
            if (window_top > div_top) {
                if (!$("#sticky").hasClass("stick")) {
                    $('#sticky').fadeIn(100).addClass('stick');

                }

            } else {
                $('#sticky').hide().removeClass('stick');

            }


            if (!isMobile() && $(window).width() > 1183) {

                view.div_top_2 == null ? view.div_top_2 = $('#sticky-anchor-2').offset().top : null;


                if (window_top > view.div_top_2) {
                    if (!$("#sticky-2").hasClass("stick")) {
                        $('#sticky-2').addClass('stick');
                        $(".block-content-title-parent").hide();
                    }

                } else if (view.div_top_2 != null) {
                    $('#sticky-2').removeClass('stick');
                    $(".block-content-title-parent").show();
                }


            }
        }
    }
    ,
    plotMarkers: function () {

        if ($("#address")) {
            this.codeAddresses($("#address").val());

            // view.map.panToBounds(view.bounds);
            view.map.setOptions({scrollwheel: false});

        }

    }
    ,
    codeAddresses: function (address) {
        view.geocoder.geocode({'address': address}, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                view.map.setCenter(results[0].geometry.location);
                loc = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

                view.bounds = new google.maps.LatLngBounds(
                    loc
                );

                view.map.fitBounds(view.bounds);

            }
            else {

            }
        });
    }
};