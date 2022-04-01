<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icons/logo.png') }}">
</head>
<body>

<h1>welcome to admin-panel</h1>
<div class="dropdown-menu">
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button>{{ __('main.exit') }}</button>
    </form>
</div>

</body>
</html>
