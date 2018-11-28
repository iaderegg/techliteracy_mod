$( document ).ready(function(){

    get_tools();

});

function get_tools(){

    $('#div_table_tools').html();
    $('#div_table_tools').html('<table id="tools_table" class="display" style="width:100%"></table>');

    $.ajax({
        type: "POST",
        data: {
            'action': 'td_get_table_tools',
        },
        url: "../wp-admin/admin-ajax.php?action=td_get_table_tools",
        success: function (msg) {
            if (msg) {
                $('#tools_table').DataTable(msg);
            }else{
                new PNotify({
                    title: 'Error',
                    text: 'Ha ocurrido un error al retornar las categorias.',
                    addclass: 'custom',
                    icon: '',
                    nonblock: {
                        nonblock: true
                    }
                });
            }
        },
        dataType: "json",
        cache: "false",
        error: function (msg) {
            console.log(msg);
        },
    });

}