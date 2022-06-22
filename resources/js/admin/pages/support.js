const support_form = document.getElementById('support-form')

if (support_form) {
    const queryString = window.location.search
    const urlParams   = new URLSearchParams(queryString)
    const pass_id     = urlParams.get('pass')

    $('#pass_id').val(pass_id)
}
