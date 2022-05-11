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
                $('.app_read').prop('checked', true)
                $('.app_full').prop('checked', true)
                $('.group_read').prop('checked', true)
                $('.group_full').prop('checked', true)
                $('.member_read').prop('checked', true)
                $('.member_full').prop('checked', true)
                $('.discount_read').prop('checked', true)
                $('.discount_full').prop('checked', true)
                $('.pass_read').prop('checked', true)
                $('.pass_full').prop('checked', true)
                $('.event_read').prop('checked', true)
                $('.event_full').prop('checked', true)
                break

            case 'manager':
                $('.room_read').prop('checked', true)
                $('.room_full').prop('checked', true)
                break

            case 'client':
                $('.help_read').prop('checked', true)
                $('.help_full').prop('checked', true)
                break
        }
    })
}
