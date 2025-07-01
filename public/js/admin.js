var base = location.protocol + '//' + location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    var btn_search = document.getElementById('btn_search');
    var form_search = document.getElementById('form_search');
    if (btn_search) {
        btn_search.addEventListener('click', function(e) {
            e.preventDefault();
            if (form_search.style.display === 'block') {
                form_search.style.display = 'none';
            } else {
                form_search.style.display = 'block';
            }
        });
    }

    //Bold Active sections

    route_active = document.getElementsByClassName('lk-' + route)[0].classList.add('active');
    btn_deleted = document.getElementsByClassName('btn_deleted');
    for (i = 0; i < btn_deleted.length; i++) {
        btn_deleted[i].addEventListener('click', delete_object);
    }
    console.log(btn_deleted.length);

});

function delete_object(e) {
    e.preventDefault();
    var object = this.getAttribute('data-object');
    var action = this.getAttribute('data-action');
    var path = this.getAttribute('data-path');
    var url = base + path + '/' + object + '/' + action;
    var title, text, icon;
    if (action == 'delete') {

        title = "¿Estas seguro que quieres eliminar este producto?";
        text = "Recuerda que esta acción eliminara definitivamente el producto.";
        icon = "warning";
    }
    if (action == 'restore') {

        title = "¿Estas seguro que quieres restaurar este producto?";
        text = "Recuerda que esta acción restaurara el producto.";
        icon = "info";
    }
    swal({
            title: title,
            text: text,
            icon: icon,
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {

                window.location.href = url;

            }
        });

}

$(document).ready(function() {
    editor_init('ckeditor');
})


function editor_init(field) {
    CKEDITOR.replace(field, {
        toolbar: [
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'BulletedList', 'Strike', 'Image', 'link', 'UnLink', 'Blockquote'] },
            { name: 'document', items: ['CodeSnippet', 'EmojiPanel', 'PreView', 'Source'] },
        ]
    });
}

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
})
$('.alert').slideDown();
setTimeout(function() {
    $('.alert').slideUp();
}, 5000);

$(document).ready(function() {
    $('form').on('submit', function(e) {
        // Quitar la clase d-none para mostrar la animación de carga
        $('#loading-animation').removeClass('d-none');
    });
});
