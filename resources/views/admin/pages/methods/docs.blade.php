<div class="my-2 bk-callout">
    <h5 class="m-0">
        Методические программы
    </h5>
</div>

<div class="bk-form">
    <div class="bk-form__wrapper">
        @foreach($programs as $program)
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ $program['name'] }}
            </label>
            <div class="bk-form__text">
                <a class="text-primary"
                   href="{{ asset('guides/' . $program['href']) }}"
                   target="_blank">
                    {{ __('_action.print') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
