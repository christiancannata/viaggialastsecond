var RegistrationUtils = function () {


    var signUpWithParsing = function (mail, profile, parsedCv, callback) {
        var jsonArray = jsonGenerator.jsonGen("ADD", {name: profile.name, familyName: profile.familyName, password : profile.password, email : mail, config: parsedCv}, "user");


        if ($("#birthdate_parsing").length) {
            jsonArray.data.config.profile.birthdate = $("#birthdate_parsing").val();
        }

        console.log(jsonArray);

        sendAjaxCall(jsonArray, "/register/user", function (data, textStatus, xhr) {
            callback(data, textStatus, xhr);
        });
    };


    return {
        //main function to initiate the module
        init: function () {


        },
        signUpWithParsing: function (mail, profile, parsedCv, callback) {
            signUpWithParsing(mail, profile, parsedCv, callback);
        }

    };

}();