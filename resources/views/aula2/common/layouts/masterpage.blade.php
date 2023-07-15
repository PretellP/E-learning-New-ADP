<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('aula2.common.partials.head')

<body>
    <div id="app">

        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('aula2.common.partials.navbar')
            @include('aula2.common.partials.sidebar')

            <div class="main-content">

                <section class="section">

                    @yield('content')

                </section>

            </div>

            @include('aula2.common.partials.footer')

        </div>
    </div>

    @include('aula2.common.partials.scripts')

</body>

</html>