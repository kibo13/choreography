const achievements_show = document.getElementById('achievements-show')

if (achievements_show) {

    // action: store record
    $('[data-file=store]').on('change', function (event) {
        this.parentNode.submit()
    })

    // action: destroy record
    $('[data-file=destroy]').on('click', function (event) {

        let url         = window.location.origin
        let record_id   = $(event.target).data('id')

        $('#bk-delete-form').attr('action', `${url}/diploms/${record_id}`)
    })
}
