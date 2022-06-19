<div class="bk-modal" id="bk-child-modal">
    <div class="bk-modal-wrapper">
        <form id="bk-child-form"
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
                <div class="bk-modal-panel bk-child-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Родитель
                    </p>

                    <!-- legal -->
                    <input type="hidden" id="child-legal" name="legal" value="">

                    <!-- last_name -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.last_name') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-string"
                               type="text"
                               data-valid="rep_last_name"
                               name="rep_last_name"
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
                               data-valid="rep_first_name"
                               name="rep_first_name"
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
                               name="rep_middle_name"
                               value=""
                               autocomplete="off"/>
                    </div>
                </div>
                <!-- panel-2 -->
                <div class="bk-modal-panel bk-child-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Документ родителя
                    </p>

                    <!-- doc_id -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_type') }} {{ @mandatory() }}
                        </label>
                        <select class="form-control" data-valid="rep_doc_id" name="rep_doc_id">
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
                               data-valid="rep_doc_num"
                               name="rep_doc_num"
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
                               data-valid="rep_doc_date"
                               name="rep_doc_date"
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
                               data-valid="rep_app_file"
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
                               data-valid="rep_consent_file"
                               name="consent_file"
                               accept="image/*"/>
                    </div>
                </div>
                <!-- panel-3 -->
                <div class="bk-modal-panel bk-child-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Участник
                    </p>

                    <!-- group -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.group') }}</strong>
                        <span id="child-group-name"></span>
                        <span class="text-lowercase" id="child-group-category"></span>
                        <input type="hidden" id="child-group-id" name="group_id" value="">
                    </div>

                    <!-- age_limit -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.age') }}</strong>
                        <span id="child-age-limit"></span>
                        <input type="hidden" id="child-age-from" value="">
                        <input type="hidden" id="child-age-till" value="">
                    </div>

                    <!-- form_study -->
                    <div class="mb-2 d-flex" style="grid-gap: 5px;">
                        <strong>{{ __('_field.study') }}</strong>
                        <span id="child-study-name"></span>
                        <input type="hidden" id="child-study-id" name="form_study" value="">
                    </div>

                    <!-- last_name -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.last_name') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-string"
                               type="text"
                               data-valid="child-last-name"
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
                               data-valid="child-first-name"
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
                               data-valid="child-birthday"
                               name="birthday"
                               value="">
                    </div>
                </div>
                <!-- panel-4 -->
                <div class="bk-modal-panel bk-child-panel">
                    <!-- subtitle -->
                    <p class="bk-modal-subtitle">
                        Документ участника
                    </p>

                    <!-- doc_id -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_type') }} {{ @mandatory() }}
                        </label>
                        <select class="form-control" id="member_doc_id" data-valid="member_doc_id" name="doc_id">
                            <option value="" disabled selected>{{ __('_select.doc') }}</option>
                            <option value="1">Уд.личности</option>
                            <option value="2">Паспорт РФ</option>
                            <option value="3">Св-во о рождении</option>
                        </select>
                    </div>

                    <!-- doc_num -->
                    <div class="mb-2">
                        <label class="m-0 font-weight-bold" for="">
                            {{ __('_field.doc_num') }} {{ @mandatory() }}
                        </label>
                        <input class="form-control is-number"
                               type="text"
                               data-valid="member_doc_num"
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
                               data-valid="member_doc_date"
                               name="doc_date"
                               value="">
                    </div>
                </div>
                <!-- panel-5 -->
                <div class="bk-modal-panel bk-child-panel">
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
                               data-valid="rep_phone"
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
                        id="bk-child-prev"
                        type="button">
                    {{ __('_action.prev') }}
                </button>
                <button class="btn btn-sm btn-outline-success"
                        id="bk-child-next"
                        type="button">
                    {{ __('_action.next') }}
                </button>
            </div>

        </form>
    </div>
</div>
