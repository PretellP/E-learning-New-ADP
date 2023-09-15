<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.common.partials.head')

<body>
    <div id="app">

        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('admin.common.partials.navbar')
            @include('admin.common.partials.sidebar')

            <div class="main-content @yield('main-content-extra-class')">

                <section class="section">

                    @yield('content')

                </section>

            </div>

            @include('admin.common.partials.footer')

        </div>
        
    </div>

    @include('admin.common.partials.scripts')

</body>

</html>