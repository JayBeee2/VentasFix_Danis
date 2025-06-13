@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pequeño retraso para asegurar que la alerta se muestre
            setTimeout(function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#7367F0',
                    confirmButtonText: 'Aceptar'
                });
            }, 300);
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#EA5455',
                    confirmButtonText: 'Aceptar'
                });
            }, 300);
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: "{{ session('info') }}",
                    confirmButtonColor: '#00CFE8',
                    confirmButtonText: 'Aceptar'
                });
            }, 300);
        });
    </script>
@endif

@if (session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Advertencia!',
                    text: "{{ session('warning') }}",
                    confirmButtonColor: '#FF9F43',
                    confirmButtonText: 'Aceptar'
                });
            }, 300);
        });
    </script>
@endif 