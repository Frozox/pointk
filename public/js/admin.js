$(document).ready(function () {
    var produitlist = $('#produit-list');
    var userlist = $('#user-list');
    var commandelist = $('#commande-list');

    //AJAX pour formulaire de création de produit
    $(document).on('submit', '#produit-create-form', function (event) {

        event.preventDefault();

        var form = $('#produit-create-form');
        var formData = new FormData(this);

        form.children().each((i, e) => {
            $(form.find('[id*="-error"]')).empty();
        });

        $('#submit-form-produit').append(' <i class="fas fa-sync-alt fa-spin"></i>');

        $.ajax({
            method: "POST",
            url: addProduitUrl,
            async: false,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                //Si le formulaire est valide
                if (data['code'] === 200) {
                    form[0].reset();
                    $('#produit-create-form-result').html('<div class="alert alert-success">Le produit a été créé</div>').hide();
                    $('#produit-create-form-result').fadeIn('slow').delay(5000).fadeOut('slow');
                    loadProduitList();
                }
                //Si le formulaire est invalide
                else if (data['code'] === 400) {
                    for (var key in data['errors']) {
                        $(form.find('[id*="' + key + '-error"]')[0]).append('<div class="alert alert-danger" role="alert">' + data['errors'][key] + '</div>');
                    }

                }

                $('#submit-form-produit').children('i').remove();
            },
            //S'il y a une erreur de traitement
            error: function (data) {
                $('#submit-form-produit').children('i').remove();
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

    //Model d'édition de Produit
    $(document).on('click', 'button[name*="edit-produit"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];
        $("#produit-edit-button").val(id);
        $("#produit_edit_nom").val($("#produit-" + id).children()[0].textContent);
        $("#edit_produit_form_prix").val($("#produit-" + id).children()[1].textContent);
        $("#produit_edit_image_src")[0].src = $("#produit-" + id).children()[2].lastElementChild.src;
    });

    //Model d'édition d'utilisateur
    $(document).on('click', 'button[name*="edit-user"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];
        $("#user-edit-button").val(id);

        const roles = {
            "Administrateur": "ROLE_ADMIN",
            "Utilisateur": "ROLE_USER"
        }

        $("#edit_user_form_addsolde").val(0);
        $("#edit_user_form_nom").val($("#user-" + id).children()[0].textContent);

        if ($("#user-" + id).children()[2].textContent.toString().match(/^-$/) == null) {
            $("#edit_user_form_telephone_number").val($("#user-" + id).children()[2].textContent);
        }
        else {
            $("#edit_user_form_telephone_number").val(null);
        }

        $("#edit_user_form_roles").val(roles[$("#user-" + id).children()[3].textContent]);

        if ($("#user-" + id).children()[7].textContent.toString().match(/^-$/) == null) {
            $("#edit_user_form_date_fin_day").val(parseInt($("#user-" + id).children()[7].textContent.toString().match(/^[\d]{2}/)[0]));
            $("#edit_user_form_date_fin_month").val(parseInt($("#user-" + id).children()[7].textContent.toString().match(/-([\d]{2})-/)[1]));
            $("#edit_user_form_date_fin_year").val(parseInt($("#user-" + id).children()[7].textContent.toString().match(/[\d]{4}$/)[0]));
        }
        else {
            $("#edit_user_form_date_fin_day").val(null);
            $("#edit_user_form_date_fin_month").val(null);
            $("#edit_user_form_date_fin_year").val(null);
        }
    });

    //AJAX pour editer un produit
    $(document).on('submit', '#produit-edit-form', function (event) {
        event.preventDefault();

        var id = $('#produit-edit-button').attr('value');
        var formData = new FormData(this);

        formData.append('produit', id);

        $('#produit-edit-button').append(' <i class="fas fa-sync-alt fa-spin"></i>');

        $.ajax({
            method: "POST",
            url: editProduitUrl,
            async: false,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                //Si le formulaire est valide
                if (data['code'] === 200) {
                    loadProduitList();
                    loadCommandeList();
                    $('#produit-edit-cancel').click();
                }

                $('#produit-edit-button').children('i').remove();
            },
            //S'il y a une erreur de traitement
            error: function (data) {
                $('#produit-edit-button').children('i').remove();
            }
        });

        event.stopPropagation();
    });

    //AJAX pour editer un utilisateur
    $(document).on('submit', '#user-edit-form', function (event) {
        event.preventDefault();

        var form = $(this);
        var id = $('#user-edit-button').attr('value');

        $('#user-edit-button').append(' <i class="fas fa-sync-alt fa-spin"></i>');

        $.ajax({
            method: "POST",
            url: editUserUrl,
            async: false,
            data: `${form.serialize()}&user=${id}`,
            success: function (data) {
                //Si le formulaire est valide
                if (data['code'] === 200) {
                    loadUserList();
                    $('#user-edit-cancel').click();
                }

                $('#user-edit-button').children('i').remove();
            },
            //S'il y a une erreur de traitement
            error: function (data) {
                $('#user-edit-button').children('i').remove();
            }
        });

        event.stopPropagation();
    });

    $(document).on('click', '#user-info-replenishment-moins', function () {
        var qte = parseFloat($(this).parent().parent().children('input').val());
        if (!qte) {
            qte = 0;
        }

        if (qte <= 1) {
            $(this).attr("disabled", true);
        }
        qte--;
        $(this).parent().parent().children('input').val(qte);
    });

    $(document).on('click', '#user-info-replenishment-plus', function () {
        var qte = parseFloat($(this).parent().parent().children('input').val());
        if (!qte) {
            qte = 0;
        }

        if (qte >= 0) {
            qte++;
            $('#user-info-replenishment-moins').removeAttr("disabled");
            $(this).parent().parent().children('input').val(qte);
        }
    });

    //Model de supression de Produit
    $(document).on('click', 'button[name*="delete-produit"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];
        $("#produit-delete-button").val(id);
    });

    //Model de supression Utilisateur
    $(document).on('click', 'button[name*="delete-user"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];
        $("#user-delete-button").val(id);
    });

    //Model de supression de Commande
    $(document).on('click', 'button[name*="delete-commande"]', function () {
        var id = $(this).parent().parent().parent().parent().attr('id').toString().match(/\d+$/)[0];
        $("#commande-delete-button").val(id);
    });

    //AJAX pour supression de produit
    $(document).on('click', '#produit-delete-button', function () {
        var id = $(this).attr('value')

        if (id) {

            $('#produit-delete-button').append(' <i class="fas fa-sync-alt fa-spin"></i>');

            $.ajax({
                method: "POST",
                url: deleteProduitUrl,
                async: false,
                data: {
                    produit: id
                },
                success: function (data) {
                    if (data['code'] === 200) {
                        loadProduitList();
                        loadCommandeList();
                        $('#produit-delete-cancel').click();
                    }

                    $('#produit-delete-button').children('i').remove();
                },
                error: function (data) {
                    $('#produit-delete-button').children('i').remove();
                }
            });
        }
    })

    //AJAX pour supression d'utilisateur
    $(document).on('click', '#user-delete-button', function () {
        var id = $(this).attr('value')

        if (id) {

            $('#user-delete-button').append(' <i class="fas fa-sync-alt fa-spin"></i>');

            $.ajax({
                method: "POST",
                url: deleteUserUrl,
                async: false,
                data: {
                    user: id
                },
                success: function (data) {
                    if (data['code'] === 200) {
                        loadUserList();
                        loadCommandeList();
                        $('#user-delete-cancel').click();
                    }

                    $('#user-delete-button').children('i').remove();
                },
                error: function (data) {
                    $('#user-delete-button').children('i').remove();
                }
            });
        }
    })

    //AJAX pour supression de Commande
    $(document).on('click', '#commande-delete-button', function () {
        var id = $(this).attr('value')

        if (id) {

            $('#commande-delete-button').append(' <i class="fas fa-sync-alt fa-spin"></i>');

            $.ajax({
                method: "POST",
                url: deleteCommandeUrl,
                async: false,
                data: {
                    commande: id
                },
                success: function (data) {
                    if (data['code'] === 200) {
                        loadUserList();
                        loadCommandeList();
                        $('#commande-delete-cancel').click();
                    }

                    $('#commande-delete-button').children('i').remove();
                },
                error: function (data) {
                    $('#commande-delete-button').children('i').remove();
                }
            });
        }
    })

    //AJAX load produit list
    function loadProduitList() {
        $.ajax({
            method: "POST",
            url: findProduitsToList,
            success: function (data) {
                if (data['code'] === 200) {
                    produitlist.DataTable().clear();
                    produitlist.DataTable().destroy();
                    produitlist.children('tbody').append(data['content']);
                    produitlist.DataTable({
                        "autoWidth": false,
                        "bLengthChange": false,
                        "bInfo": false,
                        columnDefs: [
                            { targets: 2, orderable: false },
                            { targets: 3, orderable: false, width: "10%" }
                        ]
                    });
                }
            }
        });
    }

    //AJAX load user list
    function loadUserList() {
        $.ajax({
            method: "POST",
            url: findUsersToList,
            success: function (data) {
                if (data['code'] === 200) {
                    userlist.DataTable().clear();
                    userlist.DataTable().destroy();
                    userlist.children('tbody').append(data['content']);
                    userlist.DataTable({
                        "autoWidth": false,
                        "bLengthChange": false,
                        "bInfo": false,
                        columnDefs: [
                            { targets: 8, orderable: false, width: "10%" }
                        ]
                    });
                }
            }
        });
    }

    //AJAX load commande list
    function loadCommandeList() {
        $.ajax({
            method: "POST",
            url: findCommandesToList,
            success: function (data) {
                if (data['code'] === 200) {
                    commandelist.DataTable().clear();
                    commandelist.DataTable().destroy();
                    commandelist.children('tbody').append(data['content']);
                    commandelist.DataTable({
                        "autoWidth": false,
                        "bLengthChange": false,
                        "bInfo": false,
                        "order": [
                            [1, "desc"]
                        ],
                        columnDefs: [
                            { targets: 4, orderable: false, width: "10%" }
                        ]
                    });
                }
            }
        });
    }

    loadProduitList();
    loadUserList();
    loadCommandeList();

    $(document).one('ajaxStop', function () {
        $('#loading').hide("puff").delay(10).queue(function () {
            $('#loading').remove();
            $('.container-fluid').show();
        });
    });
});