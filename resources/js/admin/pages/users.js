const users_form = document.getElementById('users-form')

if (users_form) {

    $('#role').on('change', function (event) {

        let slug = $(this).find(':selected').data('slug')

        $('.bk-form__checkbox').prop('checked', false)

        switch (slug) {
            case 'sa':
                $('.bk-form__checkbox').prop('checked', true)
                $('.help_read').prop('checked', false)
                $('.help_full').prop('checked', false)
                break

            case 'admin':
                $('.bk-form__checkbox').prop('checked', true)
                $('.help_read').prop('checked', false)
                $('.help_full').prop('checked', false)
                $('.pass_full').prop('checked', false)
                $('.event_full').prop('checked', false)
                break

            case 'head':
                $('.pass_read').prop('checked', true)
                $('.pass_full').prop('checked', true)
                $('.group_read').prop('checked', true)
                $('.group_full').prop('checked', true)
                $('.achievement_read').prop('checked', true)
                $('.achievement_full').prop('checked', true)
                $('.app_read').prop('checked', true)
                $('.app_full').prop('checked', true)
                $('.discount_read').prop('checked', true)
                $('.discount_full').prop('checked', true)
                $('.event_read').prop('checked', true)
                $('.event_full').prop('checked', true)
                $('.method_read').prop('checked', true)
                $('.method_full').prop('checked', true)
                $('.award_read').prop('checked', true)
                $('.award_full').prop('checked', true)
                $('.load_read').prop('checked', true)
                $('.load_full').prop('checked', true)
                $('.orgkomitet_read').prop('checked', true)
                $('.orgkomitet_full').prop('checked', true)
                $('.report_read').prop('checked', true)
                $('.visit_read').prop('checked', true)
                $('.visit_full').prop('checked', true)
                $('.timetable_read').prop('checked', true)
                $('.timetable_full').prop('checked', true)
                $('.rep_read').prop('checked', true)
                $('.rep_full').prop('checked', true)
                $('.member_read').prop('checked', true)
                $('.member_full').prop('checked', true)
                $('.stat_read').prop('checked', true)
                break

            case 'manager':
                $('.pass_read').prop('checked', true)
                $('.group_read').prop('checked', true)
                $('.achievement_read').prop('checked', true)
                $('.room_read').prop('checked', true)
                $('.room_full').prop('checked', true)
                $('.event_read').prop('checked', true)
                $('.award_read').prop('checked', true)
                $('.load_read').prop('checked', true)
                $('.orgkomitet_read').prop('checked', true)
                $('.report_read').prop('checked', true)
                $('.visit_read').prop('checked', true)
                $('.visit_full').prop('checked', true)
                $('.timetable_read').prop('checked', true)
                $('.rep_read').prop('checked', true)
                $('.member_read').prop('checked', true)
                $('.stat_read').prop('checked', true)
                break

            case 'client':
                $('.help_read').prop('checked', true)
                $('.help_full').prop('checked', true)
                $('.timetable_read').prop('checked', true)
                $('.pass_read').prop('checked', true)
                break
        }
    })
}
