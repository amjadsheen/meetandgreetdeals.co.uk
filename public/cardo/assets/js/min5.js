jQuery(document).ready(function ($) {
    // var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    // $(".form_datetime").datetimepicker({
    //     format: "dd/mm/yyyy - hh:ii",
    //     autoclose: true,
    //     todayBtn: true,
    //     startDate: today,
    //     minuteStep: 5
    // });
    $('.form_datetime').pickadate({
        format: 'dd/mm/yyyy',
        min: new Date() // today's date
      });

});