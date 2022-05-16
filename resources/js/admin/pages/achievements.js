import Chart from 'chart.js/auto'

const achievements_show  = document.getElementById('achievements-show')
const achievements_index = document.getElementById('achievements-index')

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

if (achievements_index) {
    const monthnames = ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек',]
    const context    = document.getElementById('achievements-chart')
    const chartReset = document.querySelector('[data-chart=years]')
    const initTitle  = 'Статистика достижений ГБУ ГДК'
    const initValues = chartReset.dataset.total.replace(/[\[\]']+/g, '').split(',')
    const initLabels = chartReset.dataset.years.replace(/[\[\]']+/g, '').split(',')
    const chart      = new Chart(context, {
        type: 'bar',
        data: {
            labels: initLabels,
            datasets: [{
                label: initTitle,
                data: initValues,
                backgroundColor: '#007bff'
            }]
        }
    })

    $('[data-chart=years]').on('click', function (event) {
        changeChart(initTitle, initValues, initLabels)
    })

    $('[data-chart=year]').on('click', function (event) {
        let title  = `${this.dataset.year} год`
        let months = this.dataset.months.split(',').slice(0,-1)
        let values = months.filter((item, index) => index % 2 != 0)
        changeChart(title, values, monthnames)
    })

    function changeChart(title, values, labels) {
        chart.data.datasets[0].label = title
        chart.data.datasets[0].data  = values
        chart.data.labels            = labels
        chart.update()
    }
}
