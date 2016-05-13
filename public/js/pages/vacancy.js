function centerModals($element) {
    var $modals;
    if ($element.length) {
        $modals = $element;
    } else {
        $modals = $(view.modalVerticalCenterClass + ':visible');
    }
    $modals.each(function (i) {
        var $clone = $(this).clone().css('display', 'block').appendTo('body');
        var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
        top = top > 0 ? top : 0;
        $clone.remove();
        $(this).find('.modal-content').css("margin-top", top - 50);
    });
}
function manualApply(btn, fail) {
    fail = fail !== undefined;
    ga('send', 'event', 'button', 'click', 'Apply manual button');

    $(".application-content").hide();
    $(".register-form").show();


    if (fail === true) {
        $(".fail-cv-analysis-msg").show();
        $(".standard-reg-msg").hide();
    } else {
        $(".fail-cv-analysis-msg").hide();
        $(".standard-reg-msg").show();
    }
    centerModals($("#application-modal"));

}

String.prototype.capitalizeFirstLetter = function () {
    try {
        return this.replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    } catch (ee) {
        return "";
    }
};

var view,
    Vacancy = {

        //All settings must go here
        settings: {
            loadCv: $("#load-cv"),
            applicationBtn: $(".application-button"),
            vacancyId: $("#vacancyId").val(),
            companyId: $("#companyId").val(),
            vacancyName: $("#vacancyName").val(),
            vacancyDescription: $("#vacancyDescription").val(),
            coverletter: $(".application-coverletter")

        },

        init: function () {
            view = this.settings;
            view.coverletterUrl = null;
            view.cvUrl = null;
            view.loading = false;
            this.bindUIActions();
            this.pageSettings();
            $(document).ready(function () {

                if (getURLParameter("login") != null) {
                    $(".modal").modal("hide");
                    $('body').addClass('modal-color-' + $("#login-modal").data('color'));
                    $("#login-modal").modal();
                }

                if ($("#address").length) {
                    view.geocoder = new google.maps.Geocoder();
                    view.geocoder.geocode({'address': $("#address").val()}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {


                            var myLatLng = {
                                lat: results[0].geometry.location.lat(),
                                lng: results[0].geometry.location.lng()
                            };

                            view.map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 9,
                                center: myLatLng
                            });

                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: view.map
                            });
                        }
                    });
                }

                $(".social-apply").on("click", function () {
                    var btn = $(this);
                    var social = btn.attr("data-social");
                    btn.button("loading");
                    var win = window.open(btn.attr("data-href"),
                        "Social Application");
                    var timer = setInterval(function () {
                        if (win.closed) {
                            clearInterval(timer);
                            $.ajax({ // make an AJAX request
                                type: "GET",
                                url: "/isLogged",
                                dataType: 'json',
                                success: function (data, textStatus, xhr) {
                                    ga('send', 'event', 'button', 'click', 'Apply with ' + btn.attr("data-social"));

                                    if (xhr.status == 200 && data.message == 1) {
                                        try {
                                            $('.application-email').val(data.mail);

                                            $('.application-email').attr("disabled", "disabled");

                                        } catch (ee) {
                                            
                                        }
                                        $("html").append("<input id='input-logged' type='hidden' value='1'>");
                                        $("#apply_phase_1," +
                                            ".application-div-other," +
                                            ".application-parsing-animation").hide();
                                        $(".application-content,.application-div-button").show();
                                        $("#apply_phase_social_apply").fadeIn();


                                        $(".datepicker").datepicker({
                                            dateFormat: 'dd-mm-yy',
                                            changeYear: true,
                                            yearRange: '1940:2015',
                                            changeMonth: true
                                        });

                                        view.isValid = true;
                                    } else {
                                        btn.button("reset");
                                        alert(trans('unable_to_apply_soc').replace("%c", social), trans("unable_to_apply") + " " + social, "error");

                                    }
                                },
                                error: function (data, textStatus, xhr) {
                                    btn.button("reset");
                                    alert(trans('unable_to_apply_soc').replace("%c", social), trans("unable_to_apply") + " " + social, "error");
                                }

                            });
                        }
                    }, 100);
                });


                $(".company-page").addClass("animated fadeIn").show();
                view.modalVerticalCenterClass = ".modal";
                $(view.modalVerticalCenterClass).on('show.bs.modal', function (e) {
                    centerModals($(this));
                });
                $(window).on('resize', centerModals);

            });

        },
        pageSettings: function () {
            $(window).scroll(this.sticky_relocate);
            this.sticky_relocate();

        },
        bindUIActions: function () {
            $("#registration-form-modal")[0].reset();

            view.applicationBtn.click(function () {

                if($("#apply_phase_3 input[name='checkboxAuthTos']").is(':visible') && $("#apply_phase_3 input[name='checkboxAuthTos']:checked").length==0){
                    alert(trans("accetta_condizioni"));
                    return false;
                }

                if (hostReachable()) {
                    if (!isLogged()) {
                        if (view.isValid) {


                            var name = $(".application-name:visible").val();
                            var surname = $(".application-surname:visible").val();
                            var email = $("#apply_phase_3 .application-email").val();
                            var password = $("#apply_phase_3 .application-password").val();


                            if (name && surname && email && password) {
                                view.profile.name = name;
                                view.profile.familyName = surname;
                                view.profile.password = password;
                                view.l = Ladda.create(document.querySelector('.application-button'));
                                view.l.start();
                                var jsonArray = jsonGenerator.jsonGen("ADD", {
                                    name: name,
                                    familyName: surname,
                                    password: password,
                                    email: email,
                                    config: view.parsedCv
                                }, "user");


                                if ($("#birthdate_parsing").length) {
                                    jsonArray.data.config.profile.birthdate = $("#birthdate_parsing").val();
                                }

                                $.ajax({ // make an AJAX request
                                    type: "POST",
                                    url: "/register/user",
                                    dataType: 'json',
                                    data: jsonArray,

                                    success: function (data, textStatus, xhr) {
                                        ga('send', 'event', 'category', 'action', 'User Registered');
                                        fbq.push(['track', "6030512428449"]);

                                        if (xhr.status == 201) {
                                            Vacancy.application(view.vacancyId, view.companyId);

                                        } else {
                                            Raven.captureMessage("Unable to apply to a vacancy");
                                            Raven.setExtraContext({
                                                "Ajax data": data,
                                                "Ajax textStatus": textStatus,
                                                "Ajax XHR": xhr
                                            });
                                            Raven.showReportDialog();
                                            view.l.stop();

                                            if (data.responseJSON != null && data.responseJSON.message != null) {
                                                alert(data.responseJSON.message, trans("error_registration"), "error");
                                            } else {
                                                alert(trans("error_registration"), trans("net_error_title"), "error");
                                            }

                                        }
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        view.l.stop();


                                        if (xhr.status == 409) {
                                            swal({
                                                    title: trans('already_registered_title'),
                                                    text: trans('already_registered_desc').replace("%e", email),
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#DD6B55",
                                                    confirmButtonText: trans('already_registered_btn_1'),
                                                    cancelButtonText: trans('already_registered_btn_2'),
                                                    closeOnConfirm: true
                                                },
                                                function (isConfirm) {
                                                    if (isConfirm) {
                                                        $(".modal").modal("hide");
                                                        $('body').addClass('modal-color-' + $("#login-modal").data('color'));
                                                        if ($(this).attr("data-type") == "REGISTER") {
                                                            $("#register-modal").modal();

                                                            return;
                                                        }
                                                        $("#login-modal").modal();

                                                    } else {

                                                    }
                                                });
                                            return;
                                        }
                                        if (xhr.responseJSON != null && xhr.responseJSON.message != null) {
                                            alert(xhr.responseJSON.message, trans("error_registration"), "error");
                                        } else {
                                            Raven.captureMessage("Unable to apply to a vacancy");
                                            Raven.setExtraContext({
                                                "Ajax ajaxOptions": ajaxOptions,
                                                "Ajax thrownError": thrownError,
                                                "Ajax XHR": xhr
                                            });
                                            alert(trans("error_registration"), trans("net_error_title"), "error");
                                        }
                                    }

                                });


                            } else {
                                alert(trans('fill_fields_application_desc'), trans('fill_fields_application_title'), "warning");
                            }


                        } else {
                            alert("Unable to apply: please verify that you have uploaded a valid cv");
                            view.l.stop();
                        }

                    } else {
                        view.l = Ladda.create(document.querySelector('.application-button'));
                        view.l.start();
                        Vacancy.application(view.vacancyId, view.companyId);
                    }
                } else {
                    view.l.stop();
                    alert(trans("net_error"), trans("net_error_title"), "error");
                }
            });

            view.coverletter.on("click", function () {

                try {
                    filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");

                    filepicker.pick(
                        {
                            maxFiles: 1,
                            container: 'modal',
                            services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                            extensions: ['.pdf', '.doc', '.docx', '.odt', '.xls', '.xlsx'],
                            language: $("html").attr("lang")
                        },
                        function (Blobs) {

                            $(".buttons,.cover-letter-attached").hide();
                            view.coverletterUrl = Blobs.url;
                            view.coverletter.hide();
                            $(".title-modal-cvl").hide();
                            $(".title-modal-cvl-done").show();


                        },
                        function (FPError) {
                        }
                    );
                } catch (e) {
                    alert("Unable to load Filepicker plugin due to a network error. Please continue with the application and send us the coverletter at info@meritocracy.is, by specifing this vacancy id: " + $("#vacancyId").val(), "Filepicker plugin error", "error");
                    Raven.captureMessage("Failed to load Filepicker while uploading Coverletter");
                    Raven.showReportDialog();
                }

            });

            $('a[href*=#]:not([href=#])').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                    if (target.length) {
                        $(this).closest("ul").find(".active").removeClass("active");
                        $(this).addClass("active");
                        $('html,body').animate({
                            scrollTop: target.offset().top
                        }, 800);
                        return false;
                    }
                }
            });

            $(".load-cv-registration").click(function (e) {
                e.preventDefault();
                filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                filepicker.pick(
                    {
                        maxFiles: 1,
                        container: 'modal',
                        services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                        extensions: ['.pdf', '.doc', '.docx', '.odt', '.xls', '.xlsx'],
                        language: $("html").attr("lang")
                    },
                    function (Blobs) {
                        view.cvUrl = Blobs.url;

                        $(".load-cv-registration").attr("disabled", "disabled").html("<i class='fa fa-check'></i> CV caricato");

                    },
                    function (FPError) {
                    }
                );
            });

            $("#registration-form").submit(function (e) {
                e.preventDefault();

                var params = $("#registration-form").find("select,textarea,input").serialize();

                $(".register-button-apply").button('loading');

                if (!hostReachable()) {
                    $(".register-button-apply").button('reset');
                    alert(trans("net_error"), trans("net_error_title"), "error");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "/register/user",
                    data: params,
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 201 || xhr.status == 204) {
                            fbq('track', 'CompleteRegistration');
                            var id = data.id;
                            window.registeredUser = id;

                            $("html").append("<input type='hidden' id='input-logged' value='" + id + "'> ");

                            $('.application-email').val($("#registration-form input[name=email]").val());
                            view.isValid = true;

                            view.profile = {id: id};

                            view.parsedCv = view.cvUrl;

                            Vacancy.application(view.vacancyId, view.companyId);


                        } else {
                            $(".register-button-apply").button('reset');
                            if (data.responseJSON != null && data.responseJSON.message != null) {
                                alert(data.responseJSON.message);
                            } else {
                                alert(trans("net_error"), trans("net_error_title"), "error");
                            }
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        $(".register-button-apply").button('reset');
                        if (data.responseJSON != null && data.responseJSON.message != null) {
                            alert(data.responseJSON.message);
                        } else {
                            alert(trans("net_error"), trans("net_error_title"), "error");
                        }
                    },
                    dataType: "json"
                });
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
        codeAddresses: function (address) {
            view.geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    view.map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: view.map,
                        position: results[0].geometry.location
                    });

                    loc = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                    view.bounds.extend(loc);
                }
                else {

                }
            });
        },
        plotMarkers: function () {
            view.bounds = new google.maps.LatLngBounds();
            this.codeAddresses($("#address").val());
            if (typeof locationsArray !== "undefined" && locationsArray.length > 1) {
                view.map.fitBounds(bounds);
                view.map.panToBounds(bounds);
            }
            view.map.setOptions({scrollwheel: false});
        },
        sticky_relocate: function () {
            if ($('#sticky-anchor').length) {
                if (!isMobile() && $(window).width() > 1183) {
                    $('html,body').css('overflow', 'visible');
                    var window_top = $(window).scrollTop();
                    var div_top = $('#sticky-anchor').offset().top;
                    view.div_top_2 = $('#sticky-anchor-2').offset().top;

                    if (window_top > view.div_top_2) {
                        if (!$("#sticky-2").hasClass("stick")) {
                            $('#sticky-2').addClass('stick');
                            $(".block-content-title-parent").hide();
                        }

                    } else if (view.div_top_2 != null) {
                        $('#sticky-2').removeClass('stick');
                        $(".block-content-title-parent").show();
                    }


                    if (window_top > div_top) {
                        if (!$("#sticky").hasClass("stick")) {
                            $('#sticky').fadeIn(100).addClass('stick');

                        }

                    } else {
                        $('#sticky').hide().removeClass('stick');

                    }
                }
            }
        }, elaborateCv: function (data, callback) {

            var parsedCv = null, profile = null;

            if (data.success == 1) {
                parsedCv = data.data;
                profile = parsedCv.profile
            }
            if (callback) {
                callback(data.success, profile, parsedCv);
            }
        }, application: function (vacancyId, companyId, coverletterUrl, applicationVideo, background) {


            var redirectMode = false;
            if ($("#redirectUrl").val() != "") {
                redirectMode = true;
            }
            var applicationJson = {
                cvUrl: view.cvUrl,
                coverLetter: view.coverletterUrl,
                video: null,
                vacancyId: vacancyId,
                companyId: companyId,
                redirectMode: redirectMode
            };


            if (getURLParameter("premium_suggested") != null) {
                applicationJson.premium_suggested = 1;
            }

            if ($("input[name=attachment]").val() != "") {
                applicationJson.cvId = $("input[name=attachment]").val();
            }


            if (!isMobile()) {
                if (view.cvUrl == null && applicationJson.cvId == null) {
                    view.l.stop();

                    swal({
                            title: trans("cv_needed_title"),
                            text: trans("cv_needed_desc"),
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: trans('upload_cv_btn'),
                            closeOnConfirm: true
                        },
                        function () {
                            var button = $(this);
                            filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                            filepicker.pick(
                                {
                                    maxFiles: 1,
                                    container: 'modal',
                                    extensions: ['.png', '.tiff', '.jpg', '.jpeg', '.gif', '.pdf', '.doc', '.docx'],
                                    services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                                    language: $("html").attr("lang")
                                },
                                function (Blobs) {
                                    view.l.start();
                                    var url = Blobs.url;

                                    var res = url.split("/");
                                    $.ajax({
                                        type: "POST",
                                        url: "/attachment",
                                        dataType: "json",
                                        data: {
                                            type: "CV",
                                            "link": url,
                                            "name": res[res.length - 1],
                                            "user": {"id": $("#userId").val()}
                                        },
                                        success: function (data, textStatus, xhr) {
                                            if (xhr.status == 201 || xhr.status == 204) {
                                                $("#attachment_id").val(data.id);
                                                var button = $(".load-file");
                                                button.attr("disabled", true);
                                                button.addClass("disabled");
                                                button.text(trans('cv_uploaded'));

                                                Vacancy.application(vacancyId, companyId, coverletterUrl, applicationVideo, background);
                                            } else {
                                                view.l.stop();
                                            }
                                        },
                                        error: function (data, textStatus, xhr) {
                                            view.l.stop();
                                        }
                                    });


                                },
                                function (FPError) {
                                }
                            );
                        });

                    return;

                }

            }


            $.ajax({
                type: "POST",
                url: "/apply",
                dataType: 'json',
                data: applicationJson,

                success: function (data, textStatus, xhr) {
                    if (xhr.status == 201) {

                        try {


                            fbq.push('track', 'InitiateCheckout', {"vacancyId": vacancyId});
                            var fbPixel = $("#vacancyFbPixel").val();
                            var otherFbPixel = $("#vacancyFbPixelSpecific").val();
                            var twitterPixel = $("#vacancyTwitterPixel").val();

                            if (fbPixel.length > 0) {
                                fbq.push(['track', fbPixel]);
                            } else if (otherFbPixel.length > 0) {
                                fbq.push(['track', otherFbPixel]);
                            }

                            if (twitterPixel.length > 0) {
                                twttr.conversion.trackPid($("#vacancyTwitterPixel").val(), {
                                    tw_sale_amount: 0,
                                    tw_order_quantity: 1
                                });
                            }

                            if (typeof _jrpt !== "undefined") {
                                _jrpt.success();
                            }

                            var OneSignal = OneSignal || [];
                            OneSignal.push(["isPushNotificationsEnabled", function (enabled) {
                                if (enabled) {
                                    OneSignal.push(["sendTags", {"Applied to a vacancy": vacancyId, "applied": 1}]);
                                }
                            }]);

                        } catch (e) {
                            Raven.captureException(e);
                            Raven.showReportDialog();
                        }

                        if (background != undefined && background) {
                            return;
                        }


                        $.ajax({ // make an AJAX request
                            type: "GET",
                            url: "/application/" + data.id,
                            dataType: 'json',
                            success: function (data, textStatus, xhr) {
                                if (xhr.status == 200) {
                                    ga('send', 'event', 'category', 'action', 'Applied to a vacancy');
                                    ga('ecommerce:addTransaction', {
                                        'id': data.id,
                                        'affiliation': '',
                                        'revenue': '0.01'
                                    });
                                    ga('ecommerce:addItem', {
                                        'id': data.vacancy.id,                     // Vacancy Id Required.
                                        'name': data.vacancy.name + " | " + data.vacancy.company.name,    // Vacancy name. Required.
                                        'sku': data.vacancy.id + "|C_" + data.vacancy.company.name + "|J_" + "" + "|I_" + "",
                                        'category': data.vacancy.company.name,
                                        'price': '0.01',
                                        'brand': data.vacancy.company.name,
                                        'quantity': '1'
                                    });
                                    ga('ecommerce:send');


                                    if (redirectMode) {
                                        window.location.href = $("#redirectUrl").val();
                                        return;
                                    }


                                    window.location.href = "/" + $("html").attr("lang") + "/application-thankyou?_appId=" + btoa(data.id);
                                }
                            },
                            error: function (data, textStatus, xhr) {
                                if (redirectMode) {
                                    var company = $("#companyName").val();
                                    var logo = $("#companyLogoUrl").val();
                                    var redirect = $("#redirectUrl").val();
                                    var vacancy = $("#vacancyName").val();
                                    window.location.href = "/redirect/" + base64encode("" + company + "&*#" + logo + "&*#" + redirect + "&*#" + vacancy);
                                    return;
                                }

                                window.location.href = "/" + $("html").attr("lang") + "/application-thankyou?_appId=" + btoa(data.id);
                            }

                        });


                    } else {
                        $(".register-button-apply:visible").button('reset');
                        view.l.stop();

                        if (data.responseJSON != null && data.responseJSON.message != null) {
                            $(".application-error").show().html(data.responseJSON.message);
                        } else {
                            if (xhr.status == 401) {
                                alert(trans("expired_session_apply"), trans("expired_session_title"), "error");
                            }
                            Raven.setExtraContext({
                                "Ajax data": data,
                                "Ajax textStatus": textStatus,
                                "Ajax XHR": xhr,
                                "isRegistering": window.registeredUser != null ? window.registeredUser : false,
                                "isLogged": isLogged()
                            });
                            Raven.captureMessage("Error during vacancy application");
                            Raven.showReportDialog();

                        }
                    }
                },
                error: function (data, textStatus, xhr) {
                    $(".register-button-apply:visible").button('reset');
                    view.l.stop();

                    if (data.responseJSON != null && data.responseJSON.message != null) {
                        $(".application-error").show().html(data.responseJSON.message);
                    } else {
                        if (xhr.status == 401) {
                            alert(trans("expired_session_apply"), trans("expired_session_title"), "error");
                            return;
                        }else {
                            alert(trans("net_error"), trans("net_error_title"), "error");
                        }

                        Raven.setExtraContext({
                            "Ajax data": data,
                            "Ajax textStatus": textStatus,
                            "Ajax XHR": xhr,
                            "isRegistering": window.registeredUser != null ? window.registeredUser : false,
                            "isLogged": isLogged()

                        });
                        Raven.captureMessage("Error during vacancy application");
                        Raven.showReportDialog();

                    }
                }

            });

        }


    };


