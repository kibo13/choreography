const users_form = document.getElementById('users-form')

if (users_form) {

    $('#role').on('change', function (event) {

        let slug = $(this).find(':selected').data('slug')

        $('.bk-form__checkbox').prop('checked', false)

        switch (slug) {
            case 'admin':
                $('.bk-form__checkbox').prop('checked', true)
                break

            case 'head':
                $('.home').prop('checked', true)
                $('.profile').prop('checked', true)
                $('.member_read').prop('checked', true)
                $('.member_full').prop('checked', true)
                $('.app_read').prop('checked', true)
                $('.app_full').prop('checked', true)
                $('.group_read').prop('checked', true)
                $('.discount_read').prop('checked', true)
                $('.discount_full').prop('checked', true)
                break

            case 'manager':
                $('.home').prop('checked', true)
                $('.profile').prop('checked', true)
                $('.room_read').prop('checked', true)
                $('.room_full').prop('checked', true)
                break

            case 'client':
                $('.home').prop('checked', true)
                $('.profile').prop('checked', true)
                $('.help_read').prop('checked', true)
                $('.help_full').prop('checked', true)
                break
        }
    })
}
