
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
<script src="{{asset('assets/aula/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/aula/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/aula/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/aula/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
<script src="{{asset('assets/aula/js/quiz.js')}}"></script>

<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

</script>

<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src=" {{asset('assets/aula/js/material-dashboard.min.js?v=3.0.0')}}"></script>