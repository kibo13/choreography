const customers_form = document.getElementById('customers-form')

if (customers_form) {

    const upload_btn = document.getElementById('upload-btn')
    const upload_inp = document.getElementById('upload-file')

    upload_btn.onchange = function () {
        upload_inp.value = this.value
    }
}
