$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$('.alert').slideDown();
setTimeout(function() {
    $('.alert').slideUp();
}, 5000);



