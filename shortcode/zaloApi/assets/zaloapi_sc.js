import $ from "jquery";


$(function () {
    console.log('zaloapi_sc');
    $('.zalo-btn-get-at').on('click', function (e) {
        e.preventDefault();
        var zalo_popup = window.open($(this).attr('href'), 'popup', 'width=600,height=600');
        // zalo_popup.close()
        
    })

    /*
    $('.form-container').on('submit', function (e) {
        e.preventDefault();
        $(this).submit()
    })*/

})