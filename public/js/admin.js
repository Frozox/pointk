$(document).ready(function () {
    var produit_search_timedout = null;
    var user_search_timedout = null;
    var commandes_search_timedout = null;
    var page_produit = 1;
    var page_user = 1;
    var page_user_timeout = null;
    var page_commande = 1;

    //AJAX pour formulaire de création de produit
    $(document).on('submit', '#produit-create-form', function (event) {
        event.preventDefault();

        var form = $('#produit-create-form');

        form.children().each((i, e) => {
            $(form.find('[id*="-error"]')).empty();
        });
        console.log(form.serialize());
        $.ajax({
            method: "POST",
            url: addProduitUrl,
            async: false,
            data: form.serialize(),
            success: function (data) {
                //Si le formulaire est valide
                if (data['code'] === 200) {
                    form[0].reset();
                    $('#produit-create-form-result').html('<div class="alert alert-success">Le produit a été ajouté</div>').hide();
                    $('#produit-create-form-result').fadeIn('slow').delay(5000).fadeOut('slow');
                    loadProduitList();
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

    }

    //AJAX load user list
    function loadUserList(){
        var userlist = $('#user-list').children('tbody');

        $.ajax({
            method: "POST",
            url: findUsersToList,
            success: function (data) {
                if(data['code'] === 200){
                    userlist.parent().DataTable().clear();
                    userlist.parent().DataTable().destroy();
                    userlist.append(data['content']);
                    userlist.parent().DataTable({
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

    }

    //AJAX pour afficher des produits selon les informations entrées dans la barre de recherche
    /*$("#produit-list-search").on("keyup", function () {

    });*/

    //AJAX pour afficher des utilisateurs selon les informations entrées dans la barre de recherche
    /*$("#user-list-search").on("keyup", function () {
        clearTimeout(user_search_timedout);

        user_search_timedout = setTimeout(() => {
            var search = $(this).val().toLowerCase();
            var userlist = $('#user-list').children('tbody');
            var paginate = $('#paginate-user');

            $.ajax({
                method: "POST",
                url: findUsersToList,
                data: {
                    search: search,
                    page: page_user,
                    sortby: '',
                    orderby: 'ASC'
                },
                success: function (data) {
                    if (data['code'] === 200) {
                        userlist.empty();
                        paginate.empty();
                        userlist.append(data['content']);
                        paginate.append(data['paginate']);
                    }
                }
            });
        }, 750);
    });*/

    //AJAX pour afficher des produits selon les informations entrées dans la barre de recherche
    /*$("#commande-list-search").on("keyup", function () {

    });*/

    //Changement de page avec la pagination
    /*$(document).on('click', '#paginate-user ul li button', function (){
        clearTimeout(page_user_timeout)

        user_search_timedout = setTimeout(() => {
            var value = $(this).attr('value')
            var temp = page_user;

            if (value === 'previous' && page_user > 1) {
                page_user--;
            } else if (value === 'after') {
                page_user++;
            } else {
                page_user = value;
            }

            if (value !== temp) {
                $('#user-list-search').trigger('keyup');
            }
        },750);
    });*/

    loadProduitList();
    loadUserList();
    loadCommandeList();
    $(document).one('ajaxStop', function (){
        $('#loading').hide("puff").delay(10).queue(function () {
            $('#loading').remove();
            $('.container-fluid').show();
        });
    });
});