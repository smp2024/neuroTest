var base = location.protocol + '//' + location.host;
var route = document.title;

document.addEventListener('DOMContentLoaded', function() {
    var title = route;
    // console.log(title);
    $('#'+title+'_nav').addClass('active');
    $('#main_').addClass('h-100');

});


