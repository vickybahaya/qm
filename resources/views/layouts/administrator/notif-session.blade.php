
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        });
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error')),
                timer: 2500,
                showConfirmButton: false
            });
        });
    </script>
@endif
