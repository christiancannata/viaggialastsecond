var view,
    MyCandidates = {
        settings: {

            forms: {
                newCategory: $("form#new-category"),
                utils: {
                    recreateModal: $(".form-recreate-modal")
                }
            },
            modal: {
                newCategory: $("#modal-new-category")
            },
            button: {
                removeCategory: $(".remove-category")
            }

        },


        init: function () {
            view = this.settings;
            this.pageSettings();
            this.bindUIActions();
        },
        pageSettings: function () {


            $(view.forms.newCategory).validate({
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


                    view.modal.newCategory.find(".color-result").removeClass("red").removeClass("green");
                    $(form).find(".form-result-error,.form-result,.form-content").hide();
                    $(form).find(".form-loader").show();

                    var category = $(form).serializeArray();

                    $.post("/hr/category/add", category, function (data, status, xhr) {

                        $(form).find(".form-loader").hide();
                        if (xhr.status == 201 && data.id != null) {
                            $(form).find(".form-result").show();
                            view.modal.newCategory.find(".color-result").removeClass("red").addClass("green");

                        } else {
                            $(form).find(".form-result-error").show();
                            view.modal.newCategory.find(".color-result").addClass("red");
                        }
                        $("button").prop("disabled", false);

                    }).fail(function () {
                        $(form).find(".form-loader").hide();
                        $(form).find(".form-result-error").show();
                        view.modal.newCategory.find(".color-result").addClass("red");
                        $("button").prop("disabled", false);

                    });
                }
            });


        },
        bindUIActions: function () {
            view.button.removeCategory.on("click", function () {
                var id = $(this).attr("data-id");

                swal({
                        title: "Remove category",
                        text: "Are you sure you want to remove the category?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#F04D52",
                        confirmButtonText: "Delete",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: '/hr/category/'+ id,
                                type: 'DELETE',
                                success: function(result) {
                                    $("#category-" + id).fadeOut();
                                    swal({
                                        title: "Deleted",
                                        text: "The category has been deleted",
                                        type: "success",
                                        confirmButtonColor: "#F04D52",
                                        confirmButtonText: "OK"
                                    }, function () {
                                        if ($(".categories li:visible").length <= 0) {
                                            window.location.reload();
                                        }
                                    });
                                },
                                error : function (){
                                    swal({
                                        title: "Error",
                                        text: "Unable to delete the category",
                                        type: "warning",
                                        confirmButtonColor: "#F04D52",
                                        confirmButtonText: "OK"
                                    });

                                }
                            });



                        }
                    });

            });

            view.forms.utils.recreateModal.on("click", function () {
                var form = $(this).attr("data-form");
                $("#" + form).find(".form-loader,.form-result,.form-result-error").hide();
                $("#" + form).find(".form-content").fadeIn().find("input[type=text], textarea").val("");
                $("#modal-new-category").find(".color-result").removeClass("green").removeClass("red");
                var validator = $("#"+form).validate();
                validator.resetForm();
                $('.modal').animate({scrollTop: 0}, 'slow');
            });

        }

    };
