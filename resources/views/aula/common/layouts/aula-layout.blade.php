@include('aula.common.partials.head')

<body class="g-sidenav-show bg-gray-200">

    @include('aula.common.partials.aside')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        @include('aula.common.partials.navbar')

        @yield('content')

    </main>

    @include('aula.common.partials.scripts')


</body>

</html>