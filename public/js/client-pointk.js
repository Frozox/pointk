$(document).ready(function () {
    $(".btn-plus-produit").click(function (){
        var id = $(this).attr("data-id");
        var qty = $(".quantity-"+id).text();
        var intQty = parseInt(qty);
        intQty += 1;
        $(".quantity-"+id).text(intQty);
        if(intQty > 0){
            $('.btn-moins-produit[data-id='+id+']').removeAttr("disabled");
        }
    })
    $(".btn-moins-produit").click(function (){
        var attr = $(this).attr("diasbled");
        if (typeof attr == 'undefined' || attr == false) {
            var id = $(this).attr("data-id");
            var qty = $(".quantity-"+id).text();
            var intQty = parseInt(qty);
            if(intQty > 0){
                intQty -= 1;
                $(".quantity-"+id).text(intQty);
            }
            if(intQty == 0){
                $('.btn-moins-produit[data-id='+id+']').attr("disabled", true);
            }
        }
    })
});