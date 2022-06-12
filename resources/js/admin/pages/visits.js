const visits_index = document.getElementById('visits-index')

if (visits_index) {

    const modal_visit = document.getElementById('bk-visit-modal')
    const modal_topic = document.getElementById('bk-topic-modal')

    $('[data-type=visit]').on('click', function (event) {

        let action       = this.dataset.action
        let timetable_id = this.dataset.id
        let member_id    = this.dataset.member
        let status       = this.dataset.status
        let reason       = this.dataset.reason

        $('#action_visit').val(action)
        $('#lesson_id').val(timetable_id)
        $('#member_id').val(member_id)
        $('#status option[value=' + status + ']').prop('selected', true)
        $('#reason').val(reason)

        modal_visit.style.display = 'flex'
    })

    $('[data-type=topic]').on('click', function (event) {

        let timetable_id = this.dataset.id
        let method_id    = this.dataset.method
        let note         = this.dataset.note

        $('#timetable_id').val(timetable_id)
        $('#method_id option[value=' + method_id + ']').prop('selected', true)
        $('#note').val(note)

        modal_topic.style.display = 'flex'
    })

    $('[data-modal=close]').on('click', function (event) {
        modal_visit.style.display = 'none'
        modal_topic.style.display = 'none'
    })

    window.onclick = function(event) {
        switch (event.target) {
            case modal_visit:
                modal_visit.style.display = 'none'
                break

            case modal_topic:
                modal_topic.style.display = 'none'
                break
        }
    }
}
