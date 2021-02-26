$(document).ready(function() {
    //AJAX pour formulaire de création utilisateur
    $('#user-create-form').on('submit', function (event){

        event.preventDefault();

        var form = $('#user-create-form');

        form.children().each((i, e) =>{
            $(form.find('[id*="-error"]')).empty();
        });

        $.ajax({
            method: "POST",
            url: addUserUrl,
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
            },
            //S'il y a une erreur de traitement
            error: function (data){
                event.stopPropagation();
            }
        });
    });

    //AJAX pour supression et edition d'utilisateurs
    $('#user-list tbody').children('tr').children('td').children('ul').children('li').children('button[name*="delete"]').on('click', function (event){

        event.preventDefault();

        var user = $(this).parent().parent().parent().parent();
        var id = user.attr('id').toString().match(/\d+$/)[0];

        $.ajax({
            method: "POST",
            url: deleteUserUrl.replace('userid', id),
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
    $('#refresh-user-list').on('click', function (event){

        event.preventDefault();

        var userlist = $('#user-list').children('tbody');

        $.ajax({
           method: "POST",
           url: refreshUserList,
           success: function (data){
               if(data['code'] === 200){
                   userlist.empty();
                   userlist.append(data['content'])
               }
               event.stopPropagation();
           },
           error: function (data){
               event.stopPropagation();
           }
        });
    });
});