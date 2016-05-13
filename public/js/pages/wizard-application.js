var view,
    WizardApplication = {

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
            $(document).ready(function () {
                appendToSelect_API("/search/tags?type=INDUSTRY", ".select2-industry");
                appendToSelect_API("/search/degree", ".select2-degrees");
                appendToSelect_API("/search/tags?type=JOBFUNCTION", ".select2-jobFunctions");
                appendToSelect_API("/search/tags?type=STUDYFIELD", ".select2-studyField");
                appendToSelect_API("/search/systemLanguage", ".select2-languages");

            });


        },
        bindUIActions: function () {

            view.activeApplication=false;

            var form = $("#wizard").show();
            //  $(".nano-education").nanoScroller();
            form.steps({

                /* Labels */
                labels: {
                    cancel: "Cancella",
                    current: "current step:",
                    pagination: "Pagination",
                    finish: "Invia la tua candidatura!",
                    next: trans('continua'),
                    previous: trans('indietro'),
                    loading: "Caricamento..."
                },
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                onStepChanging: function (event, currentIndex, newIndex) {


                    if (currentIndex == 0 && $("#role").val() != "" && $("#azienda").val() != "" && $("#data_inizio").val() != "") {


                        if ($("#role").val() != "" && $("#azienda").val() != "" && $("#data_inizio").val() != "") {
                            var params = $(".nano-work").find("select,textarea,input").serialize();


                            if(!$("#data_inizio").val().match(/^\d\d?\/\d\d\d\d$/)){
                                $("#data_inizio").parent().append("<p style='color:red'>Valid date format: mm/yyyy</p>");
                                return false;
                            }



                            $.ajax({
                                type: "POST",
                                url: "/work-experience",
                                data: params,
                                success: function (data, textStatus, xhr) {
                                    if (xhr.status == 201 || xhr.status == 204) {
                                        var id = data.id;

                                        if(!view.activeApplication && $("#id_application").val()!=""){

                                            $.ajax({
                                                type: "POST",
                                                url: "/application/" + $("#id_application").val(),
                                                data: {"active": true},
                                                success: function (data, textStatus, xhr) {
                                                    view.activeApplication=true;
                                                },
                                                error: function (data, textStatus, xhr) {

                                                },
                                                dataType: "json"
                                            });
                                        }


                                        $("#id_work_experience").val(id);
                                        $("#azienda_id").val(data.azienda_id);

                                    }
                                },
                                error: function (data, textStatus, xhr) {

                                },
                                dataType: "json"
                            });


                        }
                        return true;

                    }


                    if (currentIndex == 1 && newIndex > currentIndex && $("#titolo_studio").val() != "" && $("#school").val() != "" && $("#data_inizio_education").val() != "") {
                        if ($("#titolo_studio").val() != "" && $("#school").val() != "" && $("#data_inizio_education").val() != "") {
                            var params = $(".nano-education").find("select,textarea,input").serialize();

                            if(!$("#data_inizio_education").val().match(/^\d\d?\/\d\d\d\d$/)){
                                $("#data_inizio_education").parent().append("<p style='color:red'>Valid date format: mm/yyyy</p>");
                                return false;
                            }

                            $.ajax({
                                type: "POST",
                                url: "/education",
                                data: params,
                                success: function (data, textStatus, xhr) {
                                    if (xhr.status == 201 || xhr.status == 204) {

                                        if(!view.activeApplication && $("#id_application").val()!=""){
                                            $.ajax({
                                                type: "POST",
                                                url: "/application/" + $("#id_application").val(),
                                                data: {"active": true},
                                                success: function (data, textStatus, xhr) {
                                                    view.activeApplication=true;
                                                },
                                                error: function (data, textStatus, xhr) {

                                                },
                                                dataType: "json"
                                            });
                                        }


                                        var id = data.id;
                                        $("#id_education").val(id);
                                        $("#school_id").val(data.school_id);
                                    }
                                },
                                error: function (data, textStatus, xhr) {

                                },
                                dataType: "json"
                            });


                        }
                        return true;
                    }

                    if (currentIndex == 2 && newIndex > currentIndex) {

                        var params = $(".nano-language").find("select,textarea,input").serialize();
                        var first = $(".nano-language").first();
                        if (first && first.find(".id_language_user").val() != "") {
                            $.ajax({
                                type: "POST",
                                url: "/language",
                                data: params,
                                success: function (data, textStatus, xhr) {
                                    if (xhr.status == 201 || xhr.status == 204) {
                                        var id = data.id;

                                        var res = id.split(",");


                                        $(".id_language_user").each(function (index) {
                                            $(this).attr("value", res[index]);
                                        });


                                        //WORK BOX
                                        if ($("#role").val() != "" && $("#azienda").val() != "") {
                                            $("#work-box .title").html($("#role").val());
                                            $("#work-box .location .title").html($("#azienda").val());
                                            $("#work-box .data-from").html($("#data_inizio").val());

                                            if ($("#data_fine").val() != "") {
                                                $("#work-box .data-to").html($("#data_fine").val());

                                            } else {
                                                $("#work-box .data-to").html(trans('presente'));

                                            }
                                            $("#work-box .content-summary").removeClass("hide");
                                            $("#work-box .preloader-wrapper").remove();
                                        } else {
                                            $("#work-box .content-summary").hide();
                                            $("#work-box").css("opacity", 0.3);
                                        }


                                        //EDUCATION BOX
                                        $("#education-box .title").html($("#titolo_studio").val());
                                        $("#education-box .location .title").html($("#school").val());
                                        $("#education-box .data-from").html($("#data_inizio_education").val());


                                        if ($("#data_fine_education").val() != "") {
                                            $("#education-box .data-to").html($("#data_fine_education").val());

                                        } else {
                                            $("#education-box .data-to").html(trans('presente'));

                                        }


                                        $("#education-box .content-summary").removeClass("hide");
                                        $("#education-box .preloader-wrapper").remove();
                                        //LANGUAGE BOX

                                        $(".input-language").each(function (index) {
                                            if ($(".input-language:eq( " + index + " )").val() != "") {
                                                $("#language-box.box-summary-wizard").append("<b>" + $(".input-language:eq( " + index + " )").val() + "</b><br>");
                                            }
                                        });

                                        $("#language-box .content-summary").removeClass("hide");
                                        $("#language-box .preloader-wrapper").remove();

                                        if(!view.activeApplication && $("#id_application").val()!=""){
                                            $.ajax({
                                                type: "POST",
                                                url: "/application/" + $("#id_application").val(),
                                                data: {"active": true},
                                                success: function (data, textStatus, xhr) {
                                                    location.href = '';
                                                },
                                                error: function (data, textStatus, xhr) {

                                                },
                                                dataType: "json"
                                            });
                                        }else{
                                            if($("#id_application").val()==""){
                                                location.href = '/user';
                                            }else{
                                                location.href = '';

                                            }

                                        }

                                    }
                                },
                                error: function (data, textStatus, xhr) {

                                },
                                dataType: "json"
                            });

                        }

                    }


                    // Allways allow previous action even if the current form is not valid!
                    if (currentIndex > newIndex) {
                        return true;
                    }

                    // Needed in some cases if the user went back (clean up)
                    if (currentIndex < newIndex) {
                        // To remove error styles
                        form.find(".body:eq(" + newIndex + ") label.error").remove();
                        form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                    }

                    return true;
                },
                onStepChanged: function (event, currentIndex, priorIndex) {


                    if (currentIndex == 0) {


                        $(".nano-work").nanoScroller();
                    }

                    if (currentIndex == 1) {


                        $(".nano-education").nanoScroller();
                    }

                    if (currentIndex == 2) {
                        $(".nano-language").nanoScroller();
                    }


                },
                onFinishing: function (event, currentIndex) {

                    return true;
                },
                onFinished: function (event, currentIndex) {


                    $(".box-summary-wizard,#summary-legend,.actions").hide();
                    $("#thank-you-box").removeClass("hide");
                    if($("#id_application").val()==""){
                        location.href = '/user';
                    }

                }
            });
            $(".nano-work").nanoScroller();


            $(".datepicker").MonthPicker({
                MaxMonth: 0,
                i18n: {
                    year: "Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    next5Years: 'Jump Forward 5 Years',
                    prev5Years: 'Jump Back 5 Years',
                    nextLabel: "Next",
                    prevLabel: "Prev",
                    buttonText: "Open Month Chooser",
                    jumpYears: "Jump Years",
                    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                },
                OnAfterChooseMonth: function (selectedDate) {

                    $(this).parent().find("label").addClass("active");
                    $(this).parent().find(".prefix").addClass("active");
                    $(this).addClass("valid");
                },
                OnAfterMenuOpen: function (event) {
                    // Make sure the user is aware of the consequences, and prevent opening if they say no.
                    var button = $(this).closest('.row');
                    var scroll = $(this).closest('.nano-content');

                    scroll.animate({
                        scrollTop: button.offset().top - scroll.offset().top + scroll.scrollTop()
                    });

                },
                // Creates the default button.
                ShowIcon: false

            });


            $("#studio_attuale,#lavoro_attuale").click(function () {
                if ($(this).is(':checked')) {

                    $(this).closest(".row").find(".datepicker").MonthPicker('option', 'Disabled', true);

                    if ($(this).attr('id') == "studio_attuale") {
                        $("#grade_min,#grade_max").attr("disabled", true);
                    }

                } else {
                    $(this).closest(".row").find(".datepicker").MonthPicker('option', 'Disabled', false);
                    if ($(this).attr('id') == "studio_attuale") {
                        $("#grade_min,#grade_max").removeAttr("disabled");
                    }
                }


            });

           /* $("#role").autocomplete({
                source: "/search/job-title",
                minLength: 2,
                select: function (event, ui) {

                    $("#role_id").val(ui.item.id);

                    var name = "";

                    if (ui.item.name != "") {
                        name = ui.item.name;
                    }


                    if (typeof ui.item.name_it !== "undefined" && ui.item.name_it != "" && ui.item.name_it != null && $("html").attr("lang") == "it") {
                        name = ui.item.name_it;
                    }


                    $("#role").val(name);
                    return false;
                },
                messages: {
                    noResults: '',
                    results: function () {
                    }
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                var name = "";

                if (item.name != "") {
                    name = item.name;
                }


                if (typeof item.name_it !== "undefined" && item.name_it != "" && $("html").attr("lang") == "it") {
                    name = item.name_it;
                }


                return $("<li>")
                    .append("<a>" + name + "</a>")
                    .appendTo(ul);
            };
 */


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


            $("#azienda").autocomplete({
                source: "/search/company",
                minLength: 2,
                select: function (event, ui) {

                    $("#azienda_id").val(ui.item.id);
                    $("#azienda").val(ui.item.name);
                    return false;
                },
                messages: {
                    noResults: '',
                    results: function () {
                    }
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {

                var city = "";
                if (typeof item.city_plain_text !== "undefined") {
                    city = " - " + item.city_plain_text;
                }

                return $("<li>")
                    .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + "" + city + "</a>")
                    .appendTo(ul);
            };


            $(".nano").on('keydown', "input,.datepicker", function (e) {
                var keyCode = e.keyCode || e.which;

                if (keyCode == 13) {
                    $(this).closest('.row').next().find("input").focus();
                }
                if (keyCode == 9) {
                    //    e.preventDefault();
                    // call custom function here

                    var button = $(this).closest('.row');
                    var scroll = $(this).closest('.nano-content');


                    scroll.animate({
                        scrollTop: button.offset().top - scroll.offset().top + scroll.scrollTop()
                    });
                }
            });


            $(document).on("click", ".input-field input,.datepicker", function () {
                var button = $(this).closest('.row');
                var scroll = $(this).closest('.nano-content');

                scroll.animate({
                    scrollTop: button.offset().top - scroll.offset().top + scroll.scrollTop()
                });


            });


            $("#education").autocomplete({
                source: "/search/tags?type=STUDYFIELD",
                minLength: 2,
                select: function (event, ui) {

                    $("#education_id").val(ui.item.id);
                    $("#education").val(ui.item.name_it);

                    return false;
                },
                messages: {
                    noResults: '',
                    results: function () {
                    }
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {

                if ($("html").attr("lang") == "it") {
                    return $("<li>")
                        .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name_it + "</a>")
                        .appendTo(ul);
                } else {
                    return $("<li>")
                        .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name + "</a>")
                        .appendTo(ul);
                }
            };


            $("#school").autocomplete({
                source: "/search/school",
                minLength: 2,
                select: function (event, ui) {

                    $("#school_id").val(ui.item.id);
                    $("#school").val(ui.item.name);

                    return false;
                },
                messages: {
                    noResults: '',
                    results: function () {
                    }
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name + "</a>")
                    .appendTo(ul);
            };


            $(document).on('click', '.nano-language .remove', function () {
                var value_div = $(this).closest('.input-language');
                if ((value_div.val() != "" && !$(this).closest(".row").is(':last-child')) || (value_div.val() == "" && $(this).closest(".row").is(':last-child'))) {
                    $(this).closest(".row").remove();
                }
            });

     


            $(".scopri-meritocracy").hover(function () {
                $(".arrow").removeClass("arrow");
            });

            $(".input-field:first input").focus();
            $(".input-field:first select").focus();

            $("#lavoro").click(function () {

            });
        }


    };