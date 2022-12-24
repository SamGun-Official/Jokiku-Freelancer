<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.landing.meta')

    <title>@yield('title') | Jokiku Freelancer</title>

    @stack('before-style')

    @include('includes.landing.style')

    @stack('after-style')

    {!! RecaptchaV3::initJs() !!}

    @stack('polymer')
</head>

<body class="antialiased flex-column">
    <div class="relative flex-column flex-grow">
        @include('includes.landing.header')
        @include('sweetalert::alert')

        @yield('content')

        @include('includes.landing.footer')

        @stack('before-script')

        @include('includes.landing.script')

        @stack('after-script')

        {{-- modals --}}
        @include('component.modal.login')
        @include('component.modal.register')
        @include('component.modal.register-success')
    </div>
</body>

</html>
