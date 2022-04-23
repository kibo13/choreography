$('.bk-btn-info').on('click', function (event) {
    $(this).toggleClass('bk-btn-info--active')

    // search child element - button
    let button = $(this).children('button')

    // set up icon
    if ($(button).hasClass('bk-btn-info--down'))
    {
        $(button).removeClass('bk-btn-info--down')
        $(button).addClass('bk-btn-info--up')
    }

    // set down icon
    else
    {
        $(button).removeClass('bk-btn-info--up')
        $(button).addClass('bk-btn-info--down')
    }
})
