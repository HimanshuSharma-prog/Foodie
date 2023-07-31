$("body").delegate(".qtyBtn","keyup",function(){
    var pid = $(this).attr("update_id");
    var qty = $("#qty-"+pid).val();
    var f_id=$(this).attr("f_id");
    console.log(pid);
    // var price = $("#price-"+pid).val();
    // var total = qty * price;
    // $(".amt-"+pid).val(total);
    // console.log(total);

    // var totalamt=$(".amt-"+pid).val();
    // var qty1=$("#qty-"+pid).val();

    $.ajax({
        url: 'usercart.php',
        method: 'POST',
        data: {update_id:pid, qty:qty},
        success: function(data){
            console.log(qty,'update',pid);
        }
    })
    setTimeout(function(){
        window.location.replace("item.php?f_id="+f_id+"&success=<div class='notification' id='notificationDiv'><div class='success'><p>cart updated successfully..</p></div> </div>");
    },2000);
})
// $("body").delegate(".qtyBtn","keyup",function(){
//     var pid = $(this).attr("update_id");
//     var qty = $("#qty-"+pid).val();

//     $.post("updatecart.php",
//         {
//             update_id:pid,
//             qty:qty
//         },
//         function(){
//             console.log(pid,qty,'sended');
//         }

//     )

// })