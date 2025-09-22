@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">{{ $title }}</h4>

                @can('create users')
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm" id="createUser">
                        <i class="ti-plus"></i>
                        Tambah Data
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>No HP</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            {{-- ✅ Tambahan --}}
                            <th>Perner</th>
                            <th>Site</th>
                            <th>Layanan</th>
                            <th>Login ID</th>
                            <th width="120px">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            // ajax table
            var table = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columnDefs: [{
                    "targets": "_all",
                    "className": "text-start"
                }],
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'nama_user', name: 'nama_user' },
                    { data: 'role', name: 'role' },
                    { data: 'no_hp', name: 'no_hp' },
                    { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                    { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                    { data: 'alamat', name: 'alamat' },

                    // ✅ Kolom tambahan
                    { data: 'perner', name: 'perner' },
                    { data: 'site', name: 'site' },
                    { data: 'layanan', name: 'layanan' },
                    { data: 'login_id', name: 'login_id' },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // delete
            $('body').on('click', '.deleteUser', function() {
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#82868',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('users') }}/" + userId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                table.draw();
                                showToast('success', response.message);
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON.message;
                                showToast('error', errorMessage);
                            }
                        });
                    }
                });
            });

            // search permission
            $(document).on('input', '#searchPermission', function() {
                var searchValue = $(this).val().toLowerCase();
                var permissionItems = $('.permission-item');
                var showSelectAll = false;

                permissionItems.each(function() {
                    var label = $(this).find('.form-check-label');
                    var permissionName = label.text().toLowerCase();

                    if (permissionName.includes(searchValue)) {
                        $(this).show();
                        showSelectAll = true;
                    } else {
                        $(this).hide();
                    }
                });

                var selectAllCheckbox = $('#checkAll');
                if (selectAllCheckbox.length > 0) {
                    selectAllCheckbox.closest('.row').css('display', showSelectAll ? 'block' : 'none');
                }
            });
        });
    </script>
@endpush
