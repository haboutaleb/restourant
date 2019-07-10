$(document).ready(function () {

    $('.page-container').click(function () {
        $('.ui.search .results').text('');
    });
    $('.ui.search input').keypress(function () {
        $('.ui.search .remove').css('color', '#ccc');
    });
    $('.ui.search .remove').click(function () {
        $('.ui.search input').val('');
        $('.ui.search .results').text('');
    });
    

    
});