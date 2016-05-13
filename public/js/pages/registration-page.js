var view,
    Registration = {

        //All company page settings must go here
        settings: {
            stickyLeftMenu: true,
            notifyButton: $("#notify-me"),
            linkedinButton: $("#linkedin-signin"),
            checkboxAssistenza: $("#user_checkbox_assistenza"),
            step1Form: $("#new_user"),
            step2Form: $("#new_company"),
            inRegistration: false
        },

        init: function () {
            view = this.settings;
            this.bindUIActions();
        }
        ,
        bindUIActions: function () {
            view.linkedinButton.on("click", function (e) {
                e.preventDefault();
                Registration.linkedinAuth();
                $("label").addClass("active");
            });


            $("#assistenza_gratuita").click(function () {
                if ($(this).is(':checked')) {

                    $("#telefono_row").show();

                } else {
                    $("#telefono_row").hide();
                }


            });


            view.checkboxAssistenza.on("click", function (e) {
                e.preventDefault();
                Registration.showTelephoneBox();
            });

            $("#luogo_lavoro").autocomplete({
                source: "/search/city",
                minLength: 2,
                select: function (event, ui) {

                    $("#work_city_id").val(ui.item.id);
                    $("#luogo_lavoro").val(ui.item.name);

                    return false;
                },
                messages: {
                    noResults: '',
                    results: function () {
                    }
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
                    .appendTo(ul);
            };


            view.step1Form.on("submit", function (e) {
                e.preventDefault();
                $('label[for=condizioni]').css("border", "none");

                // Let's select and cache all the fields
                var $inputs = view.step1Form.find("input, select, button, textarea");
                var params = view.step1Form.serialize();


                if (!$('#condizioni').is(':checked')) {

                    $('label[for=condizioni]').css("border", "1px solid red").focus();
                    $('#condizioni-label').show();


                    return false;
                }


                $(".loader,#new_user").toggleClass("hide");

                $inputs.prop("disabled", true);

                // Fire off the request to /form.php
                request = $.ajax({
                    url: "/register/company",
                    type: "POST",
                    dataType: "json",
                    data: params
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) {
                    // Log a message to the console
                    if (jqXHR.status == 201) {

                        $("#userId").val(response.id);


                        // Fire off the request to /form.php
                        request = $.ajax({
                            url: "/company",
                            type: "POST",
                            dataType: "json",
                            data: {name: $("#name").val()}
                        });

                        // Callback handler that will be called on success
                        request.done(function (response, textStatus, jqXHR) {
                            // Log a message to the console
                            if (jqXHR.status == 201) {
                                var company = response.id;
                                $("#company_id").val(company);
                                var params = {
                                    "company": {"id": company},
                                    "__ga": 1,
                                    "user": {
                                        "first_name": $("#first_name").val(),
                                        "last_name": $("#last_name").val(),
                                        "email": $("#email").val(),
                                        "password": $("#password").val()
                                    }
                                };
                                $.ajax({
                                    url: "/user/" + $("#userId").val(),
                                    type: "PATCH",
                                    dataType: "json",
                                    data: params,
                                    success: function () {
                                        $("#userId").val(response.id);

                                        $("#new_user").hide();

                                        var azienda = $("#email").val();

                                        var domain = azienda.replace(/.*@/, "");


                                        $("#website").val(domain);

                                        $(".loader").toggleClass("hide");

                                        $("#new_company").show();


                                        try {
                                            fbq('track', 'Lead');
                                            ga('send', 'event', 'category', 'action', 'signup-company');
                                            twttr.conversion.trackPid('nu4lm', {
                                                tw_sale_amount: 0,
                                                tw_order_quantity: 0
                                            });

                                            fbq.push(['track', '6028725383449', {
                                                'value': '0.00',
                                                'currency': 'EUR'
                                            }]);
                                        } catch (e) {

                                        }
                                    },
                                    error : function (jqXHR, textStatus, errorThrown) {
                                        alert("Unable to update company: please contact us at info@meritocracy.is");
                                        Raven.setExtraContext({
                                            "Ajax jqXHR":  jqXHR,
                                            "Ajax textStatus": textStatus,
                                            "Ajax response" : response
                                        });
                                        Raven.captureMessage("Unable to update a user of a company during company registration");
                                    }
                                });


                            }
                        });


                    } else {
                        alert("Unable to register company: please contact us at info@meritocracy.is");
                        Raven.setExtraContext({
                            "Ajax jqXHR":  jqXHR,
                            "Ajax textStatus": textStatus,
                            "Ajax response" : response
                        });
                        Raven.captureMessage("Unable to register a company");
                    }
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) {



                    $(".loader,#new_user").toggleClass("hide");

                    if (jqXHR.status == 409) {
                        alert(jqXHR.responseJSON.message,"Company not registered","error");
                        view.step1Form.find(".response .card-content p").html(jqXHR.responseJSON.message);
                        view.step1Form.find(".response").removeClass("hide");
                    } else {
                        alert("Unable to Sign Up: please contact us at info@meritocracy.is");
                        Raven.setExtraContext({
                            "Ajax jqXHR":  jqXHR,
                            "Ajax textStatus": textStatus,
                            "Ajax errorThrown" : errorThrown
                        });
                        Raven.captureMessage("Unable to register a company");
                    }
                });

                request.always(function () {
                    // Reenable the inputs
                    $inputs.prop("disabled", false);
                });

            });


            view.step2Form.on("submit", function (e) {
                e.preventDefault();

                $(".loader,#new_company").toggleClass("hide");
                $(".please-wait-text").show();
                var $inputs = view.step2Form.find("input, select, button, textarea");
                var params = view.step2Form.serialize();

                $inputs.prop("disabled", true);

                request = $.ajax({
                    url: "/company/" + $("#company_id").val(),
                    type: "PATCH",
                    dataType: "json",
                    data: params
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) {

                    $(".loader,#new_company").addClass("hide");
                    $(".please-wait-text").hide();
                    if (jqXHR.status == 204) {
                        if ($("#assistenza_gratuita").is(':checked') && $("#name").val() != "") {

                            if ($("#mobile").val() != "") {
                                var params = {
                                    "request": $("#name").val() + " require help to signup",
                                    "phone": $("#mobile").val(),
                                    "company": $("#name").val(),
                                    "name": $("#first_name").val() + " " + $("#last_name").val()
                                }
                            } else {
                                var params = {
                                    "request": $("#name").val() + " require help to signup",
                                    "phone": $("#email").val(),
                                    "company": $("#name").val(),
                                    "name": $("#first_name").val() + " " + $("#last_name").val()
                                }
                            }


                            $.ajax({
                                url: "/contact/COMPANY?assistance=true",
                                type: "POST",
                                dataType: "json",
                                data: params,
                                success: function () {
                                    swal({
                                            title: trans('registration_company_title_success'),
                                            text: trans('registration_company_details_success'),
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: trans('registration_company_btn_success'),
                                            closeOnConfirm: true

                                        },
                                        function () {
                                            location.href = '/hr';
                                        });
                                }
                            });
                        } else {
                            swal({
                                    title: trans('registration_company_title_success'),
                                    text: trans('registration_company_details_success'),
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: trans('registration_company_btn_success'),
                                    closeOnConfirm: true
                                },
                                function (isConfirm) {

                                    if (isConfirm) {
                                        location.href = '/hr';
                                    } else {
                                        location.href = '/'+$("#website").val();
                                    }
                                });
                        }


                    }
                });


                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) {

                    $(".loader,#new_company").toggleClass("hide");


                    // Log the error to the console
                    console.log(
                        "The following error occurred: " +
                        textStatus, errorThrown
                    );
                });

                // Callback handler that will be called regardless
                // if the request failed or succeeded
                request.always(function () {
                    // Reenable the inputs
                    $inputs.prop("disabled", false);
                });

            });

        }
        ,
        subscribeToNotification: function () {

        }
        ,
        showTelephoneBox: function () {
            $(".telephone_box").toggle();
        },
        onLinkedInLoad: function () {
            IN.UI.Authorize().place();
            IN.Event.on(IN, "auth", Registration.onLinkedInAuth);
        }
        ,
        onLinkedInAuth: function () {
            //$(".loader,#new_user").toggleClass("hide");

            IN.API.Profile("me").fields("id", "picture-url", "first-name", "last-name", "email-address", "industry", "positions").result(Registration.displayProfiles);
        }
        ,
        displayProfiles: function (profiles) {
            if (view.inRegistration == false) {
                view.inRegistration = true;
                $('#condizioni-label').hide();

                // setup some local variables
                var $form = $("#new_user");

                // Let's select and cache all the fields
                var $inputs = $form.find("input, select, button, textarea");

                // Serialize the data in the form


                var member = profiles.values[0];
                var position = member['positions']['values'][0];

                // Let's disable the inputs for the duration of the Ajax request.
                // Note: we disable elements AFTER the form data has been serialized.
                // Disabled form elements will not be serialized.


                $inputs.prop("disabled", true);


                var params = {
                    "first_name": member.firstName,
                    "last_name": member.lastName,
                    "email": member.emailAddress,
                    "linkedin_id": member.id,
                    "avatar": member.pictureUrl
                };

                $("#first_name").val(member.firstName);
                $("#linkedin_id").val(member.id);

                if (member.pictureUrl != null && typeof member.pictureUrl !== "" && member.pictureUrl != "") {
                    $("#avatar").val(member.pictureUrl);

                }

                $("#last_name").val(member.lastName);
                $("#email").val(member.emailAddress);

                if (position.company.name != null && typeof position.company.name !== "" && position.company.name != "") {
                    $("#name").val(position.company.name);

                }

                $inputs.prop("disabled", false);
            }


        },
        linkedinAuth: function () {
            IN.User.authorize(Registration.onLinkedInLoad);
        }
        ,

    }
    ;
