$(document).ready(function () {
    var commandelist = $('#commande-list');

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
                            [0, "desc"]
                        ]
                    });
                }
            }
        });
    }

    loadCommandeList();

    $(document).one('ajaxStop', function () {
        $('#loading').hide("puff").delay(10).queue(function () {
            $('#loading').remove();
            $('.container-fluid').show();
            commandelist.DataTable().columns.adjust().draw();
        });
    });
});