const is_validation = document.querySelector('.is-validation')

if (is_validation) {

    // is-string
    $('.is-string').on('input', function () {
        this.value = this.value.replace(/[^а-яё ]/gi, '')
    })

    // is-number
    $('.is-number').on('input', function () {
        this.value = this.value.replace(/\D/g, '')
    })

    // is-float
    $('.is-float').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '')
    })

    // is-count
    $('.is-count').on('input', function () {
        this.value = this.value.replace(/^0|\D/g, '')
    })

    // is-phone
    $('.is-phone').on('input', function () {
        this.value = this.value.replace(/[^0-9 +]/g, '')
    })
}
