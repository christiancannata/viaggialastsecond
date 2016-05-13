

var view,
    VacancyDbCandidates = {

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

            setTimeout(function () {
                $(".leftside-navigation").css("left", "-250px");
            }, 200);


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
                            url: "/category/" + $("#category-id").val()+"/applications?serializerGroup=summary&sort=" + sort,
                            dataType: "json"
                        }).done(function (response) {
                            $('a[href="#incoming"]').find("b.number").html(response.length);
                            deferred.resolve(response);

                        });

                        return deferred.promise();

                    }
                },

                rowClick: function (args) {
                    window.selectedRow = args.itemIndex;

                    $("#incoming-candidate-detail").html('<div style="width:100%;" class="center"><div class="preloader-wrapper big active " style="margin-top:30px">                    <div class="spinner-layer spinner-red-only">  <div class="circle-clipper left">  <div class="circle"></div>  </div>  <div class="gap-patch">  <div class="circle"></div>  </div>  <div class="circle-clipper right">  <div class="circle"></div>  </div>  </div>  </div>  </div></div>');
                    var id = args.item.id;


                    $.get('/hr/application/' + id+"?categoryMode=1", function (data) {

                            $("tr.jsgrid-selected-row-2").removeClass("jsgrid-selected-row-2")
                            $("tr[data-id=" + id + "]").addClass("jsgrid-selected-row-2");

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
                        .fail(function () {
                            alert("error");
                        })
                        .always(function () {

                        });
                },

                rowRenderer: function (item) {
                    if (item.active == true) {
                        return $("<tr>").attr("data-id", item.id).append($("<td>").append(VacancyDbCandidates.renderRowCandidate(item)));
                    }

                },


                fields: []
            });

        },
        bindUIActions: function () {

            $(document).on("click",".remove-application-category", function (){
                var id = $(this).attr("data-id");
                if(id != null && id.length > 0) {
                    $.ajax({
                        url: '/category/application/'+ id,
                        type: 'DELETE',
                        success: function(result) {
                            $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                            Materialize.toast("Application has been removed from the category", 4000);
                        },
                        error : function (){
                            Materialize.toast("Unable to remove application from category, server error", 4000);

                        }
                    });
                } else {
                    Materialize.toast("Unable to remove application from category (missing id)", 4000);
                }

            });

            $(document).on("click", "#remove-comment", function (event) {

                var id = $(this).attr("data-id");
                if(id != null && id.length > 0) {
                    $.ajax({
                        url: '/event/comment/'+$(this).attr("data-id"),
                        type: 'DELETE',
                        success: function(result) {
                            $(".jsgrid-table > tbody > tr")[window.selectedRow].click();
                            Materialize.toast("Comment has been removed successfully", 4000);
                        },
                        error : function (){
                            Materialize.toast("Unable to remove comment, server error", 4000);

                        }
                    });
                } else {
                    Materialize.toast("Unable to remove comment (missing id)", 4000);
                }

            });

            $(document).on("click", "#save-comment", function (event) {

                if($("#candidateComment").val().length > 0 && $("#candidateComment").val().length <= 1000){

                    $("#save-comment").addClass("disabled");
                    var id = $(this).attr("data-id");

                    $.post("/event/comment/" + id, {comment: $("#candidateComment").val()}, function (data, status, xhr) {

                        $("#save-comment").removeClass("disabled");

                        if (xhr.status == 201 || xhr.status == 204) {
                            Materialize.toast("Note has been saved successfully", 4000);
                            $(".jsgrid-table > tbody > tr")[window.selectedRow].click();
                        } else {
                            Materialize.toast("Note not saved: " + xhr.status + " error", 4000);
                        }

                    }).fail(function () {
                        $("#save-comment").removeClass("disabled");
                        Materialize.toast("Note not saved due to a server error", 4000);
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
                $("#feedbackSave").hide();


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

                $("#commentApplication").text(text);
            });


            $(document).on("click", ".next-profile", function (event) {
                $(".jsgrid-table > tbody > tr")[window.selectedRow + 1].click();
            });
            $(document).on("click", ".previous-profile", function (event) {
                $(".jsgrid-table > tbody > tr")[window.selectedRow - 1].click();
            });
            $(document).on("click", ".pleasepressthosebuttons button", function (event) {

                var id = $(this).attr("data-id");
                var application_id = id;
                var type = $(this).attr("data-type");
                var status = $(this).attr("data-status");

                try {
                    var name = $(this).parent().attr("data-name");
                    var surname = $(this).parent().attr("data-surname");
                } catch (ee) {
                }


                $("#profile-page").toggleClass("disabled");

                if (type == "CONTACT") {
                    $("#modal-application-event").openModal();
                    $("#modal-application-event").find(".color-result").removeClass("red").removeClass("green");
                    $("#send-comment-application-event .form-content").show();
                    $("#send-comment-application-event .form-result,.form-result-error").hide();
                    $("#send-comment-application-event .form-result-error").hide();
                    $("#send-comment-application-event .id-application").val(id);

                    $("#send-comment-application-event").attr("data-id", id);
                    try {
                        window.feedbackType = status;
                        if (name != null && surname != null) {
                            window.currentCandidateName = name;
                            window.currentCandidateLastName = surname;
                            $(".feedback-user-name").text("Send a feedback to").append(" <b>" + name + " " + surname + "</b>");
                        } else {
                            $(".feedback-user-name").text("Send a feedback to the candidate");
                        }
                        $("#feedbackSave").show().removeAttr('checked');

                    } catch (ee) {
                    }
                    return;
                }

                $(this).attr("disabled", "disabled");

                $.post("/hr/application/" + id + "/" + type, function (data, status, xhr) {
                    if (xhr.status == 201) {

                        var id = data.id;
                        $("#modal-application-event").find(".color-result").removeClass("red").removeClass("green");
                        $("#send-comment-application-event .form-content").show();
                        $("#send-comment-application-event .form-result,.form-result-error").hide();
                        $("#send-comment-application-event .form-result-error").hide();
                        $("#send-comment-application-event .id-application").val(id);

                        $("#send-comment-application-event").attr("data-id", id);
                        try {

                            $(".feedback-user-name").text("Send a feedback to").append(" <b>" + name + " " + surname + "</b>");
                        } catch (ee) {
                        }

                        if (type != "SENT") {
                            $("#modal-application-event").openModal();
                        }

                        $("#profile-page").toggleClass("disabled");
                        $(".pleasepressthosebuttons button").removeAttr("disabled");

                        if (type == "SENT") {
                            $("ul li a[href='#incoming']").click();

                            $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');
                            $("#profile-page").toggleClass("disabled");

                        }

                        $("#application_id").attr("value", application_id);

                    } else {
                        Materialize.toast("Unable to accept or reject a candidate", 4000);
                        location.href = '';
                    }

                }).fail(function () {
                    Materialize.toast("Unable to accept or reject a candidate", 4000);
                    location.href = '';
                });

            });

            $(".date-order").on("click", function () {
                $(this).hide();
                $(".rank-order").show();
                VacancyDbCandidates.sortIncoming("date");
            });
            $(".rank-order").on("click", function () {
                $(this).hide();
                $(".date-order").show();
                VacancyDbCandidates.sortIncoming();
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
                    error: function (data, jqXHR) {
                        Materialize.toast("Unable to send request to the candidate", 4000);
                    }
                });

            });


            $("#send-comment-application-event").submit(function (e) {


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
                        alert("Unable to save feedback tempplate");
                    }

                }


                e.preventDefault();
                $.ajax({
                    url: "/event/application/" + $(this).find(".id-application").val(),
                    dataType: 'json',
                    type: "PATCH",
                    data: $(this).serialize(),
                    success: function (data, jqXHR) {


                        $("#modal-application-event").closeModal({
                            complete: function () {
                                $("#send-comment-application-event")[0].reset();
                                $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
                                $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
                                $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
                                $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');
                                $("#profile-page").toggleClass("disabled");
                            }
                        });

                    },
                    error: function (data, jqXHR) {

                    }
                });

            });

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

            VacancyDbCandidates.sortIncoming();


        }


    };
