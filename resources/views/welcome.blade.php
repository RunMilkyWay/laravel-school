@extends('layouts.app')
@section('content')

    @if (session('success'))
        <div class="custom-alert alert-dismissible fade show auto-dismiss-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <div id="welcome-wrapper" data-redirect="true">
            <div class="container text-center welcome">
                <div id="animated-text"></div>
            </div>
        </div>


    <script>
        const textEffectTranslations = {
            welcomeMessage: "{{ __('messages.welcome_message') }}",
        };
    </script>

@endsection
