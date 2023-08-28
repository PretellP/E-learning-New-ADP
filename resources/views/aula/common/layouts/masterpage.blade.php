<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('aula.common.partials.head')

<body>
    <div id="app">

        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('aula.common.partials.navbar')
            @include('aula.common.partials.sidebar')

            <div class="main-content @yield('main-content-extra-class')">

                <section class="section">

                    @yield('content')

                </section>

            </div>

            @include('aula.common.partials.footer')

        </div>
    </div>

    @include('aula.common.partials.scripts')

</body>

</html>