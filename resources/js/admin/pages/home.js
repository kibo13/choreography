import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import { tag } from '../components/tooltip'
import { compare } from '../custom/comparison'

const home_index = document.getElementById('home-index')

if (home_index) {

    const director = document.getElementById('is_director').value
    const modal    = document.getElementById('bk-event-modal')
    const endField = document.getElementById('field-end')
    const events   = document.getElementById('events')
    const calendar = new Calendar(events, {
        locale: 'ru',
        firstDay: 1,
        editable: false,
        selectable: director ? true : false,
        initialView: 'dayGridMonth',
        plugins: [
            interactionPlugin,
            dayGridPlugin,
            timeGridPlugin,
            listPlugin
        ],

        headerToolbar: {
            left: 'prev,next today',
            right: 'title',
            // right: 'dayGridMonth,timeGridWeek,listWeek',
        },

        buttonText: {
            today:    'Сегодня',
            month:    'Месяц',
            week:     'Неделя',
            day:      'День',
            list:     'Список'
        },

        validRange(today) {
            return {
                start: today
            }
        },

        eventDidMount(info) {
            const data = {
                title: info.event.title,
                event_id: info.event.extendedProps.event_id,
                place: info.event.extendedProps.place,
                description: info.event.extendedProps.description,
            }

            if (director) {
                $(info.el).on('click', function (event) {
                    window.location.href = `${window.location.origin}/events/${data.event_id}/edit`
                })
            }

            $(info.el).tooltip({
                container: 'body',
                html: true,
                title: tag.event(data),
                boundary: 'window',
                trigger : 'hover focus',
            })
        },

        events: `${window.location.origin}/data/events`,

        select(info) {
            let from = moment(info.endStr, 'YYYY-MM-DD')
            let till = moment(info.startStr, 'YYYY-MM-DD')
            let days = moment.duration(from.diff(till)).asDays()

            endField.style.display = days > 1 ? 'block' : 'none'

            $('[data-modal=from]').val(info.startStr)
            $('[data-modal=till]').val(info.endStr)

            modal.style.display = 'flex'
        }
    })

    calendar.render()

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none'
        }
    }

    $('[data-modal=submit]').on('click', function (event) {
        // check: compare dates
        let from = $('[data-modal=from]').val()
        let till = $('[data-modal=till]').val()

        compare.dates(from, till, event)
    })

    $('[data-modal=close]').on('click', function (event) {
        modal.style.display = 'none'
    })
}

