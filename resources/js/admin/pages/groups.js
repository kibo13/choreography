const groups_form = document.getElementById('groups-form')

if (groups_form) {

    $('.btn-outline-success').on('click', function (event) {
        let from = parseInt($('#age_from').val())
        let till = parseInt($('#age_till').val())

        if (from >= till) {
            event.preventDefault()
            alert('Максимальный возраст должен превышать минимальный возраст')
        }
    })
}
