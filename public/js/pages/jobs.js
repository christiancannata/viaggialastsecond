var view,
    JobsPage = {

        //All settings must go here
        settings: {
            discoverMeritocracy: $(".scopri-meritocracy"),
            jobContainer: $(".job-container:not(.mobile)"),
            tags: $(".tags")
        },


        init: function () {
            view = this.settings;
            this.pageSettings();
        },
        pageSettings: function () {
            $(window).scroll(JobsPage.sticky_relocate);
            JobsPage.sticky_relocate();
            if(getURLParameter("noSearchBar") == 1) {
                $(".central-block-white").hide();
            }
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