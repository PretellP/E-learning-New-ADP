
    @include('admin.partials.head')

    <body>

    @include('admin.partials.preloader')

        <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @include('admin.partials.navbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                @include('admin.partials.aside')

                @yield('content')

                </div>
            </div>

        </div>
    </div>


    @include('admin.partials.footer')
    

    </body>

</html>