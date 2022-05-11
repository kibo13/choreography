import { compare } from '../custom/comparison'

const events_form = document.getElementById('events-form')

if (events_form) {
    $('.btn-outline-success').on('click', function (event) {

        // check: compare dates
        let from = $('#from').val()
        let till = $('#till').val()

        compare.dates(from, till, event)
    })
}
