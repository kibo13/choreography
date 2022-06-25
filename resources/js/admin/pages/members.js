import { calc } from '../custom/calculation'

const members_index = document.getElementById('members-index')
const members_form  = document.getElementById('members-form')

if (members_index) {

    // =========================================== LEGAL MODAL START
    const aModal = document.getElementById('bk-adult-modal')
    const cModal = document.getElementById('bk-child-modal')

    $('[data-modal=legal]').on('click', function (event) {

        // type of modal
        let type_modal = this.dataset.legal

        // groups
        let group_id   = this.dataset.groupId
        let group_name = this.dataset.groupName
        let group_cat  = this.dataset.groupCategory

        // ages
        let age_from = this.dataset.ageFrom
        let age_till = this.dataset.ageTill

        // free places
        let BPLimit = this.dataset.basicPlacesLimit
        let BPExist = this.dataset.basicPlacesExist

        // paid places
        let EPLimit = this.dataset.extraPlacesLimit
        let EPExist = this.dataset.extraPlacesExist

        // total paid places
        let TEPExist = this.dataset.totalExtraPlacesExist

        // form of study
        let study

        // special condition for PRESTO and ADIVAS groups
        if (group_id == 1 || group_id == 2 || group_id == 3 || group_id == 4 || group_id == 5 || group_id == 6)
        {
            if (+BPExist < +BPLimit) { study = 0 }
            else if (+BPExist >= +BPLimit && +EPExist < +EPLimit && +TEPExist < 6) { study = 1 }
            else { return alert('В выбранной группе нет свободных мест') }
        }

        // special condition for other groups
        else
        {
            if (+BPExist < +BPLimit) { study = 0 }
            else if (+BPExist >= +BPLimit && +EPExist < +EPLimit) { study = 1 }
            else { return alert('В выбранной группе нет свободных мест') }
        }

        if (type_modal == 'adult' && +age_till < 18) return alert(`В эту категорию группы можно регистрировать участника \nтолько через родителя / законного представителя`)

        switch (type_modal) {
            case 'child':
                $('#child-legal').val('child')
                $('#child-group-id').val(group_id)
                $('#child-group-name').text(group_name)
                $('#child-group-category').text(group_cat)
                $('#child-age-limit').text(`${age_from}-${age_till} лет`)
                $('#child-age-from').val(age_from)
                $('#child-age-till').val(age_till)
                $('#child-study-name').text(study == 1 ? 'Платная' : 'Бюджетная')
                $('#child-study-id').val(study)
                cModal.style.display = 'flex'
                break

            case 'adult':
                $('#adult-legal').val('adult')
                $('#adult-group-id').val(group_id)
                $('#adult-group-name').text(group_name)
                $('#adult-group-category').text(group_cat)
                $('#adult-age-limit').text(`${age_from}-${age_till} лет`)
                $('#adult-age-from').val(age_from)
                $('#adult-age-till').val(age_till)
                $('#adult-study-name').text(study == 1 ? 'Платная' : 'Бюджетная')
                $('#adult-study-id').val(study)
                aModal.style.display = 'flex'
                break
        }
    })

    $('.bk-modal-header__close').on('click', function (event) {
        let message = `Закрыть форму регистрации участника? \nРанее введенные данные будут потеряны.`
        if (confirm(message)) window.location.href = `${window.location.origin}/members`
    })
    // =========================================== LEGAL MODAL START

    // =========================================== ADULT MODAL START
    const aForm   = document.getElementById('bk-adult-form')
    const aPrev   = document.getElementById('bk-adult-prev')
    const aNext   = document.getElementById('bk-adult-next')
    const aPanels = document.getElementsByClassName('bk-adult-panel')

    let aPanel = 0
    showAPanel(aPanel)

    $(aPrev).on('click', function (event) {
        nextAPrev(-1)
    })
    $(aNext).on('click', function (event) {

        // validation for panel-1
        if (aPanels[0].style.display == 'flex') {
            let adult_first_name = $('[data-valid=adult-first-name]').val()
            let adult_last_name  = $('[data-valid=adult-last-name]').val()
            let adult_birthday   = $('[data-valid=adult-birthday]').val()
            let adult_age_till   = $('#adult-age-till').val()

            if (!adult_last_name) {
                alert('Поле Фамилия обязательно для заполнения')
                return false
            }

            if (!adult_first_name) {
                alert('Поле Имя обязательно для заполнения')
                return false
            }

            if (!adult_birthday) {
                alert('Поле Дата рождения обязательно для заполнения')
                return false
            }

            if (adult_birthday) {
                let fullAge = calc.fullAge(adult_birthday)

                if (+fullAge < 18) {
                    alert('Участник является несовершеннолетним! \nРегистрация возможна только через родителя / законного представителя')
                    return false
                }

                if (+fullAge > +adult_age_till) {
                    alert('Участник не подходит по возрастной категории')
                    return false
                }
            }
        }

        // validation for panel-2
        if (aPanels[1].style.display == 'flex') {
            let adult_doc_id       = $('[data-valid=adult-doc-id]').val()
            let adult_doc_num      = $('[data-valid=adult-doc-num]').val()
            let adult_doc_date     = $('[data-valid=adult-doc-date]').val()
            let adult_doc_file     = $('[data-valid=adult-doc-file]').val()
            let adult_app_file     = $('[data-valid=adult-app-file]').val()
            let adult_consent_file = $('[data-valid=adult-consent-file]').val()

            if (!adult_doc_id) {
                alert('Поле Тип документа обязательно для заполнения')
                return false
            }

            if (!adult_doc_num) {
                alert('Поле Номер документа обязательно для заполнения')
                return false
            }

            if (!adult_doc_date) {
                alert('Поле Дата выдачи документа обязательно для заполнения')
                return false
            }

            if (!adult_doc_file) {
                alert('Необходимо прикрепить скан документа')
                return false
            }

            if (!adult_app_file) {
                alert('Необходимо прикрепить скан заявления на прием участника')
                return false
            }

            if (!adult_consent_file) {
                alert('Необходимо прикрепить соглашение на сбор и обработку персональных данных')
                return false
            }
        }

        // validation for panel-3
        if (aPanels[2].style.display == 'flex') {
            let adult_phone = $('[data-valid=adult-phone]').val()

            if (!adult_phone) {
                alert('Поле Телефон обязательно для заполнения')
                return false
            }
        }

        nextAPrev(1)
    })

    function showAPanel(n) {
        aPanels[n].style.display = 'flex'

        aPrev.style.display = n == 0 ? 'none' : 'flex'
        aNext.innerHTML = n == (aPanels.length - 1) ? 'Сохранить' : 'Далее'
    }
    function nextAPrev(n) {
        aPanels[aPanel].style.display = 'none'
        aPanel += n

        if (aPanel >= aPanels.length) {
            aForm.submit()
            aModal.style.display = 'none'
            return false
        }

        showAPanel(aPanel)
    }
    // =========================================== ADULT MODAL END

    // =========================================== CHILD MODAL START
    const cForm   = document.getElementById('bk-child-form')
    const cPrev   = document.getElementById('bk-child-prev')
    const cNext   = document.getElementById('bk-child-next')
    const cPanels = document.getElementsByClassName('bk-child-panel')

    let cPanel = 0
    showCPanel(cPanel)

    $(cPrev).on('click', function (event) {
        nextCPrev(-1)
    })
    $(cNext).on('click', function (event) {
        // validation for panel-1
        if (cPanels[0].style.display == 'flex') {
            let rep_last_name  = $('[data-valid=rep_last_name]').val()
            let rep_first_name = $('[data-valid=rep_first_name]').val()

            if (!rep_last_name) {
                alert('Поле Фамилия обязательно для заполнения')
                return false
            }

            if (!rep_first_name) {
                alert('Поле Имя обязательно для заполнения')
                return false
            }
        }
        // validation for panel-2
        if (cPanels[1].style.display == 'flex') {
            let rep_doc_id       = $('[data-valid=rep_doc_id]').val()
            let rep_doc_num      = $('[data-valid=rep_doc_num]').val()
            let rep_doc_date     = $('[data-valid=rep_doc_date]').val()
            let rep_doc_file     = $('[data-valid=rep_doc_file]').val()
            let rep_app_file     = $('[data-valid=rep_app_file]').val()
            let rep_consent_file = $('[data-valid=rep_consent_file]').val()

            if (!rep_doc_id) {
                alert('Поле Тип документа обязательно для заполнения')
                return false
            }

            if (!rep_doc_num) {
                alert('Поле Номер документа обязательно для заполнения')
                return false
            }

            if (!rep_doc_date) {
                alert('Поле Дата выдачи документа обязательно для заполнения')
                return false
            }

            if (!rep_doc_file) {
                alert('Необходимо прикрепить скан документа')
                return false
            }

            if (!rep_app_file) {
                alert('Необходимо прикрепить скан заявления на прием участника')
                return false
            }

            if (!rep_consent_file) {
                alert('Необходимо прикрепить соглашение на сбор и обработку персональных данных')
                return false
            }
        }
        // validation for panel-3
        if (cPanels[2].style.display == 'flex') {
            let child_first_name = $('[data-valid=child-first-name]').val()
            let child_last_name  = $('[data-valid=child-last-name]').val()
            let child_birthday   = $('[data-valid=child-birthday]').val()
            let child_age_from   = $('#child-age-from').val()
            let child_age_till   = $('#child-age-till').val()

            if (!child_last_name) {
                alert('Поле Фамилия обязательно для заполнения')
                return false
            }

            if (!child_first_name) {
                alert('Поле Имя обязательно для заполнения')
                return false
            }

            if (!child_birthday) {
                alert('Поле Дата рождения обязательно для заполнения')
                return false
            }

            if (child_birthday) {
                let fullAge = calc.fullAge(child_birthday)

                if (fullAge < child_age_from || fullAge > child_age_till) {
                    alert('Участник не подходит по возрастной категории')
                    return false
                }

                if (+fullAge < 14) {
                    $('#member_doc_id option[value=1]').addClass('d-none')
                    $('#member_doc_id option[value=2]').addClass('d-none')
                }
            }
        }
        // validation for panel-4
        if (cPanels[3].style.display == 'flex') {
            let member_doc_id   = $('[data-valid=member_doc_id]').val()
            let member_doc_num  = $('[data-valid=member_doc_num]').val()
            let member_doc_date = $('[data-valid=member_doc_date]').val()
            let member_doc_file = $('[data-valid=member_doc_file]').val()

            if (!member_doc_id) {
                alert('Поле Тип документа обязательно для заполнения')
                return false
            }

            if (!member_doc_num) {
                alert('Поле Номер документа обязательно для заполнения')
                return false
            }

            if (!member_doc_date) {
                alert('Поле Дата выдачи документа обязательно для заполнения')
                return false
            }

            if (!member_doc_file) {
                alert('Необходимо прикрепить скан документа')
                return false
            }
        }
        // validation for panel-5
        if (cPanels[4].style.display == 'flex') {
            let rep_phone = $('[data-valid=rep_phone]').val()

            if (!rep_phone) {
                alert('Поле Телефон обязательно для заполнения')
                return false
            }
        }
        nextCPrev(1)
    })

    function showCPanel(n) {
        cPanels[n].style.display = 'flex'

        cPrev.style.display = n == 0 ? 'none' : 'flex'
        cNext.innerHTML = n == (cPanels.length - 1) ? 'Сохранить' : 'Далее'
    }
    function nextCPrev(n) {
        cPanels[cPanel].style.display = 'none'
        cPanel += n

        if (cPanel >= cPanels.length) {
            cForm.submit()
            cModal.style.display = 'none'
            return false
        }

        showCPanel(cPanel)
    }
    // =========================================== CHILD MODAL END
}

if (members_form) {

    // auto fill birthday field
    $('#doc_date').on('change', function (event) {
        $('#birthday').val(this.value)
    })

    $('.btn-outline-success').on('click', function (event) {

        // check: age verification
        let from    = $('#group_id').data('from')
        let till    = $('#group_id').data('till')
        let fullAge = calc.age($('#birthday').val())

        if (fullAge < from || fullAge > till) {
            event.preventDefault()
            alert('Участник не подходит по возрастной категории')
        }
    })
}
