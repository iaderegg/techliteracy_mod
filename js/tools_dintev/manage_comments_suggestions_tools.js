$( document ).ready(function(){
    $('#comments_tools_table').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });

    $('.select_status_comment_tool').on('change', function(){
        status = this.value;
        id_comment = $(this).attr('id');

        update_status_comment_by_tool(id_comment, status)
    });

    $('#select_filter_status').on('change', function(){
        filter = $(this).val();
        filter_status_comments_by_tool(filter);
    });
})

function update_status_comment_by_tool(id_comment, status){

    $.ajax({
        type: "POST",
        data: {
            'id_comment': id_comment,
            'status': status
        },
        url: "../wp-admin/admin-ajax.php?action=td_update_status_comment_by_tool",
        success: function (msg) {
            if (msg == 10) {
                new PNotify({
                    title: 'Éxito',
                    text: 'Se ha actualizado el estado del comentario',
                    addclass: 'custom',
                    icon: '',
                    nonblock: {
                        nonblock: true
                    }
                });
            }else{
                new PNotify({
                    title: 'Error',
                    text: 'Ha ocurrido un error al intentar actualizar el estado del comentario',
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

function filter_status_comments_by_tool(filter){

    $('#div_table_comments').html();
    $('#div_table_comments').html('<table id="comments_tools_table" class="display" style="width:100%"></table>');

    $.ajax({
        type: "POST",
        data: {
            'action': 'td_filter_status_comment_by_tool',
            'filter': filter,
        },
        url: "../wp-admin/admin-ajax.php?action=td_filter_status_comment_by_tool",
        success: function (msg) {
            if (msg) {
                $('#comments_tools_table').DataTable(msg);
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

            $('.select_status_comment_tool').on('change', function(){
                status = this.value;
                id_comment = $(this).attr('id');

                update_status_comment_by_tool(id_comment, status)
            });
        },
        dataType: "json",
        cache: "false",
        error: function (msg) {
            console.log(msg);
        },
    });
}

