var view,
    HR = {
        settings: {

            forms: {
                recoverPassword: $("form#recover-password-form")

            },
            buttons : {
                recoverPassword : $("#recover-password-btn")
            }

        },


        init: function () {
            view = this.settings;
            this.pageSettings();
            this.bindUIActions();
        },
        pageSettings: function () {


        },
        bindUIActions: function () {

            view.form.recoverPassword.submit(function (e) {

                e.preventDefault();
                var form = $(this);
                var params = $(this).serializeArray();

                form.find(".alert").addClass("hide");


                view.buttons.recoverPassword.button('loading');


                $.ajax({
                    url: $(this).attr("action"),
                    dataType: 'json',
                    type: $(this).attr("method"),
                    data: params,
                    success: function (data, jqXHR) {
                       alert("Your password has been changed. Please Log In");
                        window.location.href = "/login";
                    },
                    error: function (data, jqXHR) {
                        var error = jQuery.parseJSON(data.responseText);
                        $(".error-login").text(error.message).removeClass("hide");
                        btn.button('reset');
                    }
                });
            });




        }


    };
