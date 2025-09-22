@extends('layouts.administrator.master')

@section('content')
    <!-- Header Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Daftar Penilaian Quality Monitoring</h4>
                @can('create penilaian-tappings')
                <a href="{{ route('penilaian-tappings.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti-plus"></i> Tambah Penilaian
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Data Penilaian Table -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Penilaian</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="penilaian" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Agent</th>
                                    <th>Perner</th>
                                    <th>Login ID</th>
                                    <th>Site</th>
                                    <th>Peak</th>
                                    <th>Proses</th>
                                    <th>Sikap</th>
                                    <th>Solusi</th>
                                    <th>Total QM</th>
                                    <th>Tanggal Recording</th>
                                    <th>File</th>
                                    <th>Nama Checker</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat via DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Grafik Analisis Peak</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Filter Urutan:</label>
                            <select id="peakOrder" class="form-control" style="width: auto; display: inline-block; margin-left: 10px;">
                                <option value="asc">=== Pilih Urutan ===</option>
                                <option value="asc">Terkecil ke Terbesar</option>
                                <option value="desc">Terbesar ke Terkecil</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="peakChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="peakChart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div id="peakChart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="peakChart4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan Data Peak</h5>
                    <small class="text-muted">Klik tombol download di samping nilai Peak untuk melihat detail lengkap</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="peak" class="table ">
                            <thead>
                                <tr class="bg-dark" style="color:#fff;">
                                    <th class="text-center text-wrap" style="color:#fff;">Periode</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Nama Agent</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Perner</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Login ID</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Site</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Peak 1</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Peak 2</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Peak 3</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Total QM</th>
                                    <th class="text-center text-wrap" style="color:#fff;">Keterangan</th>
                                </tr>
                                <tr class="dt-filter-row">
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Periode" /></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Nama Agent" /></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Perner" /></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Login ID" /></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Site" /></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Total QM" /></th>
                                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Keterangan" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penilaianTappingsGrouped as $value)
                                    <tr>
                                        <td class="text-center text-wrap">{{ $value['periode'] }}</td>
                                        <td class="text-center text-wrap">{{ $value['name'] }}</td>
                                        <td class="text-center text-wrap">{{ $value['perner'] }}</td>
                                        <td class="text-center text-wrap">{{ $value['login_id'] }}</td>
                                        <td class="text-center text-wrap">{{ $value['site'] }}</td>
                                        <td class="text-center text-wrap">
                                            @if($value['peak_1'] > 0)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2">{{ $value['peak_1'] }}</span>
                                                    <a href="{{ route('penilaian-tappings.download-agent', ['agentId' => $value['user_id'], 'peak' => 1]) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Download Detail Peak 1">
                                                        <i class="ti-download"></i>
                                                    </a>
                                                </div>
                                            @else
                                                {{ $value['peak_1'] }}
                                            @endif
                                        </td>
                                        <td class="text-center text-wrap">
                                            @if($value['peak_2'] > 0)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2">{{ $value['peak_2'] }}</span>
                                                    <a href="{{ route('penilaian-tappings.download-agent', ['agentId' => $value['user_id'], 'peak' => 2]) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Download Detail Peak 2">
                                                        <i class="ti-download"></i>
                                                    </a>
                                                </div>
                                            @else
                                                {{ $value['peak_2'] }}
                                            @endif
                                        </td>
                                        <td class="text-center text-wrap">
                                            @if($value['peak_3'] > 0)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2">{{ $value['peak_3'] }}</span>
                                                    <a href="{{ route('penilaian-tappings.download-agent', ['agentId' => $value['user_id'], 'peak' => 3]) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Download Detail Peak 3">
                                                        <i class="ti-download"></i>
                                                    </a>
                                                </div>
                                            @else
                                                {{ $value['peak_3'] }}
                                            @endif
                                        </td>
                                        <td class="text-center text-wrap">{{ round($value['total_qm'] / 3) }}</td>
                                        <td class="text-center text-wrap">
                                            @php $total_qm_bulat = round($value['total_qm'] / 3); @endphp
                                            @if ($total_qm_bulat >= 90)
                                                <span class="badge bg-success">LULUS</span>
                                            @else
                                                <span class="badge bg-danger">TIDAK LULUS</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
$(document).ready(function() {
    // DataTable Ringkasan dengan filter kolom manual agar align
    // Hanya satu inisialisasi DataTable untuk #peak
    var tableRingkasan = $('#peak').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            zeroRecords: 'Data tidak ditemukan',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
            infoFiltered: '(disaring dari _MAX_ total data)'
        }
    });
    // Aktifkan filter kolom manual
    tableRingkasan.columns().every(function (colIdx) {
        $('input', $('.dt-filter-row th').eq(colIdx)).on('keyup change clear', function () {
            if (tableRingkasan.column(colIdx).search() !== this.value) {
                tableRingkasan.column(colIdx).search(this.value).draw();
            }
        });
    });
    // DataTable initialization
    $('#penilaian').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('penilaian-tappings.index') }}",
            error: function(xhr, error, thrown) {
                console.log('DataTable AJAX Error:', error);
                console.log('Response:', xhr.responseText);
                alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'user.name', name: 'user.name'},
            {data: 'perner', name: 'perner'},
            {data: 'login_id', name: 'login_id'},
            {data: 'site', name: 'site'},
            {data: 'peak', name: 'peak'},
            {data: 'total_proses', name: 'total_proses'},
            {data: 'total_sikap', name: 'total_sikap'},
            {data: 'total_solusi', name: 'total_solusi'},
            {data: 'total_qm_p1', name: 'total_qm_p1'},
            {data: 'tanggal_recording', name: 'tanggal_recording'},
            {data: 'file', name: 'file'},
            {data: 'nama_checker', name: 'nama_checker'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible:not(.not-export-col)'
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 10;
                }
            },
            'print'
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: "Memproses...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        createdRow: function(row, data, dataIndex) {
            // Menambahkan warna latar belakang untuk setiap kolom Peak
            var peak = $(row).find('td').eq(5).text().trim();
            if (peak === '1') {
                $(row).find('td').css('background-color', '#FFDDDD');
            } else if (peak === '2') {
                $(row).find('td').css('background-color', '#DDFFDD');
            } else if (peak === '3') {
                $(row).find('td').css('background-color', '#DDDDFF');
            }
        }
    });

    // Delete functionality
    $(document).on('click', '.deletePenilaian', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Yakin hapus data?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "penilaian-tappings/" + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#penilaian').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success || 'Data berhasil dihapus',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menghapus data',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });


    // Chart data preparation
    var categories = [];
    var peak1Data = [];
    var peak2Data = [];
    var peak3Data = [];
    var chartRawData = [];

    // Ambil data dari tabel ringkasan (peak) secara dinamis
    function getTableRingkasanData() {
        var data = [];
        $('#peak tbody tr').each(function() {
            var $tds = $(this).find('td');
            if ($tds.length >= 9) {
                data.push({
                    name: $tds.eq(1).text().trim(),
                    peak1: parseFloat($tds.eq(5).text()) || 0,
                    peak2: parseFloat($tds.eq(6).text()) || 0,
                    peak3: parseFloat($tds.eq(7).text()) || 0
                });
            }
        });
        return data;
    }

    function updateChartData(order, customData) {
        var sorted = (customData || chartRawData).slice();
        if(order === 'asc') {
            sorted.sort((a,b) => (a.peak1+a.peak2+a.peak3) - (b.peak1+b.peak2+b.peak3));
        } else if(order === 'desc') {
            sorted.sort((a,b) => (b.peak1+b.peak2+b.peak3) - (a.peak1+a.peak2+a.peak3));
        }
        categories = sorted.map(x => x.name);
        peak1Data = sorted.map(x => x.peak1);
        peak2Data = sorted.map(x => x.peak2);
        peak3Data = sorted.map(x => x.peak3);
    }

    // Inisialisasi chartRawData dari tabel (jika ada)
    chartRawData = getTableRingkasanData();
    updateChartData('asc', chartRawData);


    // Initialize charts
    function initializeCharts() {
        Highcharts.chart('peakChart', {
            chart: { type: 'line' },
            title: { text: 'Perbandingan QM Peak I, II, dan III' },
            xAxis: { categories: categories },
            yAxis: {
                title: { text: 'Nilai QM' },
                max: 100,
                tickPositions: [10,20,30,40,50,60,70,80,90,100],
                labels: { formatter: function () { return this.value; } }
            },
            series: [
                { name: 'Peak 1', data: peak1Data, color: '#ff0000' },
                { name: 'Peak 2', data: peak2Data, color: '#3cb371' },
                { name: 'Peak 3', data: peak3Data, color: '#0000ff' }
            ],
            exporting: { enabled: true }
        });

        Highcharts.chart('peakChart2', {
            chart: { type: 'line' },
            title: { text: 'QM Peak I' },
            xAxis: { categories: categories },
            yAxis: {
                title: { text: 'QM Peak I' },
                max: 100,
                tickPositions: [10,20,30,40,50,60,70,80,90,100],
                labels: { formatter: function () { return this.value; } }
            },
            series: [{ name: 'Peak 1', data: peak1Data, color: '#ff0000' }],
            exporting: { enabled: true }
        });

        Highcharts.chart('peakChart3', {
            chart: { type: 'line' },
            title: { text: 'QM Peak II' },
            xAxis: { categories: categories },
            yAxis: {
                title: { text: 'QM Peak II' },
                max: 100,
                tickPositions: [10,20,30,40,50,60,70,80,90,100],
                labels: { formatter: function () { return this.value; } }
            },
            series: [{ name: 'Peak 2', data: peak2Data, color: '#3cb371' }],
            exporting: { enabled: true }
        });

        Highcharts.chart('peakChart4', {
            chart: { type: 'line' },
            title: { text: 'QM Peak III' },
            xAxis: { categories: categories },
            yAxis: {
                title: { text: 'QM Peak III' },
                max: 100,
                tickPositions: [10,20,30,40,50,60,70,80,90,100],
                labels: { formatter: function () { return this.value; } }
            },
            series: [{ name: 'Peak 3', data: peak3Data, color: '#0000ff' }],
            exporting: { enabled: true }
        });
    }

    initializeCharts();

    // Update grafik setiap filter/search DataTable ringkasan berubah
    var tableRingkasanDT = $('#peak').DataTable();
    tableRingkasanDT.on('search.dt draw.dt', function() {
        var filteredData = [];
        tableRingkasanDT.rows({ search: 'applied' }).every(function() {
            var d = this.data();
            // d adalah array jika data HTML, atau object jika ajax
            // Ambil data dari kolom yang sesuai
            var $row = $(this.node());
            var tds = $row.find('td');
            if (tds.length >= 9) {
                filteredData.push({
                    name: tds.eq(1).text().trim(),
                    peak1: parseFloat(tds.eq(5).text()) || 0,
                    peak2: parseFloat(tds.eq(6).text()) || 0,
                    peak3: parseFloat(tds.eq(7).text()) || 0
                });
            }
        });
        var order = $('#peakOrder').val() || 'asc';
        updateChartData(order, filteredData);
        initializeCharts();
    });

    // Filter urutan grafik
    $('#peakOrder').on('change', function() {
        var order = $(this).val();
        updateChartData(order);
        initializeCharts();
    });
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.querySelector('.toast');
    if (toastEl) {
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});
</script>
@endpush
