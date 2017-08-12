/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");


    /* jQueryKnob */
    $(".knob").knob();

    //jvectormap data
    var visitorsData = {
        "US": 398, //USA
        "SA": 400, //Saudi Arabia
        "CA": 1000, //Canada
        "DE": 500, //Germany
        "FR": 760, //France
        "CN": 300, //China
        "AU": 700, //Australia
        "BR": 600, //Brazil
        "IN": 800, //India
        "GB": 320, //Great Britain
        "RU": 3000, //Russia
        "ID": 3000 //indonesia
    };
    //World map by jvectormap
    $('#world-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: "transparent",
        regionStyle: {
            initial: {
                fill: '#e4e4e4',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            }
        },
        series: {
            regions: [{
                values: visitorsData,
                scale: ["#92c1dc", "#ebf4f9"],
                normalizeFunction: 'polynomial'
            }]
        },
        onRegionLabelShow: function (e, el, code) {
            if (typeof visitorsData[code] != "undefined")
                el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
        }
    });

    //Sparkline charts
    var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
    $('#sparkline-1').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });
    myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
    $('#sparkline-2').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });
    myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
    $('#sparkline-3').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });


    /* Morris.js Charts */
    // Sales chart
    var day_data = [
        {"period": "January", "Transaction": 3407},
        {"period": "February", "Transaction": 0},
        {"period": "Marc", "Transaction": 0},
        {"period": "April", "Transaction": 0},
        {"period": "Mei", "Transaction": 5257},
        {"period": "Juny", "Transaction": 4248},
        {"period": "July", "Transaction": 6171},
        {"period": "August", "Transaction": 2171},
        {"period": "September", "Transaction": 5201},
        {"period": "Oktober", "Transaction": 1215},
        {"period": "November", "Transaction": 1215},
        {"period": "December", "Transaction": 1215}
    ];
    Morris.Bar({
        element: 'line-chart',
        data: day_data,
        xkey: 'period',
        ykeys: ['Transaction'],
        labels: ['Transaction'],
        xLabelAngle: 60,
            lineColors: ['#000'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: "#000",
            gridStrokeWidth: 0.4,
            pointSize: 4,
            pointStrokeColors: ["#000"],
            gridLineColor: "#000",
            gridTextFamily: "Open Sans",
            gridTextSize: 10
    });

    //var line = new Morris.Line({
    //    element: 'line-chart',
    //    resize: true,
    //    data: [
    //        {y: '2011 Q1', item1: 2666},
    //        {y: '2011 Q2', item1: 2778},
    //        {y: '2011 Q3', item1: 4912},
    //        {y: '2011 Q4', item1: 3767},
    //        {y: '2012 Q1', item1: 6810},
    //        {y: '2012 Q2', item1: 5670},
    //        {y: '2012 Q3', item1: 4820},
    //        {y: '2012 Q4', item1: 15073},
    //        {y: '2013 Q1', item1: 10687},
    //        {y: '2013 Q2', item1: 8432}
    //    ],
    //    xkey: 'y',
    //    ykeys: ['item1'],
    //    labels: ['Item 1'],
    //    lineColors: ['#efefef'],
    //    lineWidth: 2,
    //    hideHover: 'auto',
    //    gridTextColor: "#fff",
    //    gridStrokeWidth: 0.4,
    //    pointSize: 4,
    //    pointStrokeColors: ["#efefef"],
    //    gridLineColor: "#efefef",
    //    gridTextFamily: "Open Sans",
    //    gridTextSize: 10
    //});

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function (ele) {
            window.console.log("The element has been checked");
            return ele;
        },
        onUncheck: function (ele) {
            window.console.log("The element has been unchecked");
            return ele;
        }
    });

});
