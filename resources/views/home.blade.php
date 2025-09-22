@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="mb-1">Total Penilaian</h6>
                    <h3 class="fw-bold">{{ $stat['total_penilaian'] ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="mb-1">Agent Dinilai</h6>
                    <h3 class="fw-bold">{{ $stat['total_agent'] ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="mb-1">Rata-rata Nilai QM</h6>
                    <h3 class="fw-bold">{{ $stat['avg_qm'] ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="mb-1">% Lulus</h6>
                    <h3 class="fw-bold">{{ $stat['persen_lulus'] ?? '-' }}%</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Tren Nilai QM per Bulan</h5>
                </div>
                <div class="card-body">
                    <canvas id="qmTrendChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Status Kelulusan</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusPieChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Penilaian Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Agent</th>
                                    <th>Nilai QM</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest as $item)
                                <tr>
                                    <td>{{ $item->tanggal_recording }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ $item->total_qm_p1 }}</td>
                                    <td>
                                        <span class="badge {{ strtolower($item->keterangan)==='lulus' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->keterangan }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // Data dummy, ganti dengan data dinamis dari controller
    var ctx = document.getElementById('qmTrendChart').getContext('2d');
    var qmTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart['labels'] ?? []),
            datasets: [{
                label: 'Nilai QM',
                data: @json($chart['data'] ?? []),
                borderColor: '#245953',
                backgroundColor: 'rgba(36,89,83,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
    var ctx2 = document.getElementById('statusPieChart').getContext('2d');
    var statusPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Lulus', 'Tidak Lulus'],
            datasets: [{
                data: @json($chart['pie'] ?? [0,0]),
                backgroundColor: ['#4caf50', '#e53935']
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush
