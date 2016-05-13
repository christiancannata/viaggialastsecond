var view,
    Application = {

        //All settings must go here
        settings: {
            applicationBtn: $("#apply")},


        init: function () {
            view = this.settings;
            this.bindUIActions();

        },
        bindUIActions: function () {
            view.applicationBtn.click(function () {
                $.post( "/vacancy-application", { vacancyId: $("#vacancyId").val() })
                    .done(function( data ) {
                        alert( "Data Loaded: " + data );
                    });
            });



        }




    };