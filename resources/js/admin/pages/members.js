import { calc } from '../custom/calculation'

const members_form = document.getElementById('members-form')

if (members_form) {
    $('.btn-outline-success').on('click', function (event) {

        // check: age verification
        let from    = $('#group_id').data('from')
        let till    = $('#group_id').data('till')
        let fullAge = calc.age($('#birthday').val())

        if (fullAge > from && fullAge < till) {
            event.preventDefault()
            alert('Участник не подходит по возрастной категории')
        }
    })
}
