$(document).on('click', '.bk-btn-action--delete', (e) => {

    let table       = $(e.target).data('table-name')
    let url         = $(location).attr('pathname')
    let record_id   = $(e.target).data('id')

    switch (table) {
        case 'special':
            $('#bk-delete-form').attr('action', `${url}/destroy/${record_id}`)
            break

        default:
            $('#bk-delete-form').attr('action', `${url}/${record_id}`)
            break
    }
})
