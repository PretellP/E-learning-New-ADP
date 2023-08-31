@if (session('flash_message')=='deleted')
<script>
  Swal.fire({
    icon: 'success',
    text: 'Registro eliminado',
    toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
  })
  </script>
@endif
@if (session('flash_message')=='added')
<script>
    Swal.fire({
        icon: 'success',
        text: '¡Registrado exitosamente!',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
  </script>
@endif
@if (session('flash_message')=='updated')
<script>
    Swal.fire({
        icon: 'success',
        text: '¡Registro actualizado!',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
  </script>
@endif