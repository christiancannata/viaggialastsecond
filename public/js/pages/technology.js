var view,
    Technology = {

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
        },
        pageSettings: function () {
            $(window).scroll(Technology.sticky_relocate);
            Technology.sticky_relocate();
            $("html,body").css("overflow", "visible");

        },
        bindUIActions: function () {
            view.discoverMeritocracy.click(function () {
                Technology.goToByScroll("scroll-anchor");
                $("html,body").css("overflow", "visible");


            });

            $(".scopri-meritocracy").hover(function(){
                $(".arrow").removeClass("arrow");
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