<div class="my-2 bk-callout">
    <h5 class="m-0">
        Бланки заявлений на возврат денежных средств
    </h5>
</div>

<div class="bk-form">
    <div class="bk-form__wrapper">
        @foreach($blanks as $blank)
        @if($blank['type'] == 'special')
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ $blank['name'] }}
            </label>
            <div class="bk-form__text">
                <a class="text-primary"
                   href="{{ asset('blanks/' . $blank['href']) }}"
                   target="_blank">
                    {{ __('_action.print') }}
                </a>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
