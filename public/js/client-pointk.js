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
    /*
    $.ajax({
        method: "POST",
        url: addUserUrl,
        async: false,
        data: form.serialize(),
        success: function (data) {
            //Si le formulaire est valide
            if (data['code'] === 200) {
                form[0].reset();
                $('#user-create-form-result').html('<div class="alert alert-success">L\'utilisateur a été créé</div>').hide();
                $('#user-create-form-result').fadeIn('slow').delay(5000).fadeOut('slow');
                loadUserList();
            }
            //Si le formulaire est invalide
            else if (data['code'] === 400) {
                for (var key in data['errors']) {
                    $(form.find('[id*="' + key + '-error"]')[0]).append('<div class="alert alert-danger" role="alert">' + data['errors'][key] + '</div>');
                }

            }

            $('#submit-form-user').children('i').remove();
        },
        //S'il y a une erreur de traitement
        error: function (data) {
            $('#submit-form-user').children('i').remove();
        }
    });

     */
});