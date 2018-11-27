$( document ).ready(function(){

    filter_status_suggestions_site('all_suggestions');

    $('.select_status_suggestion').on('change', function(){
        status = this.value;
        id_comment = $(this).attr('id');

        update_status_suggestion(id_comment, status)
    });

    $('#select_filter_status').on('change', function(){
        filter = $(this).val();
        filter_status_suggestions_site(filter);
    });
})

function filter_status_suggestions_site(filter) {

    $('#div_table_suggestions').html();
    $('#div_table_suggestions').html('<table id="suggestions_tools_table" class="display" style="width:100%"></table>');

    $.ajax({
        type: "POST",
        data: {
            'action': 'td_filter_status_suggestions_site',
            'filter': filter,
        },
        url: "../wp-admin/admin-ajax.php?action=td_filter_status_suggestions_site",
        success: function (msg) {
            if (msg) {
                $('#suggestions_tools_table').DataTable(msg);
            }else{
                new PNotify({
                    title: 'Error',
                    text: 'Ha ocurrido un error al filtrar la tabla de comentarios.',
                    addclass: 'custom',
                    icon: '',
                    nonblock: {
                        nonblock: true
                    }
                });
            }

            $('.select_status_suggestion').on('change', function(){
                status = this.value;
                id_comment = $(this).attr('id');

                update_status_suggestion(id_comment, status)
            });
        },
        dataType: "json",
        cache: "false",
        error: function (msg) {
            console.log(msg);
        },
    });
}

function update_status_suggestion(id_suggestion, status){

    $.ajax({
        type: "POST",
        data: {
            'id_suggestion': id_suggestion,
            'status': status
        },
        url: "../wp-admin/admin-ajax.php?action=td_update_status_suggestion",
        success: function (msg) {
            console.log(msg);
            if (msg == 1) {
                new PNotify({
                    title: 'Éxito',
                    text: 'Se ha actualizado el estado de la sugerencia',
                    addclass: 'custom',
                    icon: '',
                    nonblock: {
                        nonblock: true
                    }
                });
            }else{
                new PNotify({
                    title: 'Error',
                    text: 'Ha ocurrido un error al intentar actualizar el estado de la sugerencia',
                    addclass: 'custom',
                    icon: '',
                    nonblock: {
                        nonblock: true
                    }
                });
            }
        },
        dataType: "text",
        cache: "false",
        error: function (msg) {
            console.log(msg);
        },
    });
}




