! function(c) {
    "use strict";

    function e() {}
    e.prototype.initFlatpickr = function() {
        // c("#basic-datepicker").flatpickr(),
        // c("#datetime-datepicker").flatpickr({
        //     enableTime: !0,
        //     dateFormat: "Y-m-d H:i"
        // }),
        c("#humanfd-datepicker").flatpickr({
            altInput: !0,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d"
        })
        // c("#minmax-datepicker").flatpickr({
        //     minDate: "2020-01",
        //     maxDate: "2020-03"
        // }),
        // c("#disable-datepicker").flatpickr({
        //     onReady: function() {
        //         this.jumpToDate("2025-01")
        //     },
        //     disable: ["2025-01-10", "2025-01-21", "2025-01-30", new Date(2025, 4, 9)],
        //     dateFormat: "Y-m-d"
        // }),
        // c("#multiple-datepicker").flatpickr({
        //     mode: "multiple",
        //     dateFormat: "Y-m-d"
        // }),
        // c("#conjunction-datepicker").flatpickr({
        //     mode: "multiple",
        //     dateFormat: "Y-m-d",
        //     conjunction: " :: "
        // }),
        // c("#range-datepicker").flatpickr({
        //     mode: "range"
        // }),
        // c("#inline-datepicker").flatpickr({
        //     inline: !0
        // }),
        // c("#basic-timepicker").flatpickr({
        //     enableTime: !0,
        //     noCalendar: !0,
        //     dateFormat: "H:i"
        // }),
        // c("#24hours-timepicker").flatpickr({
        //     enableTime: !0,
        //     noCalendar: !0,
        //     dateFormat: "H:i",
        //     time_24hr: !0
        // }),
        // c("#minmax-timepicker").flatpickr({
        //     enableTime: !0,
        //     noCalendar: !0,
        //     dateFormat: "H:i",
        //     minDate: "16:00",
        //     maxDate: "22:30"
        // }),
        // c("#preloading-timepicker").flatpickr({
        //     enableTime: !0,
        //     noCalendar: !0,
        //     dateFormat: "H:i",
        //     defaultDate: "01:45"
        // })
    },
    // c("#colorpicker-default").spectrum(),
    // c("#colorpicker-showalpha").spectrum({
    //     showAlpha: !0
    // }),
    // c("#colorpicker-showpaletteonly").spectrum({
    //     showPaletteOnly: !0,
    //     showPalette: !0,
    //     palette: [
    //         ["#3bafda", "white", "#675aa9", "rgb(255, 128, 0);", "#f672a7"],
    //         ["red", "yellow", "green", "blue", "violet"]
    //     ]
    // }),
    // c("#colorpicker-togglepaletteonly").spectrum({
    //     showPaletteOnly: !0,
    //     togglePaletteOnly: !0,
    //     togglePaletteMoreText: "more",
    //     togglePaletteLessText: "less",
    //     palette: [
    //         ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
    //         ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
    //         ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
    //         ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
    //         ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
    //         ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
    //         ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
    //         ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
    //     ]
    // }),
    // c("#colorpicker-showintial").spectrum({
    //     showInitial: !0
    // }),
    // c("#colorpicker-showinput-intial").spectrum({
    //     showInitial: !0,
    //     showInput: !0
    // }),
    e.prototype.initTouchspin = function() {
        var i = {};
        c('[data-toggle="touchspin"]').each(function(e, t) {
            var a = c.extend({}, i, c(t).data());
            c(t).TouchSpin(a)
        })
    }, e.prototype.init = function() {
        this.initFlatpickr(), this.initTouchspin()
    }, c.Components = new e, c.Components.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.Components.init()
}();
