$(document).ready(function() {
    //AJAX pour formulaire de création utilisateur
    $(document).on('submit', '#user-create-form', function (event){

        event.preventDefault();

        var form = $('#user-create-form');

        form.children().each((i, e) =>{
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
                if(data['code'] === 200){
                    form[0].reset();
                    $('#user-create-form-result').html('<div class="alert alert-success">L\'utilisateur a été créé</div>').hide();
                    $('#user-create-form-result').fadeIn('slow').delay(5000).fadeOut('slow');
                    $('#refresh-user-list').click();
                }
                //Si le formulaire est invalide
                else if(data['code'] === 400){
                    for(var key in data['errors']){
                        $(form.find('[id*="'+key+'-error"]')[0]).append('<div class="alert alert-danger" role="alert">' + data['errors'][key] + '</div>');
                    }
                    event.stopPropagation();
                }

                $('#submit-form-user').children('i').remove();
            },
            //S'il y a une erreur de traitement
            error: function (data){
                $('#submit-form-user').children('i').remove();
                event.stopPropagation();
            }
        });
    });

    //AJAX pour édition d'utilisateurs
    $(document).on('click', 'button[name*="edit-user"]', function(event){
      
        event.preventDefault();

        var user = $(this).parent().parent().parent().parent();
        var id = user.attr('id').toString().match(/\d+$/)[0];

        window.confirm("sometext");
    });

    //AJAX pour supression d'utilisateurs
    $(document).on('click', 'button[name*="delete-user"]', function (event){

        event.preventDefault();

        var user = $(this).parent().parent().parent().parent();
        var id = user.attr('id').toString().match(/\d+$/)[0];

        $.ajax({
            method: "POST",
            url: deleteUserUrl.replace('userid', id),
            async: false,
            success: function (data) {
                if(data['code'] === 200){
                    user.remove();
                }
                event.stopPropagation();
            },
            error: function (data){
                event.stopPropagation();
            }
        });
    });

    //AJAX rafraichit la liste des utilisateurs
    $(document).on('click', '#refresh-user-list', function (event){

        event.preventDefault();

        var userlist = $('#user-list').children('tbody');
        $('#refresh-user-list').append(' <i class="fas fa-sync-alt fa-spin"></i>');

        $.ajax({
           method: "POST",
           url: refreshUserList,
           async: false,
           success: function (data){
               if(data['code'] === 200){
                   userlist.empty();
                   userlist.append(data['content'])
                   $('#refresh-user-list').children('i').remove();
               }
               event.stopPropagation();
           },
           error: function (data){
               $('#refresh-user-list').children('i').remove();
               event.stopPropagation();
           }
        });
    });
});