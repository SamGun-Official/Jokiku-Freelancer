<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.landing.meta')

    <title>@yield('title') | Jokiku</title>

    @stack('before-style')

    @include('includes.landing.style')

    @stack('after-style')
</head>
<body class="antialiased">
    <div class="relative">

        @include('includes.landing.header')

            {{-- @include('sweetalert::alert') --}}

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
