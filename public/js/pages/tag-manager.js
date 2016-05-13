var view,
    TagManager = {

        //All settings must go here
        settings: {
            tagsContainer: $("#tag-container"),
            tagsContainerId : "tag-container"
        },


        init: function () {
            view = this.settings;
            this.bindUIActions();
            this.pageSettings();
        },
        pageSettings: function () {
            this.getTags();
        },
        getTags : function () {

            Materialize.toast("Getting tags from API", 4000);
            $.ajax({ // make an AJAX request
                type: "GET",
                url: "/admin/tags/list",
                dataType: 'json',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    Materialize.toast("Initializing Highcharts", 4000);
                    if (xhr.status == 200) {
                            this.initializeTags(data);
                    }
                },
                error: function (data, textStatus, xhr) {
                    console.log(xhr);
                }

            });
        },
        initializeTags : function (tags) {
            var chart = new Highcharts.Chart({

                chart: {
                    renderTo: view.tagsContainerId,
                    animation: true
                },

                title: {
                    text: 'Meritocracy Tags'
                },

                plotOptions: {
                    series: {
                        point: {
                            events: {
                                drag: function (e) {
                                    $('#drag').html(
                                        'Dragging <b>' + this.series.name + '</b> to <b>[' + Highcharts.numberFormat(e.newX, 2) + ', ' + Highcharts.numberFormat(e.newY, 2) + ']</b>');
                                },
                                drop: function () {
                                    $('#drop').html(
                                        'Dropped <b>' + this.series.name + '</b> at <b>[' + Highcharts.numberFormat(this.x, 2) + ', ' + Highcharts.numberFormat(this.y, 2) + ']</b>');
                                }
                            }
                        }
                    }
                },

                tooltip: {
                    yDecimals: 2
                },

                series: [{
                    type: 'bubble',
                    cursor: 'move',
                    draggableX: true,
                    draggableY: true,
                    data: [
                        tags
                    ]
                }]

            });

        },
        bindUIActions: function () {




        }


    };