/*================================================================================
 Item Name: Materialize - Material Design Admin Template
 Version: 3.0
 Author: GeeksLabs
 Author URL: http://www.themeforest.net/user/geekslabs
 ================================================================================

 NOTE:
 ------
 PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
 WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

/**
 * General Utility for Material Select
 */
function appendToSelect(array, selectIdentifier) {
    var select = $("select" + selectIdentifier);

    $.each(select, function () {
        var sl = this;
        $.each(array, function () {
            $(sl).append($("<option />").val(this.value).text(this.text));
        });
        $(sl).material_select('update');
        $(sl).closest('.input-field').children('span.caret').remove();
    });

}
function toggle(div, toggle, hideMe, hideMeDiv) {
    $(div).toggle(toggle);
    if (hideMe && $(hideMeDiv).length > 0) {
        $(hideMeDiv).hide();
    }
}


function appendToSelect_API(url, select) {
    var cacheIdentifier = "_select-api-" + url;
    var array = sessionStorage.getItem(cacheIdentifier);
    if (array == null) {
        $.get(url, function (data) {
            var array = [];
            $.each(data, function (index, data) {

                if ($("html").attr("lang") == "it" && data.name_it != "") {

                    array.push({value: data.id, text: data.name_it});

                } else {

                    array.push({value: data.id, text: data.name});

                }


            });
            sessionStorage.setItem(cacheIdentifier, JSON.stringify(array));
            appendToSelect(array, select);

        });
    } else {
        array = JSON.parse(array);
        appendToSelect(array, select);
    }
}

function initAutocomplete() {
    $(".autocomplete-source").autocomplete({
        source: "/search/city",
        minLength: 2,
        select: function (event, ui) {
            $("#vacancyAddCity").val(ui.item.id);
            $(".autocomplete-source").val(ui.item.name);

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
    /*$(".autocomplete-source").each(function (){
     var atc = $(this);
     atc.autocomplete({
     source: atc.attr("data-source"),
     minLength: 2,
     select: function (event, ui) {
     var input = atc.attr("data-input");
     $(input).val(ui.item.id);
     atc.val(ui.item.name);

     return false;
     },
     messages: {
     noResults: '',
     results: function () {
     }
     }
     }).autocomplete("instance")._renderItem = function (ul, item) {
     alert("ciao");
     return $("<li>")
     .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
     .appendTo(ul);
     };
     });*/

}
if ($(".search-hr").length) {

    $(".search-hr").autocomplete({
        source: "/hr/suggest/application/" + $("#id_vacancy").val(),
        minLength: 2,
        select: function (event, ui) {

            $(this).parent().find(".address_city_id").val(ui.item.id);
            $(this).val(ui.item.name);

            return false;
        },
        messages: {
            noResults: '',
            results: function () {
            }
        },
        create: function () {
            $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<a><i class=\"fa fa-map-marker\"></i>" + item.name + " - " + item.country.name + "</a>")
                    .appendTo(ul);
            };
        }
    });
}


$("a,button,input,option,label").on("click", function () {
    if ($(this).attr("data-hide") != null && $(this).attr("data-hide").length > 0) {
        $($(this).attr("data-hide")).hide();
    }
    if ($(this).attr("data-show") != null && $(this).attr("data-show").length > 0) {
        $($(this).attr("data-show")).show();
    }
    if ($(this).attr("data-toggle") != null && $(this).attr("data-toggle").length > 0) {
        $($(this).attr("data-toggle")).toggle();
    }
    if ($(this).attr("data-toggleClass") != null && $(this).attr("data-toggleClass").length > 0) {
        $(this).toggleClass($(this).attr("data-toggleClass"));
    }

    if ($(this).attr("data-ajaxClickChangeId") != null && $(this).attr("data-ajaxClickChangeId").length > 0) {
        var updAttr = $(this).attr("data-ajaxObjectDetail");
        var elem = $(this).attr("data-ajaxClickChangeId");
        $("*[data-ajaxAcceptId='" + elem + "']").attr("data-ajaxObjectDetail", updAttr);
        $(document).trigger("data-update");
    }
    /**
     * Text type transformations
     */
    if ($(this).attr("data-evenToggle") != null && $(this).attr("data-evenToggle").length > 0) {
        var toggleText = $(this).attr("data-evenToggle");
        var spanTarget = $("#" + toggleText);
        var originalText = spanTarget.text();
        var sTarget = $("*[data-textToggle='" + toggleText + "']");

        spanTarget.text(sTarget.text());
        sTarget.text(originalText);
    }
});


$(".close-modal-application").click(function (e) {
    e.preventDefault();
    $("#modal-application-event").closeModal({
        complete: function () {
            $("#send-comment-application-event")[0].reset();
            if ($("#detail-application").length) {
                $("#detail-application").remove();
                $("#candidates").removeClass("hide");
            }
            $("#hired-candidates-list").jsGrid().trigger('reloadGrid');
            $("#incoming-candidates-list").jsGrid().trigger('reloadGrid');
            $("#rejected-candidates-list").jsGrid().trigger('reloadGrid');
            $("#accepted-candidates-list").jsGrid().trigger('reloadGrid');
            $("#profile-page").toggleClass("disabled");
        }
    });
});


$(document).on("click", ".active-company", function () {

    var visible = false;
    if ($(".active-company").is(':checked')) {

        visible = true;
    }

    $.ajax({
        url: "/company/" + $(".active-company").attr("id-company"),
        dataType: 'json',
        type: "PATCH",
        data: {is_visible: visible},
        success: function (data, jqXHR) {

        },
        error: function (data, jqXHR) {

        }
    });


});

$(document).on("click",".trumbowyg-editor",function(e){
    $(this).css("cssText","min-height:300px !important;");
});

if ($("#modify-company").length) {
    setInterval(function () {
        var id = $("#modify-company").attr("data-id");
        $("#modify-company .form-content").hide();
        $("#modify-company .form-loader").show();
        var params = $("#modify-company").serialize();

        $.ajax({
            method: "PATCH",
            url: "/company/" + id,
            data: params,
            success: function (data, textStatus, xhr) {

            }
        });
    }, 120000);
}
$("#modify-company").submit(function (e) {
    e.preventDefault();
    $("#modify-company button").prop("disabled", true);

    var id = $(this).attr("data-id");
    $("#modify-company .form-content").hide();
    $("#modify-company .form-loader").show();
    var params = $("#modify-company").serialize();
    var method = "PATCH";
    if (id == "") {
        method = "POST";
    }

    $.ajax({
        method: method,
        url: "/company/" + id,
        data: params,
        success: function (data, textStatus, xhr) {

            if (xhr.status == 204 || xhr.status == 201) {

                var type = "info";
                if ($("#modify-company").attr("data-swal-type")) {
                    type = $("#modify-company").attr("data-swal-type");
                }
                $("#modify-company button").prop("disabled", false);

                if ($("#billing_address").length) {
                    swal({
                            title: $("#modify-company").attr("data-swal-title"),
                            text: $("#modify-company").attr("data-swal-text"),
                            type: type,
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $("#modify-company button").prop("disabled", false);
                            } else {
                                window.location.href = $(".preview-company-page").attr("href");
                            }


                        });
                } else {
                    swal({
                            title: $("#modify-company").attr("data-swal-title"),
                            text: $("#modify-company").attr("data-swal-text"),
                            type: type,
                            showCancelButton: true,
                            cancelButtonText: "Visit Branding Page",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $("#modify-company button").prop("disabled", false);
                            } else {
                                window.location.href = $(".preview-company-page").attr("href");
                            }


                        });
                }


            } else {


            }
            $("#modify-company button").prop("disabled", false);

        }
    });

});


/*
 $("form#new-application-event").validate({
 rules: {
 vacancyAddName: {
 required: true,
 minlength: 4
 },
 vacancyAddDescription: {
 required: true,
 minlength: 4
 },
 vacancyAddJobFunction: "required",
 vacancyAddStudyField: "required",
 vacancyAddLanguages: "required",
 vacancyAddCity: {
 required: true,
 minlength: 3
 },
 vacancyAddDate: "required"
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

 $(form).find(".form-content").hide();
 $(form).find(".form-loader").show();

 var vacancy = $(form).serializeArray();

 $.post("/hr/job/add", vacancy, function (data, status, xhr) {

 $(form).find(".form-loader").hide();
 if (xhr.status == 201 && data.id != null) {
 $(form).find(".form-result").show();
 $("#modal-new-vacancy").find(".color-result").removeClass("red").addClass("green");
 } else {
 $(form).find(".form-result-error").show();
 $("#modal-new-vacancy").find(".color-result").addClass("red");
 }

 }).fail(function () {
 $(form).find(".form-result-error").show();
 $(form).find(".form-loader").hide();
 $("#modal-new-vacancy").find(".color-result").addClass("red");
 });
 }
 }); */