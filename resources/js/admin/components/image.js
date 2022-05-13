$('[data-file=upload]').on('change', function (event) {
    this.previousElementSibling.value = this.value
})
