const loads_index = document.getElementById('loads-index')

if (loads_index) {

    const modal = document.getElementById('bk-load-modal')

    $('[data-load=set]').on('click', function (event) {

        let action      = this.dataset.action
        let group_id    = this.dataset.group
        let day_of_week = this.dataset.dow
        let start       = this.dataset.start
        let duration    = this.dataset.duration

        $('#action').val(action)
        $('#group_id').val(group_id)
        $('#day_of_week').val(day_of_week)
        $('#start').val(start)
        $('#duration').val(duration)

        modal.style.display = 'flex'
    })

    $('[data-modal=close]').on('click', function (event) {
        modal.style.display = 'none'
    })

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none'
        }
    }
}
