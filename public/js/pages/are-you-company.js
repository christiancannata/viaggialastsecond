var view,
    CompanyPage = {

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
            $(window).scroll(CompanyPage.sticky_relocate);
            CompanyPage.sticky_relocate();
            $('#fullpage').fullpage({});
            $('#fullpage').attr("style","height: 100%; position: relative; transform: translate3d(0px, 0px, 0px);");
            $("html,body").css("overflow", "visible");

        },
        bindUIActions: function () {

            $(".faq .circle,.faq h4").click(function(){
                $(".faq h4").css("color","#110329");
                $(".faq .circle").text("+");

                var p=$(this).closest(".faq").find("p");
                if(!p.is(":visible")){
                    $(this).closest(".faq").find(".circle").text("x");
                    $(this).closest(".faq").find("h4").css("color","#F04D52");
                    $(".faq p").hide();
                    p.slideDown();

                }else{
                    $(this).closest(".faq").find(".circle").text("+");
                    $(".faq h4").css("color","#110329");
                    p.slideUp();
                }
            });

            view.discoverMeritocracy.click(function () {
                CompanyPage.goToByScroll("scroll-anchor");
                $("html,body").css("overflow", "visible");


            });


            $('a[href=#price-tables]').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 90
                        }, 600);
                        return false;
                    }
                }
            });


            $(".scopri-meritocracy").hover(function () {
                $(".arrow").removeClass("arrow");
            });


            $("#price-tables a").click(function () {
                if ($(this).attr("data-price-table")) {

                    $(".data-price").removeClass("show").addClass("hide");

                    $("."+$(this).attr("data-price-table") + "-price").addClass("show");

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
            if($('#sticky-anchor').length){
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