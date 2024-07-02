//$.fn.editable.defaults.mode = 'inline';
$(document).ready(function() {
    $('.testEdit').editable({
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params.name = $(this).editable().data('name');
            params._token = $("meta[name='csrf-token']").attr("content");
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });


    $('.requiredfieldEdit').editable({
        validate: function(value) {
            if($.trim(value) == '') return 'This field is required';
        },
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params.name = $(this).editable().data('name');
            params._token = $("meta[name='csrf-token']").attr("content");
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });

    $('.special').editable({
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params.name = $(this).editable().data('name');
            params.website = $(this).editable().data('website');
            params._token = $("meta[name='csrf-token']").attr("content");
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });

    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('textarea')
    //bootstrap WYSIHTML5 - text editor
    //$('.textarea').wysihtml5();
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('.textarea').summernote()
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    })

    $('.datepickertime').datetimepicker({
        autoclose: true,
        format: 'yyyy-mm-dd hh:mm',
        startDate: today,
    })

    $('.datepickerspecial').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        startDate: today,

    })

    $('.datepickerfilter').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    })

    $('.datepickertimespecial').datetimepicker({
        autoclose: true,
        format: 'dd/mm/yyyy hh:ii',
        //startDate: today,
    })

    $('.sidebar li a').filter(function(){
        return this.href === location.href;
    }).parent().addClass('active');
});

$(".deleteRecord").click(function(){

    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse){
                    //console.log(reponse);
                    if(reponse['error'] == 1){
                        alert(reponse['msg']);
                    }else{
                        alert(reponse['success']);
                        var id = reponse['id'];
                        $('#row-'+ id).hide();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
       // return false;
    }


});



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function get_yards(element) {
    var airport = element.value;
    $('#yard_id').find('option').not(':first').remove();
    document.getElementById("yard_id").style.visibility = 'hidden';
    $.ajax({
        url: 'locations/getyards/'+airport,
        type: 'get',
        dataType: 'json',
        success: function(response){
            document.getElementById("yard_id").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].yrd_name;
                    var ter_disable = response['data'][i].yrd_disable;
                    if(ter_disable == 1){
                        var option = "<option disabled=\"disabled\" value='"+id+"'>"+name +"</option>";
                    }else{
                        var option = "<option value='"+id+"'>"+name+"</option>";
                    }

                    $("#yard_id").append(option);
                }

            }
        }
    });
}



    $(".delthisbooking").click(function(){
    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse) {
                    //console.log(reponse);
                    if (reponse['error'] == 1) {
                        alert(reponse['msg']);
                    } else {
                        alert(reponse['success']);
                        var id = reponse['id'];
                        $('#row-' + id).hide();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
        // return false;
    }


});
$(".purgeThis").click(function(){
    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse) {
                    //console.log(reponse);
                    if (reponse['error'] == 1) {
                        alert(reponse['msg']);
                    } else {
                        alert(reponse['success']);
                        var id = reponse['id'];
                        $('#row-' + id).hide();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
        // return false;
    }


});

$(".undelThis").click(function(){
    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse) {
                    //console.log(reponse);
                    if (reponse['error'] == 1) {
                        alert(reponse['msg']);
                    } else {
                        alert(reponse['success']);
                        var id = reponse['id'];
                        //$('#row-' + id).hide();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
        // return false;
    }


});

$(".ResendEmail").click(function(){
    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse) {
                    //console.log(reponse);
                    if (reponse['error'] == 1) {
                        alert(reponse['msg']);
                    } else {
                        //alert(reponse['success']);
                        alert("Sent Successfully...");
                       // var id = reponse['id'];
                        $('#res' + id).show();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
        // return false;
    }


});

$(".ResendEmailPayment").click(function(){
    var response = prompt("Please Enter your password");
    var master_password = '1010';
    if (response == master_password) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
            {
                url: url,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (reponse) {
                    //console.log(reponse);
                    if (reponse['error'] == 1) {
                        alert(reponse['msg']);
                    } else {
                        //alert(reponse['success']);
                        //var id = reponse['id'];
                       // $('#res' + id).show();
                    }

                }
            });
    } else if (response == null) {
        return false;
    } else {
        alert("Password doesn't Match!!! Cannot proceed");
        // return false;
    }


});

$(".printdone").click(function(){

    var id = $(this).data("id");
    var url = $(this).data("url");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax(
        {
            url: url,
            type: 'POST',
            data: {
                "id": id,
                "_token": token,
            },
            success: function (reponse) {
                //console.log(reponse);
                if (reponse['error'] == 1) {
                    alert(reponse['msg']);
                } else {
                    //alert(reponse['success']);
                    //var id = reponse['id'];
                    $('#print' + id).show();
                }

            }
        });
});

$(".modal-ckin-ajax").click(function(){
    $(".showhide").show();
    document.getElementById("ckin_out_error").innerHTML = "";
    document.getElementById("ckin_out_success").innerHTML = "";
    $('#ck_in_out_point').find('option').not(':first').remove();
    var id = $(this).data("id");
    var url = $(this).data("url");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax(
        {
            url: url,
            type: 'GET',
            data: {
                "id": id
                //"_token": token,
            },
            success: function (reponse) {
                console.log(reponse);
                $("#myModalLabel").html(reponse.ref);
                $(".ctype").html(reponse.ctype);
                $("#ckin_ckout_bk_id").val(reponse.id);
                $("#cin_out_table").val(reponse.ciot);
                $("#modal-ckout").modal("show");
                if(reponse.disabled == 1){
                    $(".showhide").hide();
                }
            }
        });
});
$(".modal-ckout-ajax").click(function(){
    $(".showhide").show();
    document.getElementById("ckin_out_error").innerHTML = "";
    document.getElementById("ckin_out_success").innerHTML = "";
    $('#ck_in_out_point').find('option').not(':first').remove();
    var id = $(this).data("id");
    var url = $(this).data("url");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax(
        {
            url: url,
            type: 'GET',
            data: {
                "id": id
                //"_token": token,
            },
            success: function (reponse) {
                console.log(reponse);
                $("#myModalLabel").html(reponse.ref);
                $(".ctype").html(reponse.ctype);
                $("#ckin_ckout_bk_id").val(reponse.id);
                $("#cin_out_table").val(reponse.ciot);
                $("#modal-ckout").modal("show");
                if(reponse.disabled == 1){
                    $(".showhide").hide();
                }
            }
        });
});

function getcotlocs(){
    var bkid =document.getElementById("ckin_ckout_bk_id").value;
    var cin_out_table = document.getElementById("cin_out_table").value;
    var ckin_ckout_route = document.getElementById("ckin_ckout_route").value;
    $('#ck_in_out_point').find('option').not(':first').remove();
    $.ajax({
        url: 'bookings/get_ckin_ckou_terminal/'+bkid +'&'+ cin_out_table,
        type: 'get',
        dataType: 'json',
        success: function(response){
           // alert(response.id)
            //document.getElementById("ck_in_out_point").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].ter_name;
                    var ter_disable = response['data'][i].ter_disable;
                    if(ter_disable == 1){
                        var option = "<option disabled=\"disabled\" value='"+id+"'>"+name+ '(booking closed)' +"</option>";
                    }else{
                        var option = "<option value='"+id+"'>"+name+"</option>";
                    }

                    $("#ck_in_out_point").append(option);
                }
            }
        }
    });

};

$("#docheckout").click(function(){
    var url = $(this).data("url");
    document.getElementById("ckin_out_error").innerHTML = "";
    document.getElementById("ckin_out_success").innerHTML = "";
    //alert(url);
    $.ajax({
        type:'POST',
        url:url,
        data:$('#ckinoutform').serialize(),
        success:function(response){
            //alert(response);
            if(response.success == 1){
                document.getElementById("ckin_out_success").innerHTML = response.success_msg;
            }else{
                document.getElementById("ckin_out_error").innerHTML = response.error_text;
            }

            /*document.getElementById("submit").disabled = true;
            $('#loader').removeClass('loader');
            if (data == "1") {
                document.getElementById("submit-errors").innerHTML = "<span style='color:green;'><strong>" + "Redirecting to Next Step..." + "</strong></spam>";
                window.location.href = "/"+redirect;
            }else{
                document.getElementById("submit-errors").innerHTML = "<span style='color:red;'><strong>" + data + "</strong></spam>";
            }*/
        }
    });
});

function printDiv(divName){
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
/*==================*Manual Booking==================*/
function getairports() {
    var country =document.getElementById("country").value;
    document.getElementById("airport_id").style.visibility = 'hidden';
    //document.getElementById("terminal").style.visibility = 'hidden';
    //document.getElementById("return_terminal").style.visibility = 'hidden';
    //document.getElementById("cur_id").style.display='none';
    $('#airport_id').find('option').not(':first').remove();
    $('#bk_ou_te').find('option').not(':first').remove();
    $('#bk_re_te').find('option').not(':first').remove();
    $.ajax({
        url: 'manualbooking/getairorts/'+country,
        type: 'get',
        dataType: 'json',
        success: function(response){
            document.getElementById("airport_id").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].airport_name;
                    var ter_disable = response['data'][i].airport_disable;
                    //if(ter_disable == 1){
                       // var option = "<option disabled=\"disabled\" value='"+id+"'>"+name+ '(booking closed)' +"</option>";
                   // }else{
                        var option = "<option value='"+id+"'>"+name+"</option>";
                   // }

                    $("#airport_id").append(option);

                }
               /* document.getElementById("displayprice").innerHTML = "&nbsp;";
                document.getElementById("submit-errors").innerHTML = "&nbsp;";
                document.getElementById("submit").disabled=true;
                document.getElementById("terpro").innerHTML = "";
                document.getElementById("airport_id").disabled = false;*/
            }
            //document.getElementById("terminal").style.visibility = 'visible';
        }
    });
}
function getTerminals() {
    var airport =document.getElementById("airport_id").value;
    document.getElementById("bk_ou_te").style.visibility = 'hidden';
    document.getElementById("bk_re_te").style.visibility = 'hidden';
    //document.getElementById("cur_id").style.display='none';
    $('#bk_ou_te').find('option').not(':first').remove();
    $('#bk_re_te').find('option').not(':first').remove();
    $.ajax({
        url: 'manualbooking/getTerminals/'+airport,
        type: 'get',
        dataType: 'json',
        success: function(response){
            document.getElementById("bk_ou_te").style.visibility = 'visible';
            document.getElementById("bk_re_te").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].ter_name;
                    var ter_disable = response['data'][i].ter_disable;
                    //if(ter_disable == 1){
                     //   var option = "<option disabled=\"disabled\" value='"+id+"'>"+name+ '(booking closed)' +"</option>";
                    //}else{
                        var option = "<option value='"+id+"'>"+name+"</option>";
                   //}

                    $("#bk_ou_te").append(option);
                    $("#bk_re_te").append(option);
                }
                /*document.getElementById("displayprice").innerHTML = "&nbsp;";
                document.getElementById("submit-errors").innerHTML = "&nbsp;";
                document.getElementById("submit").disabled=true;
                document.getElementById("terpro").innerHTML = "";
                document.getElementById("terminal").disabled = false;*/
            }
            //document.getElementById("terminal").style.visibility = 'visible';
        }
    });
}
function getcarwashhtml() {

    var vehical_type_id = document.getElementById("vehical_type_id").value;;

    if(vehical_type_id > 0){
        $.ajax({
            type:'GET',
            url:'manualbooking/getcarwashhtml/'+vehical_type_id,
            //data:{vehical_type_id: },
            success:function(response){
                document.getElementById("carwash-radio-options").innerHTML = response;
                //document.getElementById("cart-content").style.visibility = 'visible';
            },
            error:function(response){
                //var error = "Username / Password not found";
                //document.getElementById("loginerror").innerHTML = "<span style='color:red;'><strong>" + error + "</strong></spam>";
            },
        });
    }else{
        document.getElementById("carwash-radio-options").innerHTML = "";
    }
}
function resetForm(){
    var inputs, index, ctrl;
    inputs = document.getElementsByTagName('input');
    for (index = 0; index < inputs.length; ++index) {
        // deal with inputs[index] element.
        inputs[index].style.border = '';
        inputs[index].value = "";
    }
    inputs = document.getElementsByTagName('textarea');
    for (index = 0; index < inputs.length; ++index) {
        // deal with inputs[index] element.
        inputs[index].style.border = '';
        inputs[index].value = "";
    }
    document.getElementById("prog").innerHTML = "";
    document.getElementById("cus_country").value = "United Kingdom";
    document.getElementById("reset").value = "Reset";
    document.getElementById("submit").value = "Submit";
    document.getElementById("bk_ref").focus();

    if (errCtrl.length > 0) {
        // alert(errCtrl);
        strErr = errCtrl.split("|");
        for (i = 0; i < strErr.length; i++) {
            var ctrl = strErr[i].split("~");
            document.getElementById(ctrl[0]).style.border = "";
            document.getElementById(ctrl[0]+"_err").innerHTML = "";
        }
    }
}
$("#mbooking").submit(function(e) {
    e.preventDefault();
    $(".error").remove();
   var cus_name = $('#cus_name').val();
    if (cus_name.length < 1) {
        $('#cus_name').after('<span class="error" style="color: red"> This field is required</span>');
        $('#submit').after('<div class="error" style="color: red"> Required Field Missing. </div>');
    }else {
        $(".error").remove();
        $.ajax({
            type: 'POST',
            url: 'manualbooking',
            data: $('#mbooking').serialize(),
            success: function (res) {
                alert(res.data)
                $('#mbooking')[0].reset();
            }
        });
    }




});
/*==================*Manual Booking==================*/





$(".showdetails").click(function(){

    var url = $(this).data("url");
    $.ajax({
        type:'POST',
        url:url,
        success:function(response){
            $("#classTable").find("tr:gt(0)").remove();
            $('#classTable tr:last').after(response);
            $('#classModal').modal('show');
        }
    });
});
$(".customerdetails").click(function(){

    var url = $(this).data("url");
    $.ajax({
        type:'POST',
        url:url,
        success:function(response){
            //$("#classTable").find("tr:gt(0)").remove();
            $('#CustomerTableRes').html(response);
            $('#classModal').modal('show');
        }
    });
});
$("#changepass").click(function(){
    $('#passdiv').toggle();
    $('#pass').prop('disabled', function (i,v) {
        return !v;
    });
    $('#con_pass').prop('disabled', function (i,v) {
        return !v;
    });
});
$("ul.nav-tabs a").click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});


function getTerminalsPricing() {
    var airport =document.getElementById("airport").value;
    document.getElementById("terminal").style.visibility = 'hidden';
    //document.getElementById("cur_id").style.display='none';
    $('#terminal').find('option').not(':first').remove();
    $.ajax({
        url: 'manualbooking/getTerminals/'+airport,
        type: 'get',
        dataType: 'json',
        success: function(response){
            document.getElementById("terminal").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].ter_name;
                    var ter_disable = response['data'][i].ter_disable;
                    var option = "<option value='"+id+"'>"+name+"</option>";
                    $("#terminal").append(option);
                }
            }

        }
    });
}
function getairportsPricing() {
    var country =document.getElementById("country").value;
    document.getElementById("airport").style.visibility = 'hidden';
    $('#airport').find('option').not(':first').remove();
    $('#terminal').find('option').not(':first').remove();
    $.ajax({
        url: 'manualbooking/getairorts/'+country,
        type: 'get',
        dataType: 'json',
        success: function(response){
            document.getElementById("airport").style.visibility = 'visible';
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].airport_name;
                    var ter_disable = response['data'][i].airport_disable;
                    var option = "<option value='"+id+"'>"+name+"</option>";
                    $("#airport").append(option);

                }
            }
        }
    });
}

function GetTef(){
    if ($('#bk_access_fee').length > 0){
        console.log('HERER');
        document.getElementById("bk_access_fee").value = "";
        
        var service =document.getElementById("service").value;
       
         var country =document.getElementById("country").value;
        var terminal=document.getElementById("bk_ou_te").value;
        var currency1 =document.getElementById("cur_id").value;
        var bookingeditpage =0;
        if(service != "" && terminal != "") {
            
            $.ajax({
                type: 'GET',
                url: '/gettef',
                data: {
                    bookingeditpage: bookingeditpage,
                    service:service,
                    terminal: terminal,
                    cur_id: currency1,
                },
                success: function (res) {
                    console.log(res);
    
                    document.getElementById("bk_access_fee").value = res.tef;
                }
            });
        }
    }
}

function updatePricefinal() {
    var bk_total_amount = $("#bk_total_amount").val();
    var bk_access_fee = $("#bk_access_fee").val();
   bk_total_amount = parseInt(bk_total_amount);
   bk_access_fee = parseInt(bk_access_fee);
    var total = bk_total_amount + bk_access_fee ;
    //console.log(total);
    $("#bk_total_amount_final").val(total);
}