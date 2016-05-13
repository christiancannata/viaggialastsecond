var view,
    MeritocracyBox = {
        settings: {
            target: "meritocracy-box",
            meritocracyBoxLink: "https://local.meritocracy.is/it/%c/%i/company/vacancies/box",
            scriptIdentifier : "meritocracy-box-script",
            attributeId : "data-id",
            attributeName : "data-name",
            customTarget : "data-custom-target"


        },

        init: function () {
            view = this.settings;
            this.loadBox();
        },
        loadBox: function () {
            //Get parameters to load box


            var scriptIdentifier = document.getElementById(view.scriptIdentifier);
            var identifier =  scriptIdentifier.getAttribute(view.attributeId);
            var company =   scriptIdentifier.getAttribute(view.attributeName);
            var customTarget = scriptIdentifier.getAttribute(view.customTarget);
            var meritocracyBoxLink = view.meritocracyBoxLink.replace("%c",company).replace("%i",identifier);

            var target = document.getElementById(customTarget) != null ?
                document.getElementById(customTarget) :
                document.getElementById(view.target);
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if(xhr.readyState === 4) {
                    if(xhr.status === 200) {
                        target.innerHTML = xhr.responseText;
                    }
                }
            };

            xhr.open('GET', meritocracyBoxLink);
            xhr.send(null);
        }

    };
MeritocracyBox.init();