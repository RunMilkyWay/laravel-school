<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.conference_world') }}</title>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="{{ auth()->check() ? 'authenticated' : '' }}">
<!-- Top Navigation -->
<div class="topnav">
    <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="active">{{ __('messages.conference_room') }}</a>
    <div class="right">
        @if (Auth::check())
            <div class="right">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="separator">|</span>
                <a href="{{ route('logout') }}" class="logout-active" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('messages.logout') }}
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('register.form') }}" class="small-btn">{{ __('messages.register') }}</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('messages.login') }}</a>
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">{{ __('messages.log_in') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf <!-- Laravel CSRF protection -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@yield('content')

<footer class="footer">
    <p class="text-white mb-0">
        {{ __('messages.footer_text') }}
        <a href="{{ route('locale.switch', 'en') }}" class="lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        <span class="mx-1 text-white">|</span>
        <a href="{{ route('locale.switch', 'lt') }}" class="lang-link {{ app()->getLocale() === 'lt' ? 'active' : '' }}">LT</a>
    </p>
</footer>
</body>
</html>
