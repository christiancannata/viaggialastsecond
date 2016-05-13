/**
 * Lorenzo Saraniti
 * Javascript template example
 * 12/08/2015
 */

var view,
    Example = {

        //All page settings must go here. Also place significant DOM nodes that will need to be accessed regularly.
        settings: {
            setting1: true, //E.g. enable sticky scroll , true or false
            button1: $("#button1") //E.g. discover meritocracy button
        },

        //We will have just one function be called from the blade template.
        init: function() {
            view = this.settings; //This variable will be the point of all settings.
            this.bindUIActions();
        },
        bindUIActions: function() {
            view.button1.on("click", function() {
                Example.function1();
            });
        },
        function1: function() {

        }
    };

