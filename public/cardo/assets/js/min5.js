jQuery(document).ready(function ($) {
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $(".form_datetime").datetimepicker({
        format: "dd/mm/yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: today,
        minuteStep: 5
    });
});