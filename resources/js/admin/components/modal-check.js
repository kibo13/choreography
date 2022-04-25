$(document).on('click', '.bk-btn-action--check', (event) => {

    let table       = $(event.target).data('table-name')
    let url         = $(location).attr('pathname')
    let record_id   = $(event.target).data('id')

    switch (table) {
        case 'special':
            $('#bk-confirm-form').attr('action', `${url}/destroy/${record_id}`)
            break

        default:
            $('#bk-confirm-form').attr('action', `${url}/${record_id}`)
            break
    }
})
