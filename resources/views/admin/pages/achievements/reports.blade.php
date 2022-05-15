<div class="my-2 bk-callout">
    <h5 class="m-0">
        Участие клубных формирований ГБУ ГДК в мероприятиях по годам
    </h5>
</div>

<div class="bk-form">
    <div class="bk-form__wrapper">
        @foreach(@periods() as $period)
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ $period->year . ' год' }}
            </label>
            <div class="bk-form__text">
                <a class="text-primary" href="{{ route('admin.achievements.report', $period->year) }}">
                    {{ __('_action.print') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

