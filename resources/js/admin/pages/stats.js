import { compare } from '../custom/comparison'

const stats_index = document.getElementById('stats-index')

if (stats_index) {

    $('#stat-run').on('click', function (event) {
        let from = $('#stat-from').val()
        let till = $('#stat-till').val()

        compare.dates(from, till, event)
    })
}
