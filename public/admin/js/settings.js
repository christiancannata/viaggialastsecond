var view,
    Settings = {
        settings: {

            forms: {
                newFeedback: $("form#new-feedback"),
                utils: {
                    recreateModal: $(".form-recreate-modal")
                }
            },
            modal: {
                newFeedback: $("#modal-new-feedback")
            },
            button: {
                removeFeedback: $(".remove-feedback")
            }

        },


        init: function () {
            view = this.settings;
            this.pageSettings();
            this.bindUIActions();
        },
        pageSettings: function () {

            $(document).ready(function (){
                OneSignal.push(["isPushNotificationsEnabled", function (enabled) {
                    if (enabled) {
                        $(".active-push").attr("checked","checked");
                    }
                }]);

                $("form#new-feedback").validate({
                    rules: {
                        feedbackDescription: {
                            required: true,
                            minlength: 4
                        },
                        feedbackTitle: {
                            required: true,
                            minlength: 6
                        },
                        feedbackType: "required"
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


                        view.modal.newFeedback.find(".color-result").removeClass("red").removeClass("green");
                        $(form).find(".form-result-error,.form-result,.form-content").hide();
                        $(form).find(".form-loader").show();

                        var feedback = $(form).serializeArray();

                        $.post("/hr/feedback/add", feedback, function (data, status, xhr) {

                            $(form).find(".form-loader").hide();
                            if (xhr.status == 201 && data.id != null) {
                                $(form).find(".form-result").show();
                                view.modal.newFeedback.find(".color-result").removeClass("red").addClass("green");

                            } else {
                                $(form).find(".form-result-error").show();
                                view.modal.newFeedback.find(".color-result").addClass("red");
                            }
                            $("button").prop("disabled", false);

                        }).fail(function () {
                            $(form).find(".form-loader").hide();
                            $(form).find(".form-result-error").show();
                            view.modal.newFeedback.find(".color-result").addClass("red");
                            $("button").prop("disabled", false);

                        });
                    }
                });


                $(".active-push").change(function() {
                    if (this.checked) {
                        try{
                            OneSignal.push(["setSubscription", true]);
                        }catch(ee){}

                        OneSignal.push(["isPushNotificationsEnabled", function (enabled) {
                            if (!enabled) {
                                OneSignal.push(["registerForPushNotifications"]);
                            } else {
                                alert("Push notification already enabled","Not neeeded","warning");
                            }

                        }]);

                    } else {
                        OneSignal.push(["setSubscription", false]);

                    }
                });

            });






        },
        bindUIActions: function () {

            view.button.removeFeedback.on("click", function () {
                var id = $(this).attr("data-id");

                swal({
                        title: "Remove feedback",
                        text: "Are you sure you want to remove the feedback?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#F04D52",
                        confirmButtonText: "Delete",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {

                            $.post("/hr/feedback/" + id + "/remove", null, function (data, status, xhr) {
                                if (xhr.status == 200) {
                                    $("#feedback-" + id).fadeOut();
                                    swal({
                                        title: "Deleted",
                                        text: "The feedback has been deleted",
                                        type: "success",
                                        confirmButtonColor: "#F04D52",
                                        confirmButtonText: "OK"
                                    }, function () {
                                        if ($(".feedbacks li:visible").length <= 0) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    swal({
                                        title: "Error",
                                        text: "Unable to delete the feedback",
                                        type: "warning",
                                        confirmButtonColor: "#F04D52",
                                        confirmButtonText: "OK"
                                    });
                                }
                            });


                        }
                    });

                    $("#vacancyEditLanguages").val(languages).material_select();


                try {
                    $("#vacancyEditCity").val(json.city);
                } catch (ee) {
                }

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
                            $(".jqte_editor").html(json.description);
                        }

                    },
                    complete: function () {
                    }
                });


            });

            view.forms.utils.recreateModal.on("click", function () {
                var form = $(this).attr("data-form");
                $("#" + form).find(".form-loader,.form-result,.form-result-error").hide();
                $("#" + form).find(".form-content").fadeIn().find("input[type=text], textarea").val("");
                $("#modal-new-feedback").find(".color-result").removeClass("green").removeClass("red");
                var validator = $("#"+form).validate();
                validator.resetForm();
                $('.modal').animate({scrollTop: 0}, 'slow');
            });

        }

    };
