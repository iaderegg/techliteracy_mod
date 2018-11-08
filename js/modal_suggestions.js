$('#div_modal').on('click', function(){
  setModalMaxHeight($('#modal_suggestions'));
});

$('#send_suggestion_btn').on('click', function(event) {

    var form_array = $('#suggestions_form').serializeArray();

    var validate_result = validate_form(form_array);

    if(validate_result.status == 'error'){

        new PNotify({
            title: validate_result.title,
            text: validate_result.content,
            addclass: 'custom',
            icon: '',
            nonblock: {
                nonblock: true
            }
        });

    } else {

        $.ajax({
            type: "POST",
            data: {'data': form_array},
            url: "wp-admin/admin-ajax.php?action=td_save_suggestion",
            success: function (msg) {
                if (msg == 10) {
                    new PNotify({
                        title: '',
                        text: 'Muchas gracias por tu comentario.',
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

        $('.modal-backdrop').hide();
        $('#suggestions_modal').hide();

    }
});

function setModalMaxHeight(element) {
  this.$element     = $(element);  
  this.$content     = this.$element.find('.modal-content');
  var borderWidth   = this.$content.outerHeight() - this.$content.innerHeight();
  var dialogMargin  = $(window).width() < 768 ? 20 : 60;
  var contentHeight = $(window).height() - (dialogMargin + borderWidth);
  var headerHeight  = this.$element.find('.modal-header').outerHeight() || 0;
  var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 0;
  var maxHeight     = contentHeight - (headerHeight + footerHeight);

  this.$content.css({
      'overflow': 'hidden'
  });
  
  this.$element
    .find('.modal-body').css({
      'max-height': maxHeight,
      'overflow-y': 'auto'
  });
}

$('.modal').on('show.bs.modal', function() {
  $(this).show();
  setModalMaxHeight(this);
});

$(window).resize(function() {
  if ($('.modal.in').length != 0) {
    setModalMaxHeight($('.modal.in'));
  }
})

function validate_form(form_array) {

    result = new Object();

    if (form_array[2].value == '' && form_array[3].value == '') {
        result.title = 'Advertencia';
        result.content = 'No has escrito tu comentario o sugerencia.';
        result.status = 'error';
        return result;
    } else if (form_array[0].value == '') {
        result.title = 'Advertencia';
        result.content = 'Recuerda escribir tu nombre.';
        result.status = 'error';
        return result;
    } else if (form_array[1].value == '') {
        result.title = 'Advertencia';
        result.content = 'Recuerda escribir tu email.';
        result.status = 'error';
        return result;
    } else if (has_letters(form_array[0].value) != 0){
        result.title = 'Advertencia';
        result.content = 'El campo nombre solo debe contener letras.';
        result.status = 'error';
        return result;
    }else if (is_email(form_array[1].value)){
        result.title = 'Advertencia';
        result.content = 'El campo email debe tener el formato de un correo electrónico (example@miexample.com).';
        result.status = 'error';
        return result;
    }else{
        result.status = 'success';
        return result;
    }
}

// Funciones para la validación de formularios
function has_letters(str) {
    var letters = "abcdefghyjklmnñopqrstuvwxyz";
    str = str.toString().toLowerCase();
    for (i = 0; i < str.length; i++) {
        if (letters.indexOf(str.charAt(i), 0) == -1) {
            return 1;
        }
    }
    return 0;
}

function has_numbers(str) {
    var numbers = "0123456789";
    for (i = 0; i < str.length; i++) {
        if (numbers.indexOf(str.charAt(i), 0) != -1) {
            return 1;
        }
    }
    return 0;
}

function is_email(str) {
    var email_regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if (email_regex.test(str)) {
        return 0;
    }
    else {
        return 1;
    }
}