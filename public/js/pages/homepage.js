var view,
    Homepage = {

        //All settings must go here
        settings: {
            discoverMeritocracy: $(".scopri-meritocracy"),
            jobContainer: $(".job-container:not(.mobile)"),
            tags: $(".tags")
        },


        init: function () {
            view = this.settings;
            this.bindUIActions();
            this.pageSettings();
            // Resive video
           

        },
        pageSettings: function () {

            

            $(window).scroll(Homepage.sticky_relocate);
            Homepage.sticky_relocate();
            $("html,body").css("overflow", "visible");

            $(document).ready(function (){
                
               
                if (getURLParameter("login") != null) {
                    $(".modal").modal("hide");
                    $('body').addClass('modal-color-' + $("#login-modal").data('color'));
                    $("#login-modal").modal();
                }
                
                if($("#bgvid:visible").length > 0) {
                    $(window).scroll(function () {
                        $('video').each(function () {
                            if ($(this).is(":in-viewport( 400 )")) {
                                $(this)[0].play();
                            } else {
                                $(this)[0].pause();
                            }
                        });
                    });
                }
            });
        },
        bindUIActions: function () {
            view.discoverMeritocracy.click(function () {
                Homepage.goToByScroll("scroll-anchor");
                $("html,body").css("overflow", "visible");


            });

            $(".scopri-meritocracy").hover(function () {
                $(".arrow").removeClass("arrow");
            });


            $("#form-search").submit(function (e) {


                // ensures the optimizely object is defined globally using
                window['optimizely'] = window['optimizely'] || [];


                // sends a tracking call to Optimizely for the given event name.
                if($("html").attr("lang")=="it"){
                    window.optimizely.push(["trackEvent", "submit-search-it"]);

                }else{
                    window.optimizely.push(["trackEvent", "submit-search"]);

                }

            });

        },

        goToByScroll: function (id) {
            // Remove "link" from the ID
            id = id.replace("link", "");
            // Scroll
            $('html,body').animate({
                    scrollTop: $("#" + id).offset().top
                },
                'slow');
        },
        sticky_relocate: function () {
            if($('#sticky-anchor').length) {
                $('html,body').css('overflow', 'visible');
                var window_top = $(window).scrollTop();
                var div_top = $('#sticky-anchor').offset().top;
                if (window_top > div_top) {
                    $('#sticky').fadeIn(100).addClass('stick');
                } else {
                    $('#sticky').hide().removeClass('stick');
                }
            }
        }


    };