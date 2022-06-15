import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import { tag } from '../components/tooltip'

const timetable_index = document.getElementById('timetable-index')

if (timetable_index) {

    const modal      = document.getElementById('bk-timetable-modal')
    const director   = document.getElementById('is_director').value
    const timetable  = document.getElementById('timetable-calendar')
    const calendar   = new Calendar(timetable, {
        locale: 'ru',
        firstDay: 1,
        editable: false,
        initialView: 'dayGridMonth',
        plugins: [
            interactionPlugin,
            dayGridPlugin,
            timeGridPlugin
        ],

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek',
        },

        buttonText: {
            today:    'Сегодня',
            month:    'Месяц',
            week:     'Неделя',
            day:      'День',
            list:     'Список'
        },

        eventClassNames(arg) {
            let teacher    = arg.event.extendedProps.worker_id
            let subteacher = arg.event.extendedProps.is_replace

            if (teacher != subteacher) return ['bk-timetables--replace']
        },

        eventDidMount(info) {
            const data = {
                title: info.event.title,
                id: info.event.extendedProps.timetable_id,
                group: info.event.extendedProps.group,
                category: info.event.extendedProps.category,
                room: info.event.extendedProps.room,
                teacher: info.event.extendedProps.teacher,
                worker_id: info.event.extendedProps.worker_id,
                bgColor: info.event.extendedProps.bgColor,
            }

            info.el.style.background = data.bgColor
            info.el.style.color      = '#f8fafc'

            if (director) {
                $(info.el).on('click', function (event) {
                    $('[data-field=timetable-id]').val(data.id)
                    $('[data-field=group]').val(data.group)
                    $('[data-field=category]').val(data.category)
                    $('[data-field=room]').val(data.room)
                    $('[data-field=time_lesson]').val(data.title)
                    $('#teacher_id option[value=' + data.worker_id + ']').prop('selected', true)

                    modal.style.display = 'flex'
                })
            }

            $(info.el).tooltip({
                container: 'body',
                html: true,
                title: tag.timetable(data),
                boundary: 'window',
                trigger : 'hover focus',
            })
        },

        events: `${window.location.origin}/data/timetable`,
        displayEventTime: false,
    })

    calendar.render()

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none'
        }
    }

    $('[data-modal=close]').on('click', function (event) {
        modal.style.display = 'none'
    })
}
