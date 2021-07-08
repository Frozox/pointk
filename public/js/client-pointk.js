$(document).ready(function () {
    var qtTotal = 0;
    var prixTotal = 0;
    var commande = {};

    //Remettre à 0 la commande à chaque rechargement de page
    remiseAZero();

    $(document).on('click', 'button[id*="produit-moins"]', function () {
        var qte = parseInt($(this).parent().children('p').text());
        var id = parseInt($(this).attr('id').toString().match(/[\d]*$/)[0]);

        if (qte <= 1) {
            $(this).attr("disabled", true);
        }
        qte--;
        qtTotal--;
        prixTotal -= parseFloat($(`#produit-prix-${id}`).text());
        $('#prixTotalCtg').text(prixTotal);
        $(this).parent().children('p').text(qte);
        if (qtTotal <= 0) {
            cacherRecapCommande();
        }
    });

    $(document).on('click', 'button[id*="produit-plus"]', function () {
        var qte = parseInt($(this).parent().children('p').text());
        var id = parseInt($(this).attr('id').toString().match(/[\d]*$/)[0]);

        if (qte >= 0) {
            qte++;
            qtTotal++;
            prixTotal += parseFloat($(`#produit-prix-${id}`).text());
            $('#prixTotalCtg').text(prixTotal);
            $(this).parent().children('button[id*="produit-moins"]').removeAttr("disabled");
            $(this).parent().children('p').text(qte);
        }
        if (qtTotal >= 0) {
            afficherRecapCommande();
        }
    });

    $(document).on('click', '#annulerCommande', function () {
        remiseAZero()
        cacherRecapCommande()
    })

    function afficherRecapCommande() {
        $("#recapCommande").css({ display: 'flex' })
        $(".container-md").css({ 'margin-bottom': '60px' })
    }
    function cacherRecapCommande() {
        $("#recapCommande").css({ display: 'none' })
        $(".container-md").css({ 'margin-bottom': '0px' })
    }
    function remiseAZero() {
        qtTotal = 0;
        prixTotal = 0;
        $('p[id*="produit-qte"]').text("0");
        $('button[id*="produit-moins"]').attr("disabled", true);
    }

    function addProduitsModal() {
        var produitsModal = $('#commande-produit-modal');
        var prixModal = $('#commande-prix-modal');
        var produits = $('p[id*="produit-qte-"]');

        console.log(produits);

        for (let i = 0; i < produits.length; i++) {
            var produitQte = parseInt($(produits[i]).text());
            if (produitQte > 0) {
                var id = parseInt($(produits[i]).attr('id').toString().match(/[\d]*$/)[0]);
                var img = $(`#produit-img-${id}`)[0].src;
                commande[id] = produitQte;
                produitsModal.append(`<span><img style="vertical-align: center;" src="${img}" width="20px">(x${produitQte})</span>`);
            }
        }

        prixModal.append(`Prix : ${prixTotal} <img src="images/placeholder/chestnut.png">`);
    }

    function resetProduitsModal() {
        commande = {};
        $('#commande-produit-modal').empty();
        $('#commande-prix-modal').empty();
    }

    $(document).on('click', '#validerCommande', function () {
        $('#confirm-commande-modal').modal('show');
        addProduitsModal();
    });

    $(document).on('hidden.bs.modal', '#confirm-commande-modal', function () {
        resetProduitsModal();
    });

    $(document).on('click', '#commande-produit-confirm', function () {
        var btn = $(this);
        btn.append(' <i class="fas fa-sync-alt fa-spin"></i>');

        $.ajax({
            method: "POST",
            url: addCommande,
            async: false,
            data: {
                commande: commande
            },
            success: function (data) {
                if (data['code'] === 200) {
                    $('#confirm-commande-modal').modal('show')
                    $(".user-solde-number").text(data['solde'])
                    cacherRecapCommande();
                    remiseAZero();
                }
                btn.children('i').remove();
                $('#commande-produit-cancel').click();
            },
            error: function () {
                btn.children('i').remove();
                alert("La commande n'a pas pu aboutir, vérifiez votre connexion ou contactez l'administration")
            }
        });
    });
});