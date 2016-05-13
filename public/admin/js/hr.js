function SaveDataToSessionStorage(data) {
    var a = [];
    // Parse the serialized data back into an aray of objects
    a = JSON.parse(sessionStorage.getItem('editedVacancy'));
    // Push the new data (whether it be an object or anything else) onto the array
    a.push(data);

    sessionStorage.setItem('editedVacancy', JSON.stringify(a));
}
var view,
    HR = {
        settings: {

            forms: {
                newVacancy: $("form#new-vacancy"),
                editVacancy: $("form#edit-vacancy"),

                utils: {
                    recreateModal: $(".form-recreate-modal")
                }
            },
            vacancy: {
                close: $(".vacancy-close"),
                open: $(".vacancy-open"),
                edit: $(".vacancy-edit"),
                clone: $(".vacancy-clone"),
                sort: $(".vacancy-sort")
            },
            fixedButtons: {
                def: $(".default-action-btn"),
                sort: $(".sort-action-btn")
            },
            application: {
                event: $(".event-application-button")
            }
        },


        init: function () {
            view = this.settings;
            this.pageSettings();
            this.bindUIActions();
            this.initSelects();
        },
        initSelects: function () {
            appendToSelect_API("/search/tags?type=JOBFUNCTION", ".select2-jobFunctions");
            appendToSelect_API("/search/tags?type=INDUSTRY", ".select2-industries");
            appendToSelect_API("/search/tags?type=STUDYFIELD", ".select2-studyFields");
            appendToSelect_API("/search/systemLanguage", ".select2-languages");


        },
        pageSettings: function () {

            $(document).ready(function () {


                //$("img.lazy").lazyload();
                if (sessionStorage != null && sessionStorage.getItem("editedVacancy") != null) {

                    var id = sessionStorage.getItem("editedVacancy");
                    var ids = JSON.parse(id);
                    $(ids).each(function (i, data) {
                        if (data != null) {
                            $("#vacancy-" + data).find(".edited").removeClass("hide");
                        }
                    });
                }
            });

            $.ajax({
                url: "/hr/company/vacancies",
                type: "GET",
                success: function (data, jqXHR) {
                    $(".vacancies-container .form-loader").hide();
                    $(".vacancies-container").prepend(data);

                    if ($(".vacancies-hr").length <= 0 && $(".uncompleted-adv:visible").length <= 0) {
                            $(".no-vacancies").show();
                    }
                    $('.dropdown-button').dropdown({
                        inDuration: 300,
                        outDuration: 125,
                        constrain_width: true, // Does not change width of dropdown to that of the activator
                        hover: false, // Activate on click
                        alignment: 'left', // Aligns dropdown to left or right edge (works with constrain_width)
                        gutter: 0, // Spacing from edge
                        belowOrigin: true // Displays dropdown below the button
                    });

                    if ($("#morris-line").length) {


                        $("#jsGrid-basic").jsGrid({
                            height: "auto",
                            width: "100%",
                            sorting: false,
                            paging: true,
                            pageSize: 4,
                            autoload: true,
                            controller: {
                                loadData: function () {
                                    var d = $.Deferred();
                                    var req = $.ajax({
                                        url: "/company/"+$("#companyId").val()+"/topScoreReferral?total="+$("#applicationTotali").val(),
                                        dataType: "json"
                                    }).done(function (response) {
                                        d.resolve(response);
                                    });
                                    window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits
                                    return d.promise();
                                }
                            },
                            fields: [
                                {name: "Referral", type: "text"},
                                {name: "Count", type: "number"},
                                {name: "Score", type: "number"}
                            ]
                        });


                        var req = $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/company/"+$("#companyId").val()+"/referral?total="+$("#applicationTotali").val(), // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data
                                window.DoughnutChartSample = new Chart(document.getElementById("doughnut-chart-sample").getContext("2d")).Pie(data, {
                                    responsive: true,
                                    segmentShowStroke: false,
                                    tooltipTemplate: "<%= label %> <%= value %>%",
                                });

                                document.getElementById('doughnut-chart-sample-legend').innerHTML = window.DoughnutChartSample.generateLegend();


                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                //  alert("error occured");
                            });
                        window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits


                        var visitsArray = [];
                        // Fire off an AJAX request to load the data
                        var req = $.ajax({
                                type: "GET",
                                dataType: 'json',

                                url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/"+$("#companyPermalink").val()+"&dimensions=ga:date&from=P7D&to=yesterday", // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data

                                visitsArray = data;

                                $.ajax({
                                        type: "GET",
                                        dataType: 'json',
                                        url: "/company/"+$("#companyId").val()+"/applications?from="+$("#dal").val()+"&to="+$("#al").val()+"", // This is the URL to the API
                                    })
                                    .done(function (data) {
                                        // When the response to the AJAX request comes back render the chart with new data
                                        var applicationsArray = data;

                                        var arrayStatistic = [];


                                        $(visitsArray).each(function (i, value) {
                                            var appo = [];
                                            appo["date"] = value["dimensions"];
                                            appo["pageView"] = parseInt(value["pageView"]);

                                            var applicationsDay = 0;
                                            for (var j = 0; j < applicationsArray.length; j++) {
                                                if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                    applicationsDay = applicationsArray[j]["applications"];
                                                }
                                            }

                                            appo["applications"] = applicationsDay;


                                            arrayStatistic.push(appo);
                                        });

                                        // Line Chart
                                        var chart = Morris.Line({
                                            element: 'morris-line',
                                            xkey: 'date',
                                            ykeys: ['pageView', 'applications'],
                                            xLabels: "daily",
                                            labels: ["Visits", "Applications"],
                                            resize: true,
                                            xLabelAngle: 0
                                        });


                                        chart.setData(arrayStatistic);


                                    })
                                    .fail(function () {
                                        // If there is no communication between the server, show an error
                                        // alert("error occured");
                                    });


                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                // alert("error occured");
                            });
                        window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits


                        $(".component-statistic").each(function (i, ctr) {
                            var ctr = $(this);
                            var req = $.ajax({
                                    type: "GET",
                                    dataType: 'json',
                                    url: "/analytics/" + ctr.attr("data-type") + "/compare?typeGroup=" + ctr.attr("data-type-group") + "&id=" + ctr.attr("data-id"), // This is the URL to the API
                                })
                                .done(function (data) {
                                    // When the response to the AJAX request comes back render the chart with new data
                                    var percentage = (data.period_1["total"] - data.period_2["total"]) / data.period_2["total"] * 100;
                                    ctr.find(".difference").text(percentage.toFixed(1) + "%");
                                    ctr.find(".value-a").text(data.period_1["total"]);
                                    ctr.removeClass("disabled");
                                })
                                .fail(function () {
                                    // If there is no communication between the server, show an error
                                    //  alert("error occured");
                                });
                            window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits

                        });


                        $("input[name=visit_type]").click(function (e) {

                            $("#morris-line").toggleClass("disabled");
                            // Fire off an AJAX request to load the data
                            var from = $(this).val();
                            $.ajax({
                                    type: "GET",
                                    dataType: 'json',
                                    url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/"+$("#companyPermalink").val()+"&dimensions=ga:date&from=" + from + "&to=yesterday", // This is the URL to the API
                                })
                                .done(function (data) {
                                    // When the response to the AJAX request comes back render the chart with new data

                                    visitsArray = data;

                                    $.ajax({
                                            type: "GET",
                                            dataType: 'json',
                                            url: "/company/"+$("#companyId").val()+"/applications?from=" + from + "&to=yesterday&dateGroup=" + $("select[name=group]").val(), // This is the URL to the API
                                        })
                                        .done(function (data) {
                                            // When the response to the AJAX request comes back render the chart with new data
                                            var applicationsArray = data;

                                            var arrayStatistic = [];


                                            $(visitsArray).each(function (i, value) {
                                                var appo = [];
                                                appo["date"] = value["dimensions"];
                                                appo["pageView"] = parseInt(value["pageView"]);

                                                var applicationsDay = 0;
                                                for (var j = 0; j < applicationsArray.length; j++) {
                                                    if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                        applicationsDay = applicationsArray[j]["applications"];
                                                    }
                                                }

                                                appo["applications"] = applicationsDay;


                                                arrayStatistic.push(appo);
                                            });


                                            $("#morris-line").empty();

                                            // Line Chart
                                            var chart = Morris.Line({
                                                element: 'morris-line',
                                                xkey: 'date',
                                                ykeys: ['pageView', 'applications'],
                                                xLabels: "daily",
                                                labels: ["Visits", "Applications"],
                                                resize: true,
                                                xLabelAngle: 0
                                            });
                                            chart.setData(arrayStatistic);

                                            $("#morris-line").toggleClass("disabled");
                                        })
                                        .fail(function () {
                                            // If there is no communication between the server, show an error
                                            // alert("error occured");
                                        });


                                })
                                .fail(function () {
                                    // If there is no communication between the server, show an error
                                    // alert("error occured");
                                });


                        });


                        $(".ctr-vacancy").each(function (i, ctr) {
                            var ctr = $(this);

                            /*
                             var req = $.ajax({
                             type: "GET",
                             dataType: 'json',
                             url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@" + ctr.attr("data-permalink-vacancy") + "&from=" + "2015-01-01" + "&to=today", // This is the URL to the API
                             })
                             .done(function (data) {
                             // When the response to the AJAX request comes back render the chart with new data
                             if (data.length > 0) {
                             var result = (ctr.attr("data-applications") / data[0].dimensions) * 100;
                             ctr.text("APPL. RATE " + result.toFixed(2) + "%");
                             } else {
                             ctr.text("APPL. RATE Not available");
                             }


                             })
                             .fail(function () {
                             // If there is no communication between the server, show an error
                             //  alert("error occured");
                             });
                             statisticsRequest.push(req);                // adds a new element (Lemon) to fruits
                             */

                        });

                    } else {


                    }
                },
                error: function (data, jqXHR) {

                }
            });


            var editjqte = false;
            $('form').on('focus', 'input[type=number]', function (e) {
                $(this).on('mousewheel.disableScroll', function (e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function (e) {
                $(this).off('mousewheel.disableScroll')
            });

            var format = "{{99}}-{{99}}-{{9999}} {{99}}:{{99}}";
            if ($("html").attr("lang") != "it") {
                var format = "{{9999}}-{{99}}-{{99}} {{99}}:{{99}}";
            }
            $('.date-input-format').formatter({
                'pattern': format,
            });

            $(view.forms.newVacancy).find("#sponsored_yes").on("click", function () {
                if ($(this).is(':checked')) {
                    $(".promotional-code").show();
                    $(view.forms.newVacancy).find(".btn-add-vacancy").html('<i class="mdi-action-add-shopping-cart right"></i>Purchase');
                }
            });
            $(view.forms.newVacancy).find("#sponsored_no").on("click", function () {
                if ($(this).is(':checked')) {
                    $(".promotional-code").hide();
                    $(view.forms.newVacancy).find(".btn-add-vacancy").html('<i class="mdi-content-add right"></i>Add vacancy');
                }
            });

            $(view.forms.newVacancy).find(".modal-close").on("click", function () {

            });


            $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            $(".datepicker").datepicker({dateFormat: 'dd/mm/yy'});

            $(view.forms.newVacancy).validate({
                rules: {
                    vacancyAddName: {
                        required: true,
                        minlength: 4
                    },
                    vacancyAddDescription: {
                        required: true,
                        minlength: 4
                    },
                    vacancyAddJobFunction: "required",
                    vacancyAddStudyField: "required",
                    vacancyAddLanguages: "required",
                    vacancyAddCity: {
                        required: true,
                        minlength: 3
                    },
                    vacancyAddDate: "required"
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {


                    $("#modal-new-vacancy").find(".color-result").removeClass("red").removeClass("green");

                    $(form).find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();

                    $(form).find(".form-loader").show();

                    var vacancy = $(form).serializeArray();
                    view.vacancy = vacancy;
                    var idVacancy = null
                    $.post("/hr/job/add", vacancy, function (data, status, xhr) {

                        $(form).find(".form-loader").hide();
                        if (xhr.status == 201 && data.id != null) {

                            idVacancy = data.id;
                            view.idVacancy = idVacancy;
                            if ($('input[name="sponsored_yes"]:checked').val() == "off") {
                                $.ajax({
                                    url: "/hr/vacancy/" + data.id,
                                    type: "GET",
                                    success: function (data, jqXHR) {
                                        $(data).insertBefore("#vacancies .vacancies-container .card:first-child");
                                        $(form).find(".form-result").show();
                                        $("#modal-new-vacancy").find(".color-result").removeClass("red").addClass("green");


                                    },
                                    error: function (data, jqXHR) {

                                    }
                                });
                            } else {

                                $(form).find(".form-loader").append(
                                    "<p class='loading-text center'>We are processing your payment. Please don't close your browser until you receive payment confirmation.</p>");
                                $(form).find(".form-loader").show();
                                $("#modal-new-vacancy .email-type").text("Please review and confirm your order");

                                if ($("#codiceSconto").val() != "") {

                                    $.ajax({
                                        url: "/codice-sconto/search?codiceSconto=" + $("#codiceSconto").val(),
                                        type: "GET",
                                        dataType: "json",
                                        success: function (data, jqXHR) {

                                            if (data.length > 0) {
                                                $("#paypal_name").html($("#vacancyAddName").val());
                                                $("#paypal_description").text($("#vacancyAddDescription").val().replace(/<\/?[^>]+(>|$)/g, "").substring(0, 200));
                                                $("#paypal_seniority").html($("#vacancyAddSeniority").val());
                                                $(form).find(".form-loader").hide();
                                                $("#codiceScontoId").val(data[0].id);
                                                var total = $("#paypal_subtotal").text() - data[0].sconto;

                                                $("#paypal_subtotal").text(total);

                                                $("#paypal_total").text(total + (total * ($("#paypal_vat").text() / 100)));

                                                $(form).find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();
                                                $(".form-confirm-paypal").show();
                                            }

                                        },
                                        error: function (data, jqXHR) {

                                        }
                                    });
                                } else {
                                    $(form).find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();

                                    $("#paypal_name").html($("#vacancyAddName").val());
                                    $("#paypal_description").text($("#vacancyAddDescription").val().replace(/<\/?[^>]+(>|$)/g, "").substring(0, 200));
                                    $("#paypal_seniority").html($("#vacancyAddSeniority").val());
                                    $(form).find(".form-loader").hide();
                                    $(".form-confirm-paypal").show();

                                }


                            }


                        } else {
                            $(form).find(".form-result-error").show();
                            $("#modal-new-vacancy").find(".color-result").addClass("red");
                        }

                    }).fail(function (xhr, ajaxOptions, thrownError) {
                        $(form).find(".form-result-error").show();
                        $("#modal-new-vacancy").find(".color-result").addClass("red");
                        Raven.captureMessage("[HR] Unable to add a Vacancy");
                        Raven.setExtraContext({
                            "Ajax data": xhr,
                            "Ajax ajaxOptions": ajaxOptions,
                            "Ajax thrownError": thrownError
                        });
                        Raven.showReportDialog();

                    });
                }
            });

            $(document).on("click", ".form-do-paypal", function () {
                $(".form-confirm-paypal").hide();
                $(view.forms.newVacancy).find(".form-loader").show();

                paypal.checkout.initXO();
                view.vacancy.id = view.idVacancy;

                var action = $.post('/checkout/paypal?codiceScontoId=' + $("#codiceScontoId").val() + '&codiceSconto=' + $("#codiceSconto").val() + '&total=' + $("#paypal_total").text() + '&vacancyId=' + view.idVacancy, view.vacancy);

                action.done(function (data) {
                    paypal.checkout.startFlow(data.token);
                });

                action.fail(function () {
                    paypal.checkout.closeFlow();
                });
            });
            $(document).on('click', '.chip .material-icons', function (e) {
                e.preventDefault();
                return false;
            });
            $(view.forms.editVacancy).validate({
                rules: {
                    vacancyEditName: {
                        required: true,
                        minlength: 4
                    },
                    vacancyEditJobFunction: "required",
                    vacancyEditStudyField: "required",
                    vacancyEditLanguages: "required",
                    vacancyEditCity: {
                        required: true,
                        minlength: 3
                    },
                    vacancyEditDate: "required"
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {

                    $("#modal-edit-vacancy").find(".color-result").removeClass("red").removeClass("green");
                    $(form).find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();
                    $(form).find(".form-loader").show();

                    var id = $(form).attr("data-vacancy-id");

                    var vacancy = $(form).serializeArray();


                    if ($("#mode-edit").attr("data-mode") == "clone") {
                        vacancy.mode = "clone";
                    }


                    $.post("/hr/" + id + "/edit", vacancy, function (data, status, xhr) {

                        $(form).find(".form-loader").hide();
                        $("button").prop("disabled", false);

                        if (xhr.status == 204 || xhr.status == 201) {
                            try {
                                if (sessionStorage.getItem("editedVacancy") == null) {
                                    var a = [];
                                    a.push(JSON.parse(sessionStorage.getItem('editedVacancy')));
                                    sessionStorage.setItem('editedVacancy', JSON.stringify(a));
                                }
                                SaveDataToSessionStorage(id);
                            } catch (ee) {
                            }


                            if (xhr.status == 201) {
                                $(form).find(".form-result-clone").show();

                            } else {
                                $(form).find(".form-result").show();

                            }


                            $("#modal-edit-vacancy").find(".color-result").removeClass("red").addClass("green");

                            location.href = '';
                        } else {
                            if ($("#mode-edit").attr("data-mode") == "clone") {
                                $(form).find(".form-result-error-clone").show();

                            } else {
                                $(form).find(".form-result-error").show();

                            }
                            $("#modal-edit-vacancy").find(".color-result").addClass("red");
                        }

                    }).fail(function (xhr, ajaxOptions, thrownError) {
                        $(form).find(".form-result-error").show();
                        $("#modal-edit-vacancy").find(".color-result").addClass("red");
                        Raven.captureMessage("[HR] Unable to edit a Vacancy");
                        Raven.setExtraContext({
                            "Ajax data": xhr,
                            "Ajax ajaxOptions": ajaxOptions,
                            "Ajax thrownError": thrownError
                        });
                        Raven.showReportDialog();

                    });

                }
            });


        },
        bindUIActions: function () {

            var env = "sandbox";

            if ($('meta[name="env"]').attr("content") == "production") {
                env = "live";
            }
            paypal.checkout.setup('GVB47V5USBEU4', {
                environment: env,
                container: 'myContainer'
            });


            $("#new-vacancy textarea,#modify-company textarea").trumbowyg(
                {
                    removeformatPasted: true,
                    autoGrow: true,
                    btns: [
                        'italic',
                        '|', 'bold',
                        '|', 'btnGrp-justify',
                        '|', 'btnGrp-lists']
                }
            );
            var editjqte = false;


            view.forms.utils.recreateModal.on("click", function () {
                var form = $(this).attr("data-form");
                form = $("#" + form);
                form.find(".form-loader,.form-result,.form-result-error").hide();
                form.find(".form-content").fadeIn().find("input,textarea,select").removeClass("valid");
                $("#vacancyAddDescription").html("");
                $("#vacancyAddDescription").val("");
                $("#modal-new-vacancy").find(".color-result").removeClass("green").removeClass("red");
                $('.modal').animate({scrollTop: 0}, 'slow');
            });

            $(".modal-trigger[href='#modal-new-vacancy']").click(function (e) {
                $("#vacancyAddDescription").html("");
                $("#vacancyAddDescription").val("");

                $("#vacancyAddDescription").trumbowyg(
                    {
                        removeformatPasted: true,
                        autoGrow: true,
                        btns: [
                            'italic',
                            '|', 'bold',
                            '|', 'btnGrp-justify',
                            '|', 'btnGrp-lists']
                    }
                );
                $("#vacancyAddDescription").parent().find(".trumbowyg-editor").empty();

            });

            $(document).on("click",".vacancy-close", function () {

                var id = $(this).attr("data-id");
                var name = $(this).attr("data-name");
                swal({
                        title: "Close vacancy",
                        text: "Are you sure you want to close " + name + " vacancy?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#F04D52",
                        confirmButtonText: "Close vacancy",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {

                            if (typeof id !== "undefined") {
                                $.post("/hr/" + id + "/close", function (data, status, xhr) {
                                    if (xhr.status == 204) {
                                        $("#vacancy-" + id).fadeOut();
                                        swal({
                                            title: "Closed",
                                            text: "The vacancy " + name + " has been closed",
                                            type: "success",
                                            confirmButtonColor: "#F04D52",
                                            confirmButtonText: "OK"
                                        });
                                    } else {
                                        swal({
                                            title: "Closed",
                                            text: "Unable to close the vacancy",
                                            type: "warning",
                                            confirmButtonColor: "#F04D52",
                                            confirmButtonText: "OK"
                                        });
                                    }

                                }).fail(function (xhr, ajaxOptions, thrownError) {

                                    error("Unable to close a Vacancy");
                                    Raven.captureMessage("[HR] Unable to close a Vacancy");
                                    Raven.setExtraContext({
                                        "Ajax data": xhr,
                                        "Ajax ajaxOptions": ajaxOptions,
                                        "Ajax thrownError": thrownError
                                    });
                                    Raven.showReportDialog();

                                });


                            } else {
                                swal({
                                    title: "Closed",
                                    text: "Unable to close the vacancy",
                                    type: "warning",
                                    confirmButtonColor: "#F04D52",
                                    confirmButtonText: "OK"
                                });
                            }

                        }
                    });
            });

            view.vacancy.open.on("click", function () {
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-name");

                if (typeof id !== "undefined") {

                    $.post("/hr/" + id + "/open", function (data, status, xhr) {
                        if (xhr.status == 204) {
                            $("#vacancy-" + id).fadeOut();
                            Materialize.toast("The vacancy " + name + " has been opened", 4000);
                        } else {
                            Materialize.toast("Unable to open the vacancy " + name, 4000);
                        }

                    }).fail(function (xhr, ajaxOptions, thrownError) {
                        Materialize.toast("Unable to open the vacancy " + name, 4000);
                        Raven.captureMessage("[HR] Unable to open a Vacancy");
                        Raven.setExtraContext({
                            "Ajax data": xhr,
                            "Ajax ajaxOptions": ajaxOptions,
                            "Ajax thrownError": thrownError
                        });
                        Raven.showReportDialog();
                    });


                } else {
                    location.href = '';
                }


            });


            if ($("#luogo_lavoro").length) {
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
            }

            if ($(".address_city").length) {
                $(".address_city").autocomplete({
                    source: "/search/city",
                    minLength: 2,
                    select: function (event, ui) {

                        $(this).parent().find(".address_city_id").val(ui.item.id);
                        $(this).val(ui.item.name);

                        return false;
                    },
                    messages: {
                        noResults: '',
                        results: function () {
                        }
                    },
                    create: function () {
                        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                            return $("<li>")
                                .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
                                .appendTo(ul);
                        };
                    }
                });
            }


            $(document).on('click', '.delete-address', function (e) {
                e.preventDefault();


                if ($(".address-row").length > 1) {
                    $(this).closest(".address-row").remove();
                    $(".delete-address").prop("disabled", false);
                } else {
                    $(".delete-address").prop("disabled", true);

                }
                if ($(".address-row").length == 1) {
                    $(".delete-address").prop("disabled", true);
                }
            });

            $(document).on('click', '.action-button', function (e) {
                e.preventDefault();

                var button = $(this);

                var elementType = button.attr("data-type") ? button.attr("data-type") : "element";

                swal({
                        title: "Remove " + elementType,
                        text: "Are you sure you want to remove this " + elementType + "?",
                        type: "error",
                        showCancelButton: true,
                        confirmButtonColor: "#F04D52",
                        confirmButtonText: "Remove",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true

                    },
                    function () {

                        $.ajax({
                            url: button.attr("data-href"),
                            dataType: 'json',
                            type: button.attr("data-method"),
                            success: function (data, jqXHR) {

                                swal({
                                    title: "Removed",
                                    text: "The element has been removed",
                                    type: "info",
                                    confirmButtonColor: "#F04D52",
                                    confirmButtonText: "OK"
                                });
                                if (button.attr("data-remove")) {
                                    var str = button.attr("data-remove");
                                    $("#" + str).fadeOut();
                                }

                                if (button.closest("tr").length) {
                                    button.closest("tr").fadeOut();
                                }
                                if (button.closest("li").length) {
                                    button.closest("li").fadeOut();
                                }

                                if (button.closest(".row[data-update-route]").length) {
                                    button.closest(".row[data-update-route]").fadeOut();
                                }
                                if (button.closest(".sortable").length) {
                                    button.closest(".sortable").remove();
                                }

                                if (button.attr("data-redirect")) {
                                    location.href = button.attr("data-redirect");
                                }


                                if (button.attr("data-href").indexOf("slider") > -1) {

                                    if ($(".sortable").length < 3) {
                                        $(".photo-required").removeClass("hide");
                                        $(".count-photo").html(3 - $(".sortable").length);
                                    }

                                }


                            },
                            error: function (data, jqXHR) {

                            }
                        });


                    });


            });


            $(".add-address").click(function (e) {
                e.preventDefault();
                $(".address-row:last").clone().insertAfter(".address-row:last");
                $(".delete-address").prop("disabled", false);
                $(".address_city").autocomplete({
                    source: "/search/city",
                    minLength: 2,
                    select: function (event, ui) {

                        $(this).parent().find(".address_city_id").val(ui.item.id);
                        $(this).val(ui.item.name);

                        return false;
                    },
                    messages: {
                        noResults: '',
                        results: function () {
                        }
                    },
                    create: function () {
                        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                            return $("<li>")
                                .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
                                .appendTo(ul);
                        };
                    }
                });


            });

            $(".load-file").click(function (e) {
                var button = $(this);
                filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                filepicker.pick(
                    {
                        maxFiles: 1,
                        container: 'window',
                        services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                        extensions: ['.png', '.tiff', '.jpg', '.jpeg', '.gif'],
                        language: $("html").attr("lang")
                    },
                    function (Blobs) {
                        var url = Blobs.url;
                        $(button.attr("data-img-source")).attr("src", url);
                        $(button.attr("data-destination-url")).attr("value", url);
                        Materialize.toast("The logo has been uploaded correctly", 3000);


                    },
                    function (FPError) {
                    }
                );
            });
            $(document).on("click",".vacancy-sort", function () {
                view.fixedButtons.def.hide();
                view.fixedButtons.sort.show();

                $("#vacancies > div > div").addClass("z-depth-3 dashed");
                $("#vacancies > div").sortable();
                Materialize.toast("Drag & drop your vacancies to sort it. Press on confirmation button (in the bottom right of the page) to save changes.", 6000);


            });
            $(document).on("click",".vacancy-clone", function () {


                var id = $(this).attr("data-id");
                var json = JSON.parse($("#vacancy-data-" + id).val());
                $(".save-edit-vacancy").text("Add");

                view.forms.editVacancy.attr("data-vacancy-id", id);

                try {
                    $(".vacancy-name").text("Clone " + json.name + " vacancy");
                } catch (ee) {
                }
                try {
                    $("#vacancyEditName").val(json.name);
                } catch (ee) {
                }

                try {
                    $("#work_city_id_1").val(json.city.id);
                } catch (ee) {

                }


                try {
                    $("#is_active_edit").val(json.is_active);
                } catch (ee) {
                    $("#is_active_edit").val("true");

                }

                try {
                    if (json.is_sponsored == "" || json.is_sponsored == null) {
                        json.is_sponsored = "false";
                    }
                    $("#is_sponsored_edit").val(json.is_sponsored);
                } catch (ee) {
                    $("#is_sponsored_edit").val("false");
                }

                try {
                    $("#vacancyEditIndustry").val(json.industry.id).material_select();
                } catch (ee) {

                }

                $("#luogo_lavoro_1").val(json.city_plain_text);


                try {
                    $("#vacancyEditIndustry").val(json.industry.id).material_select();
                } catch (ee) {
                }


                var videos = JSON.parse($("#company-videos").val());


                var sl = $("#vacancyEditVideo");
                $.each(videos, function () {
                    $(sl).append($("<option />").val(this.id).text(this.name));
                });
                $(sl).material_select('update');
                $(sl).closest('.input-field').children('span.caret').remove();

                try {

                    $("#vacancyEditVideo").val(json.video.id).material_select();
                } catch (ee) {
                }
                try {
                    $("#vacancyEditJobFunction").val(json.job_function.id).material_select();
                } catch (ee) {
                }

                try {
                    $("#vacancyEditStudyField").val(json.study_field.id).material_select();
                } catch (ee) {
                }

                try {
                    $("#vacancyEditSeniority").val(json.seniority).material_select();
                } catch (ee) {
                }

                var date = moment().format('DD/MM/YYYY');
                $("#vacancyEditDate").attr("value", date);
                $("#vacancyEditDate").datepicker('setDate', date);
                $("#vacancyEditDate").parent().find("label").addClass("active");

                var languages = [];

                $.each(json.requested_languages, function () {
                    languages.push(this.system_language.id);
                });

                $("#vacancyEditLanguages").val(languages).material_select();

                $("#vacancyEditCity").val(json.city);
                $("#luogo_lavoro_1").parent().find("label").addClass("active");

                $("#action-edit").val("clone");

                $("#modal-edit-vacancy .select-wrapper").parent().find("label").removeClass("active");

                $("#modal-edit-vacancy").openModal({
                    ready: function () {

                        $("#vacancyEditDescription").val(json.description);
                        if (!editjqte) {
                            editjqte = true;
                            $("#vacancyEditDescription").trumbowyg(
                                {
                                    btns: [
                                        'italic',
                                        '|', 'bold',
                                        '|', 'btnGrp-justify',
                                        '|', 'btnGrp-lists']
                                }
                            );
                        } else {
                            $(".trumbowyg-editor").html(json.description);
                        }

                    },
                    complete: function () {
                        $("#vacancyAddDescription").val("");
                    }
                });


            });

            $(document).on("click",".vacancy-edit", function () {
                $("#action-edit").val("");
                var id = $(this).attr("data-id");


                var json = JSON.parse($("#vacancy-data-" + id).val());
                $(".save-edit-vacancy").text("Save changes");


                view.forms.editVacancy.attr("data-vacancy-id", id);


                var videos = JSON.parse($("#company-videos").val());

                var sl = $("#vacancyEditVideo");
                sl.empty();

                $(sl).append($("<option />").val("").text("Choose your video"));
                $.each(videos, function () {
                    $(sl).append($("<option />").val(this.id).text(this.name));
                });
                $(sl).material_select('update');
                $(sl).closest('.input-field').children('span.caret').remove();

                try {
                    $("#vacancyEditVideo").val(json.video.id).material_select();
                } catch (ee) {
                }


                try {
                    $(".vacancy-name").text("Edit " + json.name + " vacancy");
                } catch (ee) {
                }
                try {
                    $("#vacancyEditName").val(json.name);
                } catch (ee) {
                }

                try {
                    $("#work_city_id_1").val(json.city.id);
                } catch (ee) {

                }

                try {
                    $("#is_active_edit").val(json.is_active);
                } catch (ee) {
                    $("#is_active_edit").val("true");

                }

                try {
                    if (json.is_sponsored == "" || json.is_sponsored == null) {
                        json.is_sponsored = "false";
                    }

                    $("#is_sponsored_edit").val(json.is_sponsored);
                } catch (ee) {
                    $("#is_sponsored_edit").val("false");
                }
                try {
                    $("#vacancyEditIndustry").val(json.industry.id).material_select();
                } catch (ee) {

                }


                $("#luogo_lavoro_1").val(json.city_plain_text);

                try {
                    $("#vacancyEditIndustry").val(json.industry.id).material_select();
                } catch (ee) {
                }

                try {
                    $("#vacancyEditJobFunction").val(json.job_function.id).material_select();
                } catch (ee) {
                }

                try {
                    $("#vacancyEditStudyField").val(json.study_field.id).material_select();
                } catch (ee) {
                }

                try {
                    $("#vacancyEditSeniority").val(json.seniority).material_select();
                } catch (ee) {
                }

                var date = moment(json.open_date).format('DD/MM/YYYY');
                $("#vacancyEditDate").attr("value", date);
                $("#vacancyEditDate").datepicker('setDate', date);
                $("#vacancyEditDate").parent().find("label").addClass("active");


                var languages = [];

                $.each(json.requested_languages, function () {
                    languages.push(this.system_language.id);
                });

                $("#vacancyEditLanguages").val(languages).material_select();

                $("#vacancyEditCity").val(json.city);
                $("#luogo_lavoro_1").parent().find("label").addClass("active");

                $("#modal-edit-vacancy .select-wrapper").parent().find("label").removeClass("active");

                $("#modal-edit-vacancy").openModal({
                    ready: function () {

                        $("#vacancyEditDescription").val(json.description);
                        if (!editjqte) {
                            editjqte = true;
                            $("#vacancyEditDescription").trumbowyg(
                                {
                                    btns: [
                                        'italic',
                                        '|', 'bold',
                                        '|', 'btnGrp-justify',
                                        '|', 'btnGrp-lists']
                                }
                            );
                        } else {
                            $(".trumbowyg-editor").html(json.description);
                        }

                    },
                    complete: function () {
                        $("#vacancyAddDescription").val("");
                    }
                });


            });


            view.fixedButtons.sort.on("click", function () {

                view.fixedButtons.sort.find(".mdi-action-done").hide();
                view.fixedButtons.sort.find(".preloader-wrapper").show();

                var sortedId = [];
                $("div[id^='vacancy']").each(function (i, el) {
                    sortedId.push($(el).attr("data-vacancy-id"));

                });

                $.post("/hr/job/sort", {vacancies: sortedId}, function (data, status, xhr) {
                    view.fixedButtons.sort.find(".mdi-action-done").show();
                    view.fixedButtons.sort.find(".preloader-wrapper").hide();

                    if (xhr.status == 204) {
                        Materialize.toast("The vacancies has been sorted", 6000);
                        view.fixedButtons.def.show();
                        view.fixedButtons.sort.hide();
                        $("#vacancies > div > div").removeClass("z-depth-3 dashed");
                        $("#vacancies > div").sortable({
                            disabled: true
                        });

                    } else {
                        Materialize.toast("Unable to sort vacancies", 6000);
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    Materialize.toast("Unable to sort vacancies", 6000);
                    Raven.captureMessage("[HR] Unable to sort vacancies");
                    Raven.setExtraContext({
                        "Ajax data": xhr,
                        "Ajax ajaxOptions": ajaxOptions,
                        "Ajax thrownError": thrownError
                    });
                    Raven.showReportDialog();
                });
            });


            $(document).on("click", ".unsponsored,.sponsor-now", function () {
                var btn = $(this);
                $("#modal-sponsor-vacancy .paypal_name").html(btn.attr("data-vacancy-name"));
                $("#modal-sponsor-vacancy .paypal_description").html(btn.attr("data-vacancy-description").substring(0, 200));
                $("#modal-sponsor-vacancy .paypal_seniority").html(btn.attr("data-vacancy-seniority"));
                $("#modal-sponsor-vacancy .paypal_id").val(btn.attr("data-vacancy-id"));

                $("#modal-sponsor-vacancy").find(".form-loader").hide();


                $("#modal-sponsor-vacancy").find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();
                $(".form-confirm-paypal").show();
                $("#modal-sponsor-vacancy").openModal();

            });

            $(".check-promotional-code").click(function () {
                $(".not-valid").remove();
                $("#modal-sponsor-vacancy button").attr("disabled", true);
                $.ajax({
                    url: "/codice-sconto/search?codiceSconto=" + $("#codiceScontoSponsor").val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data, jqXHR) {
                        if (data.length > 0) {
                            $("#modal-sponsor-vacancy button").attr("disabled", false);

                            $("#modal-sponsor-vacancy").find(".form-loader").hide();
                            $("#codiceScontoSponsorId").val(data[0].id);
                            var total = $("#modal-sponsor-vacancy .paypal_subtotal").text() - data[0].sconto;
                            $("#modal-sponsor-vacancy .paypal_subtotal").text(total);

                            $("#modal-sponsor-vacancy .paypal_total").text(total + (total * ($("#paypal_vat").text() / 100)));
                            $(".check-promotional-code").replaceWith($("<p class='green-text' style='margin-top:20px'>Valid code!</p>"));
                        } else {
                            $(".check-promotional-code").after($("<p class='red-text not-valid' style='margin-top:20px'>Invalid code!</p>"));
                            $("#modal-sponsor-vacancy button").attr("disabled", false);

                        }

                    },
                    error: function (data, jqXHR) {

                    }
                });
            });


            $(document).on("click", ".pay-sponsor-vacancy", function (e) {
                e.preventDefault();
                $("#modal-sponsor-vacancy .form-confirm-paypal").hide();

                $("#modal-sponsor-vacancy").find(".form-loader").append(
                    "<p class='loading-text center'>We are processing your payment. Please don't close your browser until you receive payment confirmation.</p>");

                $("#modal-sponsor-vacancy").find(".form-loader").show();

                paypal.checkout.initXO();
                var id = $("#modal-sponsor-vacancy .paypal_id").val();

                var action = $.post('/checkout/paypal?codiceScontoId=' + $("#codiceScontoSponsorId").val() + '&codiceSconto=' + $("#codiceScontoSponsor").val() + '&total=' + $("#modal-sponsor-vacancy .paypal_total").text() + '&vacancyId=' + id, $.parseJSON($("#vacancy-data-" + id).val()));

                action.done(function (data) {
                    paypal.checkout.startFlow(data.token);
                });

                action.fail(function () {
                    paypal.checkout.closeFlow();
                });
            });


        }


    };
