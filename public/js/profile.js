
$(document).ready(function () {

    setTimeout(function (){
        $('#lettura').barrating({
            theme: 'fontawesome-stars',
            onSelect: function (value, text, event) {
                $('#lettura').closest(".select-wrapper").find(".select-dropdown").attr("value", value);
                $('#lettura').val(value);

            }
        });


        $('#scrittura').barrating({
            theme: 'fontawesome-stars',
            onSelect: function (value, text, event) {
                $('#scrittura').closest(".select-wrapper").find(".select-dropdown").attr("value", value);
                $('#scrittura').val(value);

            }
        });

        $('#dialogo').barrating({
            theme: 'fontawesome-stars',
            onSelect: function (value, text, event) {
                $('#dialogo').closest(".select-wrapper").find(".select-dropdown").attr("value", value);
                $('#dialogo').val(value);

            }
        });

    }, 3000);


    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15,
        format: 'mm/yyyy',
        max: new Date()
    });

    appendToSelect_API("/search/systemLanguage", ".select2-languages");

    $("button").removeAttr("disabled");

    if (getURLParameter("completeApplication") != null) {
        swal({
                title: trans('complete_profile_title'),
                text: trans('complete_profile_desc'),
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: trans('complete_profile_btn'),
                closeOnConfirm: true
            },
            function () {
                setTimeout(function () {
                    if ($.cookie('pushProfileRequest') == null || $.cookie('pushProfileRequest') != 1) {
                        $.cookie('pushProfileRequest', 1);
                        requirePush();
                    }
                }, 7000);
            });
    } else {
        if ($.cookie('pushProfileRequest') == null || $.cookie('pushProfileRequest') != 1) {
            $.cookie('pushProfileRequest', 1);
            requirePush();
        }
    }


    $(".tab-profile ul li").click(function () {

        $("#profile-page-wall-share .tab-content > a").show();
        $("#profile-page-wall-share .tab-content form").hide();

    });


    $(".confirm-button").click(function () {
        var button = $(this);

        swal({
                title: "Delete element",
                text: trans('remove_element'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "",
                closeOnConfirm: false
            },
            function () {

                $.ajax({
                    url: button.attr("data-href"),
                    dataType: 'json',
                    type: button.attr("data-method"),
                    success: function (data, jqXHR) {

                        Materialize.toast('Deleted Successfully!', 2000, '', button.attr("callback"));
                        if (button.closest("tr").length) {
                            button.closest("tr").fadeOut();
                        }
                        if (button.closest("li").length) {
                            button.closest("li").fadeOut();
                        }

                        if (button.closest(".row[data-update-route]").length) {
                            button.closest(".row[data-update-route]").fadeOut();
                        }


                        if (button.attr("data-redirect")) {
                            location.href = button.attr("data-redirect");
                        }

                        swal("Item deleted!", "", "success");


                    },
                    error: function (data, jqXHR) {

                    }
                });


            });
    });


    filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");

    $(".avatar-image,.modify-avatar").click(function () {
        filepicker.pick(
            {
                cropDim: [120, 120],
                mimetype: 'image/*',
                services: ['CONVERT', 'COMPUTER'],
                conversions: ['crop']
            },
            function (Blob) {

                $(".avatar-image").css("opacity", 0.6);

                $.ajax({
                    type: "PATCH",
                    url: "/user",
                    data: {avatar: Blob.url, pk: $("#userId").val()},
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 200 || xhr.status == 204 || xhr.status == 201) {

                            $(".avatar-image").attr("src", Blob.url);
                            $(".avatar-image").css("opacity", 1);


                            $(".profile-image").attr("src", Blob.url);
                            $(".profile-image").css("opacity", 1);

                        }
                    },
                    error: function (data, textStatus, xhr) {

                    },
                    dataType: "json"
                });
            }
        );
    });




    var Address = function (options) {
        this.init('address', options, Address.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Address, $.fn.editabletypes.abstractinput);

    $.extend(Address.prototype, {
        /**
         Renders input from tpl

         @method render()
         **/
        render: function () {
            this.$input = this.$tpl.find('input');
        },

        /**
         Default method to show value in element. Can be overwritten by display option.

         @method value2html(value, element)
         **/
        value2html: function (value, element) {
            if (!value) {
                $(element).empty();
                return;
            }
            var html = $('<div>').text(value.first_name).html() + ' ' + $('<div>').text(value.last_name).html();
            $(element).html(html);
        },

        /**
         Gets value from element's html

         @method html2value(html)
         **/
        html2value: function (html) {
            /*
             you may write parsing method to get value by element's html
             e.g. "Moscow, st. Lenina, bld. 15" => {city: "Moscow", street: "Lenina", building: "15"}
             but for complex structures it's not recommended.
             Better set value directly via javascript, e.g.
             editable({
             value: {
             city: "Moscow",
             street: "Lenina",
             building: "15"
             }
             });
             */
            return null;
        },

        /**
         Converts value to string.
         It is used in internal comparing (not for sending to server).

         @method value2str(value)
         **/
        value2str: function (value) {
            var str = '';
            if (value) {
                for (var k in value) {
                    str = str + k + ':' + value[k] + ';';
                }
            }
            return str;
        },

        /*
         Converts string to value. Used for reading value from 'data-value' attribute.

         @method str2value(str)
         */
        str2value: function (str) {
            /*
             this is mainly for parsing value defined in data-value attribute.
             If you will always set value by javascript, no need to overwrite it
             */
            return str;
        },

        /**
         Sets value of input.

         @method value2input(value)
         @param {mixed} value
         **/
        value2input: function (value) {
            if (!value) {
                return;
            }
            this.$input.filter('[name="first_name"]').val(value.first_name);
            this.$input.filter('[name="last_name"]').val(value.last_name);
        },

        /**
         Returns value of input.

         @method input2value()
         **/
        input2value: function () {
            return {
                first_name: this.$input.filter('[name="first_name"]').val(),
                last_name: this.$input.filter('[name="last_name"]').val(),
            };
        },

        /**
         Activates input: sets focus on the first field.

         @method activate()
         **/
        activate: function () {
            this.$input.filter('[name="first_name"]').focus();
        },

        /**
         Attaches handler to submit form in case of 'showbuttons=false' mode

         @method autosubmit()
         **/
        autosubmit: function () {
            this.$input.keydown(function (e) {
                if (e.which === 13) {
                    $(this).closest('form').submit();
                }
            });
        }
    });

    Address.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-address"><label><span>First name: </span><input type="text" name="first_name" class="input-small"></label></div>' +
        '<div class="editable-address"><label><span>Last name: </span><input type="text" name="last_name" class="input-small"></label></div>',
        inputclass: ''
    });

    $.fn.editabletypes.address = Address;


    if ($("#work-experience-form").length) {
        $("#work-experience-form")[0].reset();
        $("#education-form")[0].reset();
        $("#language-form")[0].reset();
    }
    ;

    $.fn.editable.defaults.ajaxOptions = {type: "PATCH"};
    $.fn.editable.defaults.send = "always";
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-primary btn-sm editable-submit">' +
        '<i class="mdi-action-done"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-default btn-sm editable-cancel">' +
        '<i class="mdi-content-clear "></i>' +
        '</button>';

    // $('.editable').editable({});

    $('#name').editable({
        url: '/user',
        title: 'Inserisci il tuo nome e cognome',
        value: {
            first_name: $("#firstName").val(),
            last_name: $("#lastName").val()
        }
    });

    $('#telefono').editable({
        url: '/user',
        title: 'Inserisci il recapito telefonico'
    });

    if(isMobile()){
        var text= $("#telefono").parent().find("a:nth-child(2)").text();
        $("#telefono").parent().find("a:nth-child(2)").remove();
        $("#telefono").text(text);

    }


    if ($("html").attr("lang") == "it") {
        $('#birthdate').editable({
            format: 'DD-MM-YYYY',
            viewformat: 'DD-MM-YYYY',
            template: 'DD-MM-YYYY',
            combodate: {
                minYear: 1920,
                maxYear: 2005,
                minuteStep: 1
            },
            url: '/user',
        });
    } else {
        $('#birthdate').editable({
            format: 'YYYY-MM-DD',
            viewformat: 'YYYY-MM-DD',
            template: 'YYYY-MM-DD',
            combodate: {
                minYear: 1920,
                maxYear: 2005,
                minuteStep: 1
            },
            url: '/user',
        });
    }


    $('#city').editable({
        url: '/user',
        title: 'Inserisci la data di nascita'
    });
    $('#short_bio').editable({
        url: '/user',
        title: 'Inserisci la data di nascita',
        inputclass: 'short_bio'
    });


    $(".tab-content .show-tab").click(function () {
        $(this).hide();
        $(this).closest(".tab-content").find("form").show();
    });

    $("#luogo_lavoro").autocomplete({
        source: "/search/city",
        minLength: 2,
        select: function (event, ui) {

            $("#work_city_id").val(ui.item.id);
            $("#luogo_lavoro").val(ui.item.name);

            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
            .appendTo(ul);
    };

    $("#studio_attuale,input[id^='lavoro_attuale_'],input[name='studio_attuale'],#lavoro_attuale").click(function () {
        var monthPicker = $(this).closest("form").find("input[id^='data_fine']");

        if ($(this).is(':checked')) {

            monthPicker.MonthPicker('option', 'Disabled', true);

            if ($(this).attr('name') == "studio_attuale") {
                $("#grade_min,#grade_max,input[name='grade_min'],input[name='grade_max']").attr("disabled", true);
            }
            monthPicker.val("01/2100");


        } else {

            monthPicker.MonthPicker('option', 'Disabled', false);
            if ($(this).attr('name') == "studio_attuale") {
                $("#grade_min,#grade_max,input[name='grade_min'],input[name='grade_max']").removeAttr("disabled");
            }
            monthPicker.val("01/2016");
            monthPicker.click();
        }


    });



    $("#studio_attuale,#lavoro_attuale").click(function () {
        if ($(this).is(':checked')) {

            $(this).closest(".input-field").find(".datepicker").MonthPicker('option', 'Disabled', true);

            if ($(this).attr('id') == "studio_attuale") {
                $("#grade_min,#grade_max").attr("disabled", true);
            }

        } else {
            $(this).closest(".input-field").find(".datepicker").MonthPicker('option', 'Disabled', false);
            if ($(this).attr('id') == "studio_attuale") {
                $("#grade_min,#grade_max").removeAttr("disabled");
            }
        }


    });


    $("#job_function").autocomplete({
        source: "/search/tags?type=JOBFUNCTION",
        minLength: 2,
        select: function (event, ui) {

            $("#job_function_id").val(ui.item.id);

            if ($("html").attr("lang") == "it") {
                $("#job_function").val(ui.item.name_it);


            } else {
                $("#job_function").val(ui.item.name);

            }


            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {

        if ($("html").attr("lang") == "it") {
            return $("<li>")
                .append("<a><i class=\"fa fa-briefcase\"></i>" + item.name_it + "</a>")
                .appendTo(ul);
        } else {
            return $("<li>")
                .append("<a><i class=\"fa fa-briefcase\"></i>" + item.name + "</a>")
                .appendTo(ul);
        }

    };

    $("#azienda").autocomplete({
        source: "/search/company",
        minLength: 2,
        select: function (event, ui) {

            $("#azienda_id").val(ui.item.id);
            $("#azienda").val(ui.item.name);
            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {

        var city = "";
        if (typeof item.city_plain_text !== "undefined") {
            city = " - " + item.city_plain_text;
        }

        return $("<li>")
            .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + "" + city + "</a>")
            .appendTo(ul);
    };

    /*  $("#role").autocomplete({
     source: "/search/job-title",
     minLength: 2,
     select: function (event, ui) {

     $("#role_id").val(ui.item.id);

     var name = "";

     if (ui.item.name != "") {
     name = ui.item.name;
     }


     if (typeof ui.item.name_it !== "undefined" && ui.item.name_it != "" && $("html").attr("lang") == "it") {
     name = ui.item.name_it;
     }


     $("#role").val(name);
     return false;
     },
     messages: {
     noResults: '',
     results: function () {
     }
     }
     }).autocomplete("instance")._renderItem = function (ul, item) {
     var name = "";

     if (item.name != "") {
     name = item.name;
     }


     if (typeof item.name_it !== "undefined" && item.name_it != "" && item.name_it != null && $("html").attr("lang") == "it") {
     name = item.name_it;
     }


     return $("<li>")
     .append("<a>" + name + "</a>")
     .appendTo(ul);
     };
     */

    $("#education").autocomplete({
        source: "/search/tags?type=STUDYFIELD",
        minLength: 2,
        select: function (event, ui) {

            $("#education_id").val(ui.item.id);
            if ($("html").attr("lang") == "it") {
                $("#education").val(ui.item.name_it);
            } else {
                $("#education").val(ui.item.name);

            }
            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {

        if ($("html").attr("lang") == "it") {
            return $("<li>")
                .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name_it + "</a>")
                .appendTo(ul);
        } else {
            return $("<li>")
                .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name + "</a>")
                .appendTo(ul);
        }

    };


    $("#school").autocomplete({
        source: "/search/school",
        minLength: 2,
        select: function (event, ui) {

            $("#school_id").val(ui.item.id);
            $("#school").val(ui.item.name);

            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<a><i class=\"prefix fa fa-graduation-cap\"></i>" + item.name + "</a>")
            .appendTo(ul);
    };



    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        }
    );


    $("#work-experience-form").validate({
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

            var params = $(form).serializeArray();

            $("button").attr("disabled", "true");

            $.ajax({
                type: "POST",
                url: "/work-experience?check_email=true",
                data: params,
                success: function (data, textStatus, xhr) {
                    if (xhr.status == 201 || xhr.status == 204) {

                        var id = data.id;
                        
                        $.ajax({
                            type: "GET",
                            url: "/work-experience/" + id,
                            success: function (data, textStatus, xhr) {
                                if (xhr.status == 200 || xhr.status == 201) {

                                    if ($("#work-collections .empty-row").length) {
                                        $("#work-collections .empty-row").remove();
                                    }

                                    Meritocracy.loadBladeTemplates("profile");
                                    Materialize.toast('<span>' + trans('esperienza_lavorativa_creata') + '</span>', 4000);

                                    $("#contatore-work").text(parseInt($("#contatore-work").text()) + 1);
                                    $(form).parent().find(".show-tab").show();
                                    $(form).hide();
                                    $("#profile-page-wall-share .tab-content form").hide();
                                    $("button").removeAttr("disabled");


                                }
                            },
                            error: function (data, textStatus, xhr) {
                                Materialize.toast('Unable to add the work experience to your profile', 4000);

                            }
                        });


                    }

                    $("button").removeAttr("disabled");

                },
                error: function (data, textStatus, xhr) {
                    $("button").removeAttr("disabled");
                },
                dataType: "json"
            });
        }
    });


    $("#education-form").validate({
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

            var params = $(form).serializeArray();

            $("#education-form button").attr("disabled", "true");

            $.ajax({
                type: "POST",
                url: "/education?check_email=true",
                data: params,
                success: function (data, textStatus, xhr) {
                    if (xhr.status == 201 || xhr.status == 204) {

                        var id = data.id;

                        $("button").removeAttr("disabled");

                        $.ajax({
                            type: "GET",
                            url: "/education/" + id,
                            success: function (data, textStatus, xhr) {
                                if (xhr.status == 200) {

                                    if ($("#education-collections .empty-row") != null && $("#education-collections .empty-row").length > 0) {
                                        $("#education-collections .empty-row").remove();
                                    }

                                    Meritocracy.loadBladeTemplates("profile");

                                    $("#contatore-education").text(parseInt($("#contatore-education").text()) + 1);

                                    Materialize.toast('<span>' + trans('education_creata') + '</span>', 4000);
                                    $(form).parent().find(".show-tab").show();
                                    $("button").removeAttr("disabled");
                                    $(form).hide();
                                }
                            },
                            error: function (data, textStatus, xhr) {

                            }
                        });


                    }
                },
                error: function (data, textStatus, xhr) {
                    $("button").removeAttr("disabled");
                },
                dataType: "json"
            });
        }
    });
    $("#language-form").validate({
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

            var params = $(form).serializeArray();
            $("button").attr("disabled",true);


            $.ajax({
                type: "POST",
                url: "/language?check_email=true",
                data: params,
                success: function (data, textStatus, xhr) {
                    if (xhr.status == 201 || xhr.status == 204) {

                        var id = data.id;


                        $.ajax({
                            type: "GET",
                            url: "/language/" + id,
                            success: function (data, textStatus, xhr) {
                                if (xhr.status == 200) {

                                   $("#contatore-lingue").text(parseInt($("#contatore-lingue").text()) + 1);
                                    Meritocracy.loadBladeTemplates("profile");

                                    Materialize.toast('<span>' + trans('lingua_pubblicata') + '</span>', 4000);
                                    $(form).parent().find(".show-tab").show();
                                    $(form).hide();
                                    $("button").attr("disabled",false);

                                }
                            },
                            error: function (data, textStatus, xhr) {

                            }
                        });


                    }
                },
                error: function (data, textStatus, xhr) {

                },
                dataType: "json"
            });
        }
    });


});

$(function () {
    $(".leftside-navigation li a[href='/" + $("meta[name=route]").attr("content") + "']").parent().addClass("active");


    if(document.getElementById("map-canvas") != null){
        // Google Maps
        $('#map-canvas').addClass('loading');
        var latlng = new google.maps.LatLng(40.6700, -73.9400); // Set your Lat. Log. New York
        var settings = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,
            scrollwheel: false,
            draggable: true,
            styles: [{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#e0efef"}]
            }, {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"hue": "#1900ff"}, {"color": "#c0e8e8"}]
            }, {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{"lightness": 100}, {"visibility": "simplified"}]
            }, {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{"visibility": "on"}, {"lightness": 700}]
            }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#7dcdcd"}]}],
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
            navigationControl: false,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"), settings);

        google.maps.event.addDomListener(window, "resize", function () {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
            $('#map-canvas').removeClass('loading');
        });

        var contentString =
            '<div id="info-window">' +
            '<p>18 McLuice Road, Vellyon Hills,<br /> New York, NY 10010<br /><a href="https://plus.google.com/102896039836143247306/about?gl=za&hl=en" target="_blank">Get directions</a></p>' +
            '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var companyImage = new google.maps.MarkerImage('http://demo.geekslabs.com/ashoka/images/map-marker.png',
            new google.maps.Size(36, 62),// Width and height of the marker
            new google.maps.Point(0, 0),
            new google.maps.Point(18, 52)// Position of the marker
        );

        var companyPos = new google.maps.LatLng(40.6700, -73.9400);

        var companyMarker = new google.maps.Marker({
            position: companyPos,
            map: map,
            icon: companyImage,
            title: "Shapeshift Interactive",
            zIndex: 3
        });

        google.maps.event.addListener(companyMarker, 'click', function () {
            infowindow.open(map, companyMarker);
            // pageView('http://demo.geekslabs.com/#address');
        });
    }



});