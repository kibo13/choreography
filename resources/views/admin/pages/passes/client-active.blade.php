@if(@diffDays($activePass->till) < 5 || @checkPass($member) >= @getActivePass($member)->lessons)
<ul class="mb-2 alert alert-warning" role="alert">
    @if(@diffDays($activePass->till) < 5)
    <li>
        До окончания срока действия абонемента осталось {{ @diffDays($activePass->till) }} дн.
    </li>
    @endif
    @if(@checkPass($member) >= @getActivePass($member)->lessons)
    <li>
        Абонемент закончился необходимо приобрести новый
    </li>
    @endif
</ul>
@endif

<div class="bk-form">
    <div class="bk-form__wrapper">
        <!-- pass -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.pass') }}
            </label>
            <div class="bk-form__text">
                {{ '№' . $activePass->id }}
            </div>
        </div>

        <!-- group -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.group') }}
            </label>
            <div class="bk-form__text">
                {{ $member->group->title->name }}
                @if($member->group->category_id != 4)
                {{ @tip($member->group->category->name) }}
                @endif
            </div>
        </div>

        <!-- teacher -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.teacher') }}
            </label>
            <div class="bk-form__text">
                {{ @full_fio('worker', $activePass->worker_id) }}
            </div>
        </div>

        <!-- period -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.period_action') }}
            </label>
            <div class="bk-form__text">
                <span>
                    {{ @getDMY($activePass->from) . ' - ' }}
                </span>
                <span class="{{ @diffDays($activePass->till) < 5 ? 'text-danger' : null }}">
                    {{ @getDMY($activePass->till) }}
                </span>
            </div>
        </div>

        <!-- period -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.attendance') }}
            </label>
            <ul class="bk-grid text-center" style="grid-template-columns: repeat(auto-fill, minmax(30px, 1fr));">
                @for($lesson = 1; $lesson <= $activePass->lessons; $lesson++)
                @if(@checkPass($member) >= $lesson)
                <li class="bg-info text-white rounded">
                    {{ $lesson }}
                </li>
                @else
                <li class="text-info border border-info rounded">
                    {{ $lesson }}
                </li>
                @endif
                @endfor
            </ul>
        </div>
    </div>
</div>

