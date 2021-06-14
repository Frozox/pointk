$(document).ready(function () {

    var commandeQty = 0;
    var prixTotal = 0;
    var commande = {};

    $(".btn-plus-produit").click(function (){
        var id = $(this).attr("data-id");
        if(!commande[id]){
            commande[id] = 0;
        }
        var qty = $(".quantity-"+id).text();
        var intQty = parseInt(qty);
        var prix = $(this).attr("data-prix");
        commande[id] += 1;
        intQty += 1;
        commandeQty += 1;
        prixTotal += 1*parseFloat(prix);
        $("#prixTotalCtg").text(prixTotal);
        console.log(commande);
        if(commandeQty == 1)
            afficherRecapCommande()
        console.log(commandeQty)
        $(".quantity-"+id).text(intQty);
        if(intQty > 0){
            $('.btn-moins-produit[data-id='+id+']').removeAttr("disabled");
        }
    })
    $(".btn-moins-produit").click(function (){
        var attr = $(this).attr("disabled");
        if (typeof attr == 'undefined' || attr == false) {
            var id = $(this).attr("data-id");
            var qty = $(".quantity-"+id).text();
            var intQty = parseInt(qty);
            var prix = $(this).attr("data-prix");
            if(intQty > 0){
                commande[id] -= 1;
                intQty -= 1;
                commandeQty -= 1;
                prixTotal -= 1*parseFloat(prix);
                console.log(prix);
                $("#prixTotalCtg").text(prixTotal);
                if(commandeQty <= 0){
                    cacherRecapCommande();
                }
                $(".quantity-"+id).text(intQty);
            }
            if(intQty == 0){
                $('.btn-moins-produit[data-id='+id+']').attr("disabled", true);
            }
        }
    })

    $('#annulerCommande').click(function (){
        remiseAZero()
        cacherRecapCommande()
        $('.btn-moins-produit').attr("disabled",true);
    })

    function afficherRecapCommande(){
        $("#recapCommande").css({display : 'flex'})
        $(".container-md").css({'margin-bottom' : '60px'})
    }
    function cacherRecapCommande(){
        $("#recapCommande").css({display : 'none'})
        $(".container-md").css({'margin-bottom' : '0px'})
    }
    function remiseAZero(){
        commandeQty = 0;
        prixTotal = 0;
        $(".qty-selected").text("0");
    }

    $("#validerCommande").click(function (){
        $.ajax({
            method: "POST",
            url: addCommande,
            async: false,
            data : {prix : prixTotal,
                    commande : commande
            },
            success : function (data){
                if (data['code'] === 200) {
                    document.location.reload();
                    cacherRecapCommande();
                    remiseAZero();
                }
            },
            error: function () {
                alert("error")
            }
        });
    });
});