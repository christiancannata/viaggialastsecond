/**
 *
 * Meritocracy Framework 0.11
 *
 * */


var app = [];
app.blades = [];
    Meritocracy = {
        settings: {
            loadTemplates : $('div[data-type="meritocracy-load-template"]')
        },


        init: function () {
            view = this.settings;
            this.bindUIActions();
            this.pageConfiguration();
            this.loadBladeTemplates();
        },
        pageConfiguration: function () {
            $(document).ajaxError(function (event, jqXHR, ajaxSettings, thrownError) {
                try {
                    if (jqXHR.status != null && jqXHR.status != 409 && jqXHR.status != 401) {
                        Raven.captureMessage("| Generic ajaxError exception |", {
                            extra: {
                                type: ajaxSettings.type,
                                url: ajaxSettings.url,
                                data: ajaxSettings.data,
                                status: jqXHR.status,
                                error: thrownError || jqXHR.statusText,
                                response: jqXHR.responseText
                            }
                        });
                    }
                } catch (e) {
                    Raven.captureException(e);
                }
            });
        },
        validEmail : function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        loadBladeTemplates : function (filter) {
            view.loadTemplates.each(function () {

                var element = $(this);
                if (element.attr("data-url") != null) {
                    Meritocracy.getBladeAjax(element, element.attr("data-url"), element.attr("data-id"));
                }
            });
        },
        bindUIActions: function () {

        },
        getBladeAjax: function (element, url, reloadProperty) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (data, textStatus, xhr) {

                    if (xhr.status == 200) {
                        $(element).html(data);
                    }
                },
                error: function (data, textStatus, xhr) {
                    
                }
            });
        }
    };
