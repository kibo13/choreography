import { compare } from '../custom/comparison'

const passes_form = document.getElementById('passes-form')

if (passes_form) {
    $('.btn-outline-success').on('click', function (event) {

        // check: compare dates
        let from = $('#from').val()
        let till = $('#till').val()

        compare.dates(from, till, event)
    })
}
