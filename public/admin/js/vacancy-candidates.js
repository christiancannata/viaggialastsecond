/**
 * Helper function for javascript
 */
function categorySave(btn) {
    var id = $(btn).attr("data-id");
    var name = $(btn).attr("data-name");
    var applicationId = $(btn).attr("data-application-id");
    Materialize.toast("Saving candidate to category...", 4000);

    if (id != null && id.length > 0) {
        $.ajax({
            url: '/hr/category/' + $(btn).attr("data-id") + '/add',
            type: 'POST',
            data: {applicationId: applicationId},
            success: function (result) {
                $(".jsgrid-table > tbody > tr")[window.selectedRow].click();
                Materialize.toast("Candidate has been saved to " + name + " category", 4000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Materialize.toast("Unable to save in category", 4000);
                Raven.captureMessage("Unable to save a candidate in a category");
                Raven.setExtraContext({
                    "Ajax data": xhr,
                    "Ajax ajaxOptions": ajaxOptions,
                    "Ajax thrownError": thrownError
                });
                Raven.showReportDialog();

            }
        });
    } else {
        Materialize.toast("Unable to save in category (missing ID)", 4000);
    }
}

var view,
    VacancyCandidates = {

        //All settings must go here
        settings: {
            test: "test"
        },


        init: function () {
            view = this.settings;
            this.pageSettings();
            this.bindUIActions();
            this.initCandidates();
        },
        pageSettings: function () {

            $(".leftside-navigation").css("transform", "translateX(-100%)");


        },
        sortIncoming: function (sort) {
            $("#incoming-candidates-list").jsGrid({
                height: "90%",
                width: "100%",
                pageSize: 10,
                autoload: true,
                paging: true,
                loadIndication: true,
                onDataLoaded: function () {

                    if ($(".jsgrid-row").length > 0) {
                        $(".jsgrid-row")[0].click();
                    }

                },
                controller: {


                    loadData: function () {

                        var deferred = $.Deferred();

                        if (sort == null) {
                            sort = "";
                        }


                        $.ajax({
                            url: "/vacancy/" + $("#vacancy-id").val() + "/applications/sent?serializerGroup=summary&sort=" + sort,
                            dataType: "json",
                            error: function (xhr, ajaxOptions, thrownError) {
                                Raven.captureMessage("Unable to load candidates lists in incoming");
                                Raven.setExtraContext({
                                    "Ajax data": xhr,
                                    "Ajax ajaxOptions": ajaxOptions,
                                    "Ajax thrownError": thrownError
                                });
                                Raven.showReportDialog();
                            }
                        }).done(function (response) {
                            $('a[href="#incoming"]').find("b.number").html(response.length);
                            deferred.resolve(response);

                        });

                        return deferred.promise();

                    }
                },

                rowClick: function (args) {


                    $("#incoming-candidate-detail").html('<div style="width:100%;" class="center"><div class="preloader-wrapper big active " style="margin-top:30px">                    <div class="spinner-layer spinner-red-only">  <div class="circle-clipper left">  <div class="circle"></div>  </div>  <div class="gap-patch">  <div class="circle"></div>  </div>  <div class="circle-clipper right">  <div class="circle"></div>  </div>  </div>  </div>  </div></div>');
                    var id = args.item.id;


                    var url = "/hr/application/" + id;

                    if ($("#userType").length && $("#userType").val() == "ADMINISTRATOR") {
                        url += "?companyID=" + document.companyID;
                    }


                    $.get(url, function (data) {

                            $("tr.jsgrid-selected-row-2").removeClass("jsgrid-selected-row-2")
                            $("tr[data-id=" + id + "]").addClass("jsgrid-selected-row-2");
                            window.selectedRow = $("tr.jsgrid-selected-row-2").index();

                            $("#incoming-candidate-detail").html(data);

                            var params = {
                                "status": "READ",
                                "title": "Application viewed",
                                "comment": "The application has been viewed",
                                "application": {"id": id},
                                "author": {"id": $("#userId").val()}
                            };

                            $.ajax({
                                method: "POST",
                                url: "/event/application",
                                data: params,
                                success: function (data, textStatus, xhr) {


                                }
                            });
                        })
                        .done(function () {

                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            Raven.captureMessage("[HR] Unable to load a candidate");
                            Raven.setExtraContext({
                                "Ajax jqXHR": jqXHR,
                                "Ajax ajaxOptions": textStatus,
                                "Ajax errorThrown": errorThrown
                            });
                            Raven.showReportDialog();

                        })
                        .always(function () {

                        });
                },

                rowRenderer: function (item) {
                    if (item.status == "SENT" && item.active == true) {
                        return $("<tr>").attr("data-id", item.id).append($("<td>").append(VacancyCandidates.renderRowCandidate(item)));
                    }

                }
            });

        },
        resetFeedbackModal: function (id) {
            $("#modal-application-event").find(".color-result").removeClass("red").removeClass("green");
            $("#send-comment-application-event .form-content").show();
            $("#send-comment-application-event .form-result,.form-result-error").hide();
            $("#send-comment-application-event .id-application").val(id);
            $("#send-comment-application-event").attr("data-id", id);
            $("#commentApplication").text("");
            $('#_feedbackSelect').val("");
            $('#_feedbackSelect').material_select();

            $("#feedbackSave").parent().show();
            $("#feedbackSave").removeAttr('checked');
        },
        bindUIActions: function () {


            $(document).on("click", "#remove-comment", function (event) {

                var id = $(this).attr("data-id");
                if (id != null && id.length > 0) {
                    $.ajax({
                        url: '/event/comment/' + $(this).attr("data-id"),
                        type: 'DELETE',
                        success: function (result) {
                            $(".jsgrid-table > tbody > tr")[window.selectedRow].click();
                            Materialize.toast("Note has been removed successfully", 4000);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Materialize.toast("[HR] Unable to remove note", 4000);
                            Raven.setExtraContext({
                                "Ajax xhr": jqXHR,
                                "Ajax ajaxOptions": ajaxOptions,
                                "Ajax thrownError": thrownError
                            });
                            Raven.showReportDialog();

                        }
                    });
                } else {
                    Materialize.toast("Unable to note comment (missing id)", 4000);
                }

            });

            $(document).on("click", "#save-comment", function (event) {

                if ($("#candidateComment:visible").val().length > 0 && $("#candidateComment:visible").val().length <= 1000) {

                    $("#save-comment").addClass("disabled");
                    var id = $(this).attr("data-id");

                    $.post("/event/comment/" + id, {comment: $("#candidateComment:visible").val()}, function (data, status, xhr) {

                        $("#save-comment").removeClass("disabled");

                        if (xhr.status == 201 || xhr.status == 204) {
                            Materialize.toast("Note has been saved successfully", 4000);
                            $(".jsgrid-table > tbody > tr")[window.selectedRow].click();
                        } else {
                            Materialize.toast("Note not saved: " + xhr.status + " error", 4000);
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        $("#save-comment").removeClass("disabled");
                        Materialize.toast("Note not saved due to a server error", 4000);
                        Raven.captureMessage("[HR] Unable to save a note");
                        Raven.setExtraContext({
                            "Ajax jqXHR": jqXHR,
                            "Ajax ajaxOptions": textStatus,
                            "Ajax errorThrown": errorThrown
                        });
                        Raven.showReportDialog();
                    });
                } else {
                    Materialize.toast("Please type a note contains at max 1000 characters", 4000);

                }


            });


            $(document).on("click", ".ask-upload-cv", function (event) {
                var id = $(this).attr("data-id");
                $("#modal-request-cv").openModal();
                $("#modal-request-cv").find(".color-result").removeClass("red").removeClass("green");
                $("#send-request-cv .form-content").show();
                $("#send-request-cv .id-application").val(id);

                $("#send-request-cv").attr("data-id", id);
                $(".feedback-user-name").text("Request CV to the candidate");
                $("#feedbackSave").parent().hide();
            });
            $(document).on("click", ".add-category", function (event) {
                $("#modal-new-category").openModal();
                $("#modal-new-category").find(".color-result").removeClass("red").removeClass("green");
                $("#modal-new-category .form-content").show();
            });


            $('select#_feedbackSelect').on("change", function () {
                var text = $(this).val();

                try {
                    text = text.replace("|name|", window.currentCandidateName);
                    text = text.replace("|surname|", window.currentCandidateLastName);
                } catch (ee) {
                    text = text.replace("|name|", "");
                    text = text.replace("|surname|", "");
                }
                $("#feedbackSave").parent().hide();

                $("#commentApplication").text(text);
            });


            $(document).on("click", ".next-profile", function (event) {
                if ($(".jsgrid-selected-row-2").next().length <= 0) {
                    var current = $(".jsgrid:visible").jsGrid("option", "pageIndex");
                    $(".jsgrid:visible").jsGrid("openPage", current + 1);
                    $(".jsgrid-row")[0].click();
                } else {
                    $(".jsgrid-selected-row-2").next().click();

                }
            });

            $(document).on("click", ".previous-profile", function (event) {
                if ($(".jsgrid-selected-row-2").prev().length <= 0) {
                    var current = $(".jsgrid:visible").jsGrid("option", "pageIndex");
                    $(".jsgrid:visible").jsGrid("openPage", current - 1);
                    $(".jsgrid-row")[0].click();
                } else {
                    $(".jsgrid-selected-row-2").prev().click();

                }
            });

            $(document).on("click", ".show-history", function (event) {
                event.preventDefault();
                $("#modal-history-" + $(this).attr("data-id")).openModal({
                    complete: function () {
                        // $(".modal-history").remove();
                    }
                });

            });

            $(document).on("click", ".send-feedback-all", function (event) {
                var id = "";
                var count = 0;
                var btn = $(this);

                $("#send-comment-application-event .form-content").hide();
                $("#send-comment-application-event .form-loader").show();

                $("#modal-application-event").openModal();


                $.ajax({
                    url: '/vacancy/' + btn.attr("data-id-vacancy") + '/applications/wait-feedback/' + btn.attr("data-feedback-type"),
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {

                        if (result.length > 0) {

                            id = result.join();
                            var abbr = "";
                            if (result.length > 1) {
                                abbr = "s";
                            }
                            $(".feedback-user-name").text("Send a feedback to " + result.length + " candidate" + abbr);
                            $("#application_id").attr("value", id);

                            VacancyCandidates.resetFeedbackModal(id);

                            $("#send-comment-application-event .form-content").show();
                            $("#send-comment-application-event .form-loader").hide();
                        } else {
                            $("#modal-application-event").closeModal();
                            $("#send-comment-application-event")[0].reset();

                            swal({
                                title: "Feedback sent",
                                text: "All " + btn.attr("data-feedback-type") + " feedback are already sent!",
                                type: "success",
                                confirmButtonColor: "#F04D52",
                                confirmButtonText: "OK"
                            });
                        }


                    },
                    error: function (xhr, ajaxOptions, thrownError) {


                    }
                });


            });

            $(document).on("click", ".pleasepressthosebuttons button", function (event) {

                //UI Actions
                $("#profile-page").toggleClass("disabled");
                $(this).attr("disabled", "disabled");


                var id = $(this).attr("data-id");
                var type = $(this).attr("data-type");
                window.feedbackType = $(this).attr("data-status");

                if (id != null && type != null && id.length > 0 && type.length > 0) {
                    try {
                        var name = $(this).parent().attr("data-name");
                        var surname = $(this).parent().attr("data-surname");

                        window.currentCandidateName = name;
                        window.currentCandidateLastName = surname;
                        $(".feedback-user-name").text("Send a feedback to").append(" <b>" + name + " " + surname + "</b>");

                    } catch (ee) {
                        window.currentCandidateName = "";
                        window.currentCandidateLastName = "";
                    }

                    VacancyCandidates.resetFeedbackModal(id);

                    if (type != "SENT") {
                        $("#modal-application-event").openModal();
                    }
                    if (type == "CONTACT") {
                        $("#profile-page").toggleClass("disabled");
                        $(".pleasepressthosebuttons button").removeAttr("disabled");
                        $("#application_id").attr("value", id);
                        return;
                    }


                    $.post("/hr/application/" + id + "/" + type, function (data, status, xhr) {
                        if (xhr.status == 201) {

                            $("#profile-page").toggleClass("disabled");
                            $(".pleasepressthosebuttons button").removeAttr("disabled");
                            $("#application_id").attr("value", id);


                            $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#profile-page").toggleClass("disabled");

                            if (type == "SENT") {
                                if ($("#detail-application").length) {
                                    $("#detail-application").remove();
                                    $("#candidates").removeClass("hide");
                                }
                            }

                        } else {
                            Materialize.toast("Unable to accept or reject a candidate", 4000);
                            Raven.captureMessage("[HR] Unable to accept or reject a candidate");

                            location.href = '';
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        Materialize.toast("Unable to accept or reject a candidate", 4000);
                        Raven.captureMessage("[HR] Unable to accept or reject a candidate");
                        Raven.setExtraContext({
                            "Ajax jqXHR": jqXHR,
                            "Ajax textStatus": textStatus,
                            "Ajax errorThrown": errorThrown
                        });
                        Raven.showReportDialog();
                    });
                } else {
                    Materialize.toast("Unable to make changes to the candidate. Please contact info@meritocracy.is", 4000);
                    Raven.captureMessage("[HR] Unable to make changes to the candidate.");

                }


            });

            $(".date-order").on("click", function () {
                $(this).hide();
                $(".rank-order").show();
                VacancyCandidates.sortIncoming("date");
            });
            $(".rank-order").on("click", function () {
                $(this).hide();
                $(".date-order").show();
                VacancyCandidates.sortIncoming();
            });

            $("#send-request-cv").submit(function (e) {
                $("#modal-request-cv").closeModal();
                e.preventDefault();
                $.ajax({
                    url: "/event/requestCv/" + $(this).find(".id-application").val(),
                    dataType: 'json',
                    type: "PATCH",
                    data: $(this).serialize(),
                    success: function (data, jqXHR) {
                        $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
                        $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                        $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
                        $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');
                        $("#profile-page").toggleClass("disabled");
                        Materialize.toast("Request has been sent to the candidate", 4000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Materialize.toast("Unable to send request to the candidate", 4000);
                        Raven.captureMessage("[HR] Unable to send request to the candidate");
                        Raven.setExtraContext({
                            "Ajax data": xhr,
                            "Ajax ajaxOptions": ajaxOptions,
                            "Ajax thrownError": thrownError
                        });
                        Raven.showReportDialog();

                    }
                });

            });


            $("#send-comment-application-event").submit(function (e) {

                $("#send-comment-application-event button").attr("disabled", true);

                $("#send-comment-application-event .form-content").hide();
                $("#send-comment-application-event .form-loader").show();
                $(".loading-text").remove();

                if ($("#feedbackSave").is(":checked")) {
                    try {

                        var feedback = {
                            feedbackTitle: "Feedback " + moment().format('MM/D/YYYY h:mm'),
                            feedbackDescription: $("#commentApplication").val(),
                            feedbackType: window.feedbackType
                        };

                        $.post("/hr/feedback/add", feedback, function (data, status, xhr) {
                            Materialize.toast("Feedback template has been added", 4000);

                        });
                    } catch (ee) {
                        alert("Unable to save feedback template");
                        Raven.captureException(ee);
                        Raven.showReportDialog();

                    }

                }


                if ($(this).find(".id-application").val() != null && $(this).find(".id-application").val().length > 0) {
                    e.preventDefault();


                    var ids = $(this).find(".id-application").val().split(",");
                    $("#send-comment-application-event .form-loader").append(
                        "<p class='loading-text center'>Sending feedback to 1/" + ids.length + "</p>");
                    var conta = 2;
                    for (var i in ids) {

                        $.ajax({
                            url: "/event/application/" + ids[i],
                            dataType: 'json',
                            type: "PATCH",
                            async: false,
                            data: $("#send-comment-application-event").serialize(),
                            success: function (data, jqXHR) {
                                $("#send-comment-application-event .loading-text").replaceWith(
                                    "<p class='loading-text center'>Sending feedback to " + conta + "/" + ids.length + "</p>");
                                conta++;
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                Materialize.toast("Unable to send feedback to user", 4000);
                                Raven.captureMessage("[HR] Error while sending a feedback to user");
                                Raven.setExtraContext({
                                    "Ajax data": xhr,
                                    "Ajax ajaxOptions": ajaxOptions,
                                    "Ajax thrownError": thrownError
                                });
                                Raven.showReportDialog();

                            }
                        });
                    }


                    Materialize.toast("The feedback has been sent to the user", 4000);
                    $("#send-comment-application-event button").attr("disabled", false);


                    $("#send-comment-application-event .form-content").show();
                    $("#send-comment-application-event .form-loader").hide();
                    $(".loading-text").remove();

                    $(".send-feedback-all").addClass("green").text("Feedback Sent to all!");

                    $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
                    $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                    $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
                    $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');

                    $("#modal-application-event").closeModal({});
                    $("#send-comment-application-event")[0].reset();

                } else {
                    Materialize.toast("Unable to send feedback to user, missing ID", 4000);
                }


            })
            ;

        },
        renderRowCandidate: function (item) {
            var user = item.user;

            var name = user.first_name.capitalize() + " " + user.last_name.capitalize();
            if (name.length <= 1) {
                name = "Name not provided";
            }

            var city = "";
            if (user.city != null && user.city.name != null) {
                city = user.city.name;
            }

            var birth = new Date(user.birthdate);
            var age = "";
            if (birth != null && birth > 0 && $("html").attr("lang") == "it") {
                var value = moment().diff(birth, 'years');
                if (value > 0) {
                    age = " (" + value + " years)";

                }
            }
            var lastJob = {};
            try {


                if (user.short_bio != null && user.short_bio != "") {
                    lastJob.role = user.short_bio;
                } else {
                    lastJob = item.last_work;
                    if (lastJob == null) {
                        lastJob = {};
                        lastJob.role = "No work experiences";

                    } else if (lastJob.role.length <= 0) {
                        lastJob.role = "Role not available";

                        if (lastJob.job_function != null) {
                            lastJob.role = lastJob.job_function.name;
                        }
                        if (lastJob.company_plain_text !== null && lastJob.company_plain_text.length > 0) {
                            lastJob.role += " at " + lastJob.company_plain_text;
                        }


                    } else {
                        lastJob.role = lastJob.role + " at " + lastJob.company_plain_text + "";
                    }
                }


            } catch (ee) {
                lastJob = {};
                lastJob.role = "No work experiences";
            }


            var mdate = moment(item.created_at);
            var data = mdate.fromNow();

            var bold = "bold";
            if (item.read != null && item.read == 1) {
                bold = "not-bold";
            }
            var contacted = "";
            if (item.contacted != null && item.contacted == 1) {
                contacted = '<input type="hidden" class="contacted"><i class="mdi-content-reply"></i>&nbsp;';
            }


            var html = ' <div  class="vacancy-candidate-info col l12 m12 s12">' + contacted + '<span class="title-name ' + bold + '"><strong>' + name + age + '</strong></span> <p class="grey-text ultra-small truncate">' + lastJob.role + '</p> <span  class="grey-text ultra-small ">' + data + '</span></div>';
            return html;
        },
        initCandidates: function () {

            VacancyCandidates.sortIncoming();


            $("#accepted-candidates-list").jsGrid({
                height: "90%",
                width: "100%",
                pageSize: 10,
                autoload: true,
                paging: true,
                loadIndication: true,
                controller: {
                    loadData: function () {

                        var deferred = $.Deferred();

                        $.ajax({
                            url: "/vacancy/" + $("#vacancy-id").val() + "/applications/starred?serializerGroup=summary&sort=",
                            dataType: "json"
                        }).done(function (response) {
                            $('a[href="#liked"]').find("b.number").html(response.length);

                            deferred.resolve(response);

                            //  $("#accepted-candidates-list .jsgrid-table tr:first-child").click();
                        });

                        return deferred.promise();

                    }
                },

                rowClick: function (args) {

                    $("#accepted-candidate-detail").html('<div style="width:100%;" class="center"><div class="preloader-wrapper big active " style="margin-top:30px">                    <div class="spinner-layer spinner-red-only">  <div class="circle-clipper left">  <div class="circle"></div>  </div>  <div class="gap-patch">  <div class="circle"></div>  </div>  <div class="circle-clipper right">  <div class="circle"></div>  </div>  </div>  </div>  </div></div>');


                    var id = args.item.id;

                    var url = "/hr/application/" + id;

                    if ($("#userType").length && $("#userType").val() == "ADMINISTRATOR") {
                        url += "?companyID=" + document.companyID;
                    }


                    $.get(url, function (data) {
                            $("#accepted-candidate-detail").html(data);

                            $("tr.jsgrid-selected-row-2").removeClass("jsgrid-selected-row-2")
                            $("tr[data-id=" + id + "]").addClass("jsgrid-selected-row-2");

                            window.selectedRow = $("tr.jsgrid-selected-row-2").index();
                            var params = {
                                "status": "READ",
                                "title": "Application viewed",
                                "comment": "The application has been viewed",
                                "application": {"id": id}
                                , "author": {"id": $("#userId").val()}
                            };

                            $.ajax({
                                method: "POST",
                                url: "/event/application",
                                data: params,
                                success: function (data, textStatus, xhr) {


                                }
                            });

                        })
                        .done(function () {

                        })
                        .fail(function () {
                        })
                        .always(function () {

                        });
                },

                rowRenderer: function (item) {
                    if (item.status == "STARRED" && item.active == true) {
                        return $("<tr>").attr("data-id", item.id).append($("<td>").append(VacancyCandidates.renderRowCandidate(item)));

                    }

                }


            });


            $("#rejected-candidates-list").jsGrid({
                height: "90%",
                width: "100%",
                pageSize: 10,

                autoload: true,
                paging: true,
                loadIndication: true,
                controller: {
                    loadData: function () {

                        var deferred = $.Deferred();

                        $.ajax({
                            url: "/vacancy/" + $("#vacancy-id").val() + "/applications/rejected?serializerGroup=summary&sort=",
                            dataType: "json"
                        }).done(function (response) {

                            $('a[href="#disliked"]').find("b.number").html(response.length);

                            deferred.resolve(response);

                            // $("#rejected-candidates-list .jsgrid-table tr:first-child").click();

                        });

                        return deferred.promise();

                    }
                },


                rowClick: function (args) {
                    var id = args.item.id;
                    $("#rejected-candidate-detail").html('<div style="width:100%;" class="center"><div class="preloader-wrapper big active " style="margin-top:30px">                    <div class="spinner-layer spinner-red-only">  <div class="circle-clipper left">  <div class="circle"></div>  </div>  <div class="gap-patch">  <div class="circle"></div>  </div>  <div class="circle-clipper right">  <div class="circle"></div>  </div>  </div>  </div>  </div></div>');


                    var url = "/hr/application/" + id;

                    if ($("#userType").length && $("#userType").val() == "ADMINISTRATOR") {
                        url += "?companyID=" + document.companyID;
                    }


                    $.get(url, function (data) {

                            $("tr.jsgrid-selected-row-2").removeClass("jsgrid-selected-row-2")
                            $("tr[data-id=" + id + "]").addClass("jsgrid-selected-row-2");

                            window.selectedRow = $("tr.jsgrid-selected-row-2").index();
                            $("#rejected-candidate-detail").html(data);
                            var params = {
                                "status": "READ",
                                "title": "Application viewed",
                                "comment": "The application has been viewed",
                                "application": {"id": id}
                                , "author": {"id": $("#userId").val()}
                            };

                            $.ajax({
                                method: "POST",
                                url: "/event/application",
                                data: params,
                                success: function (data, textStatus, xhr) {
                                }
                            });
                        })
                        .done(function () {

                        })
                        .fail(function () {
                            Materialize.toast("Unable to retrieve candidate data");
                        })
                        .always(function () {

                        });


                },

                rowRenderer: function (item) {

                    if (item.status == "REJECTED" && item.active == true) {
                        return $("<tr>").attr("data-id", item.id).append($("<td>").append(VacancyCandidates.renderRowCandidate(item)));

                    }

                }
                ,


                fields: []
            });
            String.prototype.capitalize = function () {
                return this.charAt(0).toUpperCase() + this.slice(1);
            };


            $("#hired-candidates-list").jsGrid({
                height: "90%",
                width: "100%",
                pageSize: 10,

                autoload: true,
                paging: true,
                loadIndication: true,

                controller: {
                    loadData: function () {
                        var deferred = $.Deferred();

                        $.ajax({
                            url: "/vacancy/" + $("#vacancy-id").val() + "/applications/hired?serializerGroup=summary",
                            dataType: "json"
                        }).done(function (response) {

                            $('a[href="#hired"]').find("b.number").html(response.length);

                            deferred.resolve(response);

                            // $("#hired-candidates-list .jsgrid-table tr:first-child").click();

                        });

                        return deferred.promise();

                    }
                },

                rowClick: function (args) {


                    $("#hired-candidate-detail").html('<div style="width:100%;" class="center"><div class="preloader-wrapper big active " style="margin-top:30px">                    <div class="spinner-layer spinner-red-only">  <div class="circle-clipper left">  <div class="circle"></div>  </div>  <div class="gap-patch">  <div class="circle"></div>  </div>  <div class="circle-clipper right">  <div class="circle"></div>  </div>  </div>  </div>  </div></div>');


                    var id = args.item.id;

                    var url = "/hr/application/" + id;

                    if ($("#userType").length && $("#userType").val() == "ADMINISTRATOR") {
                        url += "?companyID=" + document.companyID;
                    }


                    $.get(url, function (data) {
                            $("#hired-candidate-detail").html(data);

                            $("tr.jsgrid-selected-row-2").removeClass("jsgrid-selected-row-2")
                            $("tr[data-id=" + id + "]").addClass("jsgrid-selected-row-2");

                            window.selectedRow = $("tr.jsgrid-selected-row-2").index();
                            var params = {
                                "status": "READ",
                                "title": "Application viewed",
                                "comment": "The application has been viewed",
                                "application": {"id": id}
                                , "author": {"id": $("#userId").val()}
                            };

                            $.ajax({
                                method: "POST",
                                url: "/event/application",
                                data: params,
                                success: function (data, textStatus, xhr) {


                                }
                            });
                        })
                        .done(function () {

                        })
                        .fail(function () {
                            Materialize.toast("Unable to retrieve candidate data");
                        })
                        .always(function () {

                        });
                },

                rowRenderer: function (item) {

                    if (item.status == "HIRED" && item.active == true) {
                        return $("<tr>").attr("data-id", item.id).append($("<td>").append(VacancyCandidates.renderRowCandidate(item)));

                    }

                },


                fields: []
            });


        }


    };
