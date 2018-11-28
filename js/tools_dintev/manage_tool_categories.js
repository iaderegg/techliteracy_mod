$( document ).ready(function(){

    get_tool_categories();

});

function get_tool_categories(){

    $('#div_table_tool_categories').html();
    $('#div_table_tool_categories').html('<table id="tools_categories_table" class="display" style="width:100%"></table>');

    $.ajax({
        type: "POST",
        data: {
            'action': 'td_get_table_tool_categories',
        },
        url: "../wp-admin/admin-ajax.php?action=td_get_table_tool_categories",
        success: function (msg) {
            if (msg) {
                $('#tools_categories_table').DataTable(msg);
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