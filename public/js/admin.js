$(document).ready(function () {
    var produitlist = $('#produit-list');
    var userlist = $('#user-list');
    var commandelist = $('#commande-list');

    //AJAX pour formulaire de création de produit
    $(document).on('submit', '#produit-create-form', function (event) {

    });

    //AJAX pour formulaire de création utilisateur
    $(document).on('submit', '#user-create-form', function (event) {

        event.preventDefault();

        var form = $('#user-create-form');

        form.children().each((i, e) => {
            $(form.find('[id*="-error"]')).empty();
        });

        $('#submit-form-user').append(' <i class="fas fa-sync-alt fa-spin"></i>');

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

        event.stopPropagation();
    });

    //AJAX pour édition de produit
    $(document).on('click', 'button[name*="edit-produit"]', function () {

    });

    //AJAX pour édition d'utilisateurs
    $(document).on('click', 'button[name*="edit-user"]', function () {
        var user = $(this).parent().parent().parent().parent();
        var id = user.attr('id').toString().match(/\d+$/)[0];

        window.confirm("edit user-"+id);
    });

    //AJAX pour supression de produit
    $(document).on('click', 'button[name*="delete-produit"]', function () {

    });

    //AJAX pour supression d'utilisateurs
    $(document).on('click', 'button[name*="delete-user"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];

        /*$.ajax({
            method: "POST",
            url: deleteUserUrl,
            async: false,
            data: {
                user: id
            },
            success: function (data) {
                if (data['code'] === 200) {
                    loadUserList();
                }
            }
        });*/
        window.confirm("delete user-"+id);
    });

    //AJAX load produit list
    function loadProduitList(){
        $.ajax({
            method: "POST",
            url: findProduitsToList,
            success: function (data) {
                if(data['code'] === 200){
                    produitlist.DataTable().clear();
                    produitlist.DataTable().destroy();
                    produitlist.children('tbody').append(data['content']);
                    produitlist.DataTable({
                        "autoWidth": true,
                        "bLengthChange": false,
                        "bInfo": false
                    });
                }
            }
        });
    }

    //AJAX load user list
    function loadUserList(){
        $.ajax({
            method: "POST",
            url: findUsersToList,
            success: function (data) {
                if(data['code'] === 200){
                    userlist.DataTable().clear();
                    userlist.DataTable().destroy();
                    userlist.children('tbody').append(data['content']);
                    userlist.DataTable({
                        "autoWidth": true,
                        "bLengthChange": false,
                        "bInfo": false,
                        columnDefs: [
                            { targets: 8, orderable: false }
                        ]
                    });
                }
            }
        });
    }

    //AJAX load commande list
    function loadCommandeList(){
        $.ajax({
            method: "POST",
            url: findCommandesToList,
            success: function (data) {
                if(data['code'] === 200){
                    commandelist.DataTable().clear();
                    commandelist.DataTable().destroy();
                    commandelist.children('tbody').append(data['content']);
                    commandelist.DataTable({
                        "autoWidth": true,
                        "bLengthChange": false,
                        "bInfo": false
                    });
                }
            }
        });
    }

    loadProduitList();
    loadUserList();
    loadCommandeList();

    $(document).one('ajaxStop', function (){
        $('#loading').hide("puff").delay(10).queue(function () {
            $('#loading').remove();
            $('.container-fluid').show();
            produitlist.DataTable().columns.adjust().draw();
            userlist.DataTable().columns.adjust().draw();
            commandelist.DataTable().columns.adjust().draw();
            $('#user').removeClass("show active");
            $('#commande').removeClass("show active");
        });
    });
});