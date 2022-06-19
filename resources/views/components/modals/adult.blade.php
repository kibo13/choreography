<div class="bk-modal" id="bk-adult-modal">
    <div class="bk-modal-wrapper">
        <form id="bk-adult-form"
              action="{{ route('admin.members.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <h6 class="bk-modal-header">
                Регистрация участника
                <button class="bk-modal-header__close text-muted" type="button">
                    {{ @fa('fa-times') }}
                </button>
            </h6>

            <div class="py-2 bk-modal-content is-validation">

                <!-- panel-1 -->
                <div class="bk-modal-panel bk-adult-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Участник
                    </p>

                    <!-- legal -->
                    <input type="hidden" id="adult-legal" name="legal" value="">

                    <!-- group -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.group') }}</strong>
                        <span id="adult-group-name"></span>
                        <span class="text-lowercase" id="adult-group-category"></span>
                        <input type="hidden" id="adult-group-id" name="group_id" value="">
                    </div>

                    <!-- age_limit -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.age') }}</strong>
                        <span id="adult-age-limit"></span>
                        <input type="hidden" id="adult-age-from" value="">
                        <input type="hidden" id="adult-age-till" value="">
                    </div>

                    <!-- form_study -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.study') }}</strong>
                        <span id="adult-study-name"></span>
                        <input type="hidden" id="adult-study-id" name="form_study" value="">
                    </div>

                    <!-- last_name -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.last_name') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-string"
                               type="text"
                               data-valid="adult-last-name"
                               name="member_last_name"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- first_name -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.first_name') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-string"
                               type="text"
                               data-valid="adult-first-name"
                               name="member_first_name"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- middle_name -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.middle_name') }}
                        </label>
                        <input class="form-control is-string"
                               type="text"
                               name="member_middle_name"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- birthday -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.birthday') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control"
                               type="date"
                               data-valid="adult-birthday"
                               name="birthday"
                               value="">
                    </div>
                </div>

                <!-- panel-2 -->
                <div class="bk-modal-panel bk-adult-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Документ участника
                    </p>

                    <!-- doc_id -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_type') }} {{ @mandatory() }}
                        </label>
                        <select class="form-control" id="adult-doc-id" data-valid="adult-doc-id" name="doc_id">
                            <option value="" disabled selected>{{ __('_select.doc') }}</option>
                            <option value="1">Уд.личности</option>
                            <option value="2">Паспорт РФ</option>
                        </select>
                    </div>

                    <!-- doc_num -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_num') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-number"
                               type="text"
                               data-valid="adult-doc-num"
                               name="doc_num"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- doc_date -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_date') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control"
                               type="date"
                               data-valid="adult-doc-date"
                               name="doc_date"
                               value="">
                    </div>

                    <!-- app -->
                    <div class="mb-2 position-relative">
                        <label class="m-0 font-weight-bold" for="">
                            Заявление
                        </label>
                        <input class="form-control"
                               type="text"
                               value=""
                               placeholder="{{ __('_field.file_not') }}"
                               disabled/>
                        <input class="bk-form__file"
                               type="file"
                               data-file="upload"
                               data-valid="adult-app-file"
                               name="app_file"
                               accept="image/*"/>
                    </div>

                    <!-- consent -->
                    <div class="mb-2 position-relative">
                        <label class="m-0 font-weight-bold" for="">
                            <span title="Соглашение на сбор и обработку персональных данных">
                                Соглашение {{ @fa('fa-info-circle') }}
                            </span>
                        </label>
                        <input class="form-control"
                               type="text"
                               value=""
                               placeholder="{{ __('_field.file_not') }}"
                               disabled/>
                        <input class="bk-form__file"
                               type="file"
                               data-file="upload"
                               data-valid="adult-consent-file"
                               name="consent_file"
                               accept="image/*"/>
                    </div>
                </div>

                <!-- panel-3 -->
                <div class="bk-modal-panel bk-adult-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Дополнительные сведения
                    </p>

                    <!-- phone -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.phone') }} {{ @mandatory() }} {{ @tip('+7 776 123 45 67') }}
                        </label>
                        <input class="form-control is-phone"
                               type="tel"
                               data-valid="adult-phone"
                               name="phone"
                               pattern="[+]7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"
                               maxlength="16"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- email -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.email') }}
                        </label>
                        <input class="form-control"
                               type="email"
                               name="email"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- address -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.address') }}
                        </label>
                        <input class="form-control"
                               type="text"
                               name="address_fact"
                               value=""
                               autocomplete="off"/>
                    </div>

                    <!-- note -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.note') }}
                        </label>
                        <input class="form-control"
                               type="text"
                               name="activity"
                               value=""/>
                    </div>
                </div>

            </div>

            <div class="px-2 bk-modal-footer justify-content-end">
                <button class="btn btn-sm btn-outline-secondary"
                        id="bk-adult-prev"
                        type="button">
                    {{ __('_action.prev') }}
                </button>
                <button class="btn btn-sm btn-outline-success"
                        id="bk-adult-next"
                        type="button">
                    {{ __('_action.next') }}
                </button>
            </div>

        </form>
    </div>
</div>
