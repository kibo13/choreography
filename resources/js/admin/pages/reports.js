import { compare } from '../custom/comparison'

const reports_index = document.getElementById('reports-index')

if (reports_index) {

    const menu    = document.getElementById('report-menu')
    const reports = document.getElementsByClassName('bk-report')

    $(menu).on('change', function (event) {

        let reportID = event.target.options[menu.selectedIndex].value

        for (let report of reports) {
            reportID == report.dataset.id
                ? report.classList.remove('d-none')
                : report.classList.add('d-none')
        }
    })

    for (let report of reports) {

        $(`#${report.id} button`).on('click', function (event) {

            let from = $(`#${report.id} #report-from`).val()
            let till = $(`#${report.id} #report-till`).val()

            compare.dates(from, till, event)
        })
    }
}
