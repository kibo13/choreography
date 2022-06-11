$(document).on('click', '.bk-btn-info', function (event) {
    $(this).toggleClass('bk-btn-info--active')

    // search child element - icon
    let icon = $(this).children('i')

    // set hide icon
    if ($(icon).hasClass('fa-eye'))
    {
        $(icon).removeClass('fa-eye')
        $(icon).addClass('fa-eye-slash')
    }

    // set show icon
    else
    {
        $(icon).removeClass('fa-eye-slash')
        $(icon).addClass('fa-eye')
    }
})
