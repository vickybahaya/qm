@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Edit Penilaian Quality Monitoring</h4>
                <a href="{{ route('penilaian-tappings.index') }}" class="btn btn-secondary btn-sm">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('penilaian-tappings.update', $penilaianTapping->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <!-- Informasi Dasar -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Nama Agent</label>
                                    <select name="name_id" class="form-control" id="user_id_dropdown" required disabled>
                                        <option value="">Pilih Agent</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                data-perner="{{ $user->profile->perner ?? '' }}"
                                                data-site="{{ $user->profile->site ?? '' }}" 
                                                data-login="{{ $user->profile->login_id ?? '' }}"
                                                @if($user->id == $penilaianTapping->name_id) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="name_id" value="{{ $penilaianTapping->name_id }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Perner</label>
                                    <input type="text" name="perner" class="form-control" id="perner_input" value="{{ $penilaianTapping->perner }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Login ID</label>
                                    <input type="text" name="login_id" class="form-control" id="login_id_input" value="{{ $penilaianTapping->login_id }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Site</label>
                                    <input type="text" name="site" class="form-control" id="site_input" value="{{ $penilaianTapping->site }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">Peak</label>
                                    <select class="form-control" name="peak" required>
                                        <option value="">Pilih</option>
                                        <option value="1" @if($penilaianTapping->peak == 1) selected @endif>1</option>
                                        <option value="2" @if($penilaianTapping->peak == 2) selected @endif>2</option>
                                        <option value="3" @if($penilaianTapping->peak == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Recording</label>
                                    <input type="date" name="tanggal_recording" class="form-control" value="{{ $penilaianTapping->tanggal_recording }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">File Recording (WAV)</label>
                                    @if($penilaianTapping->file)
                                        <audio controls class="w-100 mt-2">
                                            <source src="{{ asset('storage/' . $penilaianTapping->file) }}" type="audio/wav">
                                            Your browser does not support the audio element.
                                        </audio>
                                        <div class="mt-2">
                                            <span class="badge bg-info text-dark">{{ basename($penilaianTapping->file) }}</span>
                                            <a href="{{ asset('storage/' . $penilaianTapping->file) }}" download class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control mt-2" name="file" id="file" accept=".wav">
                                    <div class="mt-2">
                                        <progress id="progressBar" value="0" max="100" class="w-100"></progress>
                                    </div>
                                    <audio id="audioPlayer" controls style="display: none;" class="w-100 mt-2"></audio>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="periode" value="{{ $penilaianTapping->periode }}">
                        <input type="hidden" name="nama_checker" value="{{ $penilaianTapping->nama_checker }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Parameter Penilaian -->

        <!-- Parameter Penilaian (Langsung di sini, tanpa partial) -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="proses-tab" data-bs-toggle="tab" href="#proses" role="tab" aria-controls="proses" aria-selected="true">
                                    <i class="ti-settings"></i> Parameter Proses
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sikap-tab" data-bs-toggle="tab" href="#sikap" role="tab" aria-controls="sikap" aria-selected="false">
                                    <i class="ti-user"></i> Parameter Sikap
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="solusi-tab" data-bs-toggle="tab" href="#solusi" role="tab" aria-controls="solusi" aria-selected="false">
                                    <i class="ti-lightbulb"></i> Parameter Solusi
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <!-- Parameter Proses -->
                            <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 80%">Parameter</th>
                                                <th style="width: 20%">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parameterProses as $proses)
                                                <tr class="table-primary">
                                                    <td><strong>{{ $proses->header_parameter_pembuka }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control text-center" name="total_n1" value="{{ old('total_n1', $penilaianTapping->total_n1 ?? '') }}" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_1" value="{{ old('detail_n1_1', $penilaianTapping->detail_n1_1 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p2 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_2" value="{{ old('detail_n1_2', $penilaianTapping->detail_n1_2 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p3 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_3" value="{{ old('detail_n1_3', $penilaianTapping->detail_n1_3 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p4 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_4" value="{{ old('detail_n1_4', $penilaianTapping->detail_n1_4 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p5 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_5" value="{{ old('detail_n1_5', $penilaianTapping->detail_n1_5 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $proses->header_parameter_verifikasi }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control text-center" name="total_n2" value="{{ old('total_n2', $penilaianTapping->total_n2 ?? '') }}" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_v1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n2_1" value="{{ old('detail_n2_1', $penilaianTapping->detail_n2_1 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n2')">
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $proses->header_parameter_penutup }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control text-center" name="total_n3" value="{{ old('total_n3', $penilaianTapping->total_n3 ?? '') }}" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_sp1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n3_1" value="{{ old('detail_n3_1', $penilaianTapping->detail_n3_1 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n3')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_sp2 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n3_2" value="{{ old('detail_n3_2', $penilaianTapping->detail_n3_2 ?? 1) }}" min="0" max="1" onchange="calculateTotal('n3')">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Parameter Sikap -->
                            <div class="tab-pane fade" id="sikap" role="tabpanel" aria-labelledby="sikap-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 80%">Parameter</th>
                                                <th style="width: 20%">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parameterSikap as $sikap)
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p1 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n4" value="{{ old('total_n4', $penilaianTapping->total_n4 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_1_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n4_1" value="{{ old('detail_n4_1', $penilaianTapping->detail_n4_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_1_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n4_2" value="{{ old('detail_n4_2', $penilaianTapping->detail_n4_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_1_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n4_3" value="{{ old('detail_n4_3', $penilaianTapping->detail_n4_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p2 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n5" value="{{ old('total_n5', $penilaianTapping->total_n5 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_2_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n5_1" value="{{ old('detail_n5_1', $penilaianTapping->detail_n5_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p3 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n6" value="{{ old('total_n6', $penilaianTapping->total_n6 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_3_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n6_1" value="{{ old('detail_n6_1', $penilaianTapping->detail_n6_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_3_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n6_2" value="{{ old('detail_n6_2', $penilaianTapping->detail_n6_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_3_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n6_3" value="{{ old('detail_n6_3', $penilaianTapping->detail_n6_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_3_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n6_4" value="{{ old('detail_n6_4', $penilaianTapping->detail_n6_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p4 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n7" value="{{ old('total_n7', $penilaianTapping->total_n7 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_4_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n7_1" value="{{ old('detail_n7_1', $penilaianTapping->detail_n7_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_4_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n7_2" value="{{ old('detail_n7_2', $penilaianTapping->detail_n7_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_4_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n7_3" value="{{ old('detail_n7_3', $penilaianTapping->detail_n7_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p5 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n8" value="{{ old('total_n8', $penilaianTapping->total_n8 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_1" value="{{ old('detail_n8_1', $penilaianTapping->detail_n8_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_2" value="{{ old('detail_n8_2', $penilaianTapping->detail_n8_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_3" value="{{ old('detail_n8_3', $penilaianTapping->detail_n8_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_4" value="{{ old('detail_n8_4', $penilaianTapping->detail_n8_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_5 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_5" value="{{ old('detail_n8_5', $penilaianTapping->detail_n8_5 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_6 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_6" value="{{ old('detail_n8_6', $penilaianTapping->detail_n8_6 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_7 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_7" value="{{ old('detail_n8_7', $penilaianTapping->detail_n8_7 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_8 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_8" value="{{ old('detail_n8_8', $penilaianTapping->detail_n8_8 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_9 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_9" value="{{ old('detail_n8_9', $penilaianTapping->detail_n8_9 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_5_10 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n8_10" value="{{ old('detail_n8_10', $penilaianTapping->detail_n8_10 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p6 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n9" value="{{ old('total_n9', $penilaianTapping->total_n9 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_1" value="{{ old('detail_n9_1', $penilaianTapping->detail_n9_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_2" value="{{ old('detail_n9_2', $penilaianTapping->detail_n9_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_3" value="{{ old('detail_n9_3', $penilaianTapping->detail_n9_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_4" value="{{ old('detail_n9_4', $penilaianTapping->detail_n9_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_5 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_5" value="{{ old('detail_n9_5', $penilaianTapping->detail_n9_5 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_6_6 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n9_6" value="{{ old('detail_n9_6', $penilaianTapping->detail_n9_6 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p7 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n10" value="{{ old('total_n10', $penilaianTapping->total_n10 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_7_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n10_1" value="{{ old('detail_n10_1', $penilaianTapping->detail_n10_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p8 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n11" value="{{ old('total_n11', $penilaianTapping->total_n11 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_8_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n11_1" value="{{ old('detail_n11_1', $penilaianTapping->detail_n11_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p9 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n12" value="{{ old('total_n12', $penilaianTapping->total_n12 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_1" value="{{ old('detail_n12_1', $penilaianTapping->detail_n12_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_2" value="{{ old('detail_n12_2', $penilaianTapping->detail_n12_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_3" value="{{ old('detail_n12_3', $penilaianTapping->detail_n12_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_4" value="{{ old('detail_n12_4', $penilaianTapping->detail_n12_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_5 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_5" value="{{ old('detail_n12_5', $penilaianTapping->detail_n12_5 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_6 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_6" value="{{ old('detail_n12_6', $penilaianTapping->detail_n12_6 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_9_7 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n12_7" value="{{ old('detail_n12_7', $penilaianTapping->detail_n12_7 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p10 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n13" value="{{ old('total_n13', $penilaianTapping->total_n13 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_10_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n13_1" value="{{ old('detail_n13_1', $penilaianTapping->detail_n13_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_10_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n13_2" value="{{ old('detail_n13_2', $penilaianTapping->detail_n13_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_10_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n13_3" value="{{ old('detail_n13_3', $penilaianTapping->detail_n13_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_10_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n13_4" value="{{ old('detail_n13_4', $penilaianTapping->detail_n13_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $sikap->header_p11 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n14" value="{{ old('total_n14', $penilaianTapping->total_n14 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_11_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n14_1" value="{{ old('detail_n14_1', $penilaianTapping->detail_n14_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_11_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n14_2" value="{{ old('detail_n14_2', $penilaianTapping->detail_n14_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $sikap->detail_11_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n14_3" value="{{ old('detail_n14_3', $penilaianTapping->detail_n14_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Parameter Solusi -->
                            <div class="tab-pane fade" id="solusi" role="tabpanel" aria-labelledby="solusi-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 80%">Parameter</th>
                                                <th style="width: 20%">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parameterSolusi as $solusi)
                                                <tr class="table-primary">
                                                    <td><strong>{{ $solusi->header_p1 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n15" value="{{ old('total_n15', $penilaianTapping->total_n15 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $solusi->detail_p1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n15_1" value="{{ old('detail_n15_1', $penilaianTapping->detail_n15_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $solusi->header_p2 }}</strong></td>
                                                    <td><input type="number" class="form-control text-center" name="total_n16" value="{{ old('total_n16', $penilaianTapping->total_n16 ?? '') }}" readonly="readonly" style="font-weight: bold;"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $solusi->detail_p2_1 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n16_1" value="{{ old('detail_n16_1', $penilaianTapping->detail_n16_1 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $solusi->detail_p2_2 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n16_2" value="{{ old('detail_n16_2', $penilaianTapping->detail_n16_2 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $solusi->detail_p2_3 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n16_3" value="{{ old('detail_n16_3', $penilaianTapping->detail_n16_3 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $solusi->detail_p2_4 }}</td>
                                                    <td><input type="number" class="form-control text-center" name="detail_n16_4" value="{{ old('detail_n16_4', $penilaianTapping->detail_n16_4 ?? 1) }}" min="0" max="1"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti-save"></i> Update Penilaian
                        </button>
                        <a href="{{ route('penilaian-tappings.index') }}" class="btn btn-secondary btn-lg ms-2">
                            <i class="ti-close"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>


@push('js')
<script>
    // File upload handling (preview)
    const fileInput = document.getElementById('file');
    const progressBar = document.getElementById('progressBar');
    const audioPlayer = document.getElementById('audioPlayer');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const objectURL = URL.createObjectURL(file);
                audioPlayer.src = objectURL;
                audioPlayer.style.display = 'block';
            }
        });
    }
    if (audioPlayer) {
        audioPlayer.addEventListener('timeupdate', function() {
            const percentage = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            progressBar.value = percentage;
        });
    }

    // Mapping prefix dan jumlah detail untuk proses
    const prosesMap = [
        {prefix: 'n1', count: 5},
        {prefix: 'n2', count: 2},
        {prefix: 'n3', count: 2}
    ];
    prosesMap.forEach(function(item) {
        for (let i = 1; i <= item.count; i++) {
            let input = document.querySelector('input[name="detail_' + item.prefix + '_' + i + '"]');
            if (input) {
                input.addEventListener('input', function() {
                    calculateTotal(item.prefix, item.count);
                });
            }
        }
        // Hitung total saat load
        calculateTotal(item.prefix, item.count);
    });
    function calculateTotal(prefix, count) {
        let total = 0;
        for (let i = 1; i <= count; i++) {
            let input = document.querySelector('input[name="detail_' + prefix + '_' + i + '"]');
            if (input) {
                let val = parseInt(input.value);
                if (!isNaN(val)) total += val;
            }
        }
        let totalInput = document.querySelector('input[name="total_' + prefix + '"]');
        if (totalInput) totalInput.value = total;
    }

    // --- PROSES ---
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n1_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n1_1"]').value);
            let d2 = parseInt(document.querySelector('input[name="detail_n1_2"]').value);
            let d3 = parseInt(document.querySelector('input[name="detail_n1_3"]').value);
            let d4 = parseInt(document.querySelector('input[name="detail_n1_4"]').value);
            let d5 = parseInt(document.querySelector('input[name="detail_n1_5"]').value);
            let total = 0;
            if (d1 === 1 && d2 === 1 && d3 === 1 && d4 === 1 && d5 === 1) {
                total = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
            }
            document.querySelector('input[name="total_n1"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n2_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n2_1"]').value);
            let total = 0;
            if (d1 === 1) {
                total = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
            }
            document.querySelector('input[name="total_n2"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n3_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n3_1"]').value);
            let d2 = parseInt(document.querySelector('input[name="detail_n3_2"]').value);
            let total = 0;
            if (d1 === 1 && d2 === 1) {
                total = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
            }
            document.querySelector('input[name="total_n3"]').value = total;
        }
    });
    // Inisialisasi total saat halaman load
    window.addEventListener('DOMContentLoaded', function() {
        let d1 = parseInt(document.querySelector('input[name="detail_n1_1"]').value);
        let d2 = parseInt(document.querySelector('input[name="detail_n1_2"]').value);
        let d3 = parseInt(document.querySelector('input[name="detail_n1_3"]').value);
        let d4 = parseInt(document.querySelector('input[name="detail_n1_4"]').value);
        let d5 = parseInt(document.querySelector('input[name="detail_n1_5"]').value);
        let total = 0;
        if (d1 === 1 && d2 === 1 && d3 === 1 && d4 === 1 && d5 === 1) {
            total = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
        }
        document.querySelector('input[name="total_n1"]').value = total;

        let v1 = parseInt(document.querySelector('input[name="detail_n2_1"]').value);
        let total2 = 0;
        if (v1 === 1) {
            total2 = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
        }
        document.querySelector('input[name="total_n2"]').value = total2;

        let p1 = parseInt(document.querySelector('input[name="detail_n3_1"]').value);
        let p2 = parseInt(document.querySelector('input[name="detail_n3_2"]').value);
        let total3 = 0;
        if (p1 === 1 && p2 === 1) {
            total3 = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
        }
        document.querySelector('input[name="total_n3"]').value = total3;
    });
</script>
<script>
    // --- SIKAP ---
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n4_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n4_1"]').value);
            let d2 = parseInt(document.querySelector('input[name="detail_n4_2"]').value);
            let d3 = parseInt(document.querySelector('input[name="detail_n4_3"]').value);
            let total = 0;
            if (d1 === 1 && d2 === 1 && d3 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p1 ?? 0 }}");
            }
            document.querySelector('input[name="total_n4"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n5_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n5_1"]').value);
            let total = 0;
            if (d1 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p2 ?? 0 }}");
            }
            document.querySelector('input[name="total_n5"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n6_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n6_1"]').value);
            let d2 = parseInt(document.querySelector('input[name="detail_n6_2"]').value);
            let d3 = parseInt(document.querySelector('input[name="detail_n6_3"]').value);
            let d4 = parseInt(document.querySelector('input[name="detail_n6_4"]').value);
            let total = 0;
            if (d1 === 1 && d2 === 1 && d3 === 1 && d4 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p3 ?? 0 }}");
            }
            document.querySelector('input[name="total_n6"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n7_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n7_1"]').value);
            let d2 = parseInt(document.querySelector('input[name="detail_n7_2"]').value);
            let d3 = parseInt(document.querySelector('input[name="detail_n7_3"]').value);
            let total = 0;
            if (d1 === 1 && d2 === 1 && d3 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p4 ?? 0 }}");
            }
            document.querySelector('input[name="total_n7"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n8_')) {
            let arr = [];
            for (let i = 1; i <= 10; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n8_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p5 ?? 0 }}");
            }
            document.querySelector('input[name="total_n8"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n9_')) {
            let arr = [];
            for (let i = 1; i <= 6; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n9_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p6 ?? 0 }}");
            }
            document.querySelector('input[name="total_n9"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n10_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n10_1"]').value);
            let total = 0;
            if (d1 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p7 ?? 0 }}");
            }
            document.querySelector('input[name="total_n10"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n11_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n11_1"]').value);
            let total = 0;
            if (d1 === 1) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p8 ?? 0 }}");
            }
            document.querySelector('input[name="total_n11"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n12_')) {
            let arr = [];
            for (let i = 1; i <= 7; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n12_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p9 ?? 0 }}");
            }
            document.querySelector('input[name="total_n12"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n13_')) {
            let arr = [];
            for (let i = 1; i <= 4; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n13_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p10 ?? 0 }}");
            }
            document.querySelector('input[name="total_n13"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n14_')) {
            let arr = [];
            for (let i = 1; i <= 3; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n14_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSikap->first()->bobot_p11 ?? 0 }}");
            }
            document.querySelector('input[name="total_n14"]').value = total;
        }
        // --- SOLUSI ---
        if (e.target && e.target.name.startsWith('detail_n15_')) {
            let d1 = parseInt(document.querySelector('input[name="detail_n15_1"]').value);
            let total = 0;
            if (d1 === 1) {
                total = parseInt("{{ $parameterSolusi->first()->bobot_p1 ?? 0 }}");
            }
            document.querySelector('input[name="total_n15"]').value = total;
        }
        if (e.target && e.target.name.startsWith('detail_n16_')) {
            let arr = [];
            for (let i = 1; i <= 4; i++) {
                arr.push(parseInt(document.querySelector('input[name="detail_n16_' + i + '"]').value));
            }
            let total = 0;
            if (arr.every(v => v === 1)) {
                total = parseInt("{{ $parameterSolusi->first()->bobot_p2 ?? 0 }}");
            }
            document.querySelector('input[name="total_n16"]').value = total;
        }
    });
    // Inisialisasi total saat halaman load (sikap & solusi)
    window.addEventListener('DOMContentLoaded', function() {
        // SIKAP
        let d4 = [1,2,3].map(i=>parseInt(document.querySelector('input[name="detail_n4_'+i+'"]').value));
        document.querySelector('input[name="total_n4"]').value = (d4.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p1 ?? 0 }}") : 0;
        let d5 = parseInt(document.querySelector('input[name="detail_n5_1"]').value);
        document.querySelector('input[name="total_n5"]').value = (d5===1) ? parseInt("{{ $parameterSikap->first()->bobot_p2 ?? 0 }}") : 0;
        let d6 = [1,2,3,4].map(i=>parseInt(document.querySelector('input[name="detail_n6_'+i+'"]').value));
        document.querySelector('input[name="total_n6"]').value = (d6.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p3 ?? 0 }}") : 0;
        let d7 = [1,2,3].map(i=>parseInt(document.querySelector('input[name="detail_n7_'+i+'"]').value));
        document.querySelector('input[name="total_n7"]').value = (d7.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p4 ?? 0 }}") : 0;
        let d8 = Array.from({length:10},(_,i)=>parseInt(document.querySelector('input[name="detail_n8_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n8"]').value = (d8.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p5 ?? 0 }}") : 0;
        let d9 = Array.from({length:6},(_,i)=>parseInt(document.querySelector('input[name="detail_n9_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n9"]').value = (d9.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p6 ?? 0 }}") : 0;
        let d10 = parseInt(document.querySelector('input[name="detail_n10_1"]').value);
        document.querySelector('input[name="total_n10"]').value = (d10===1) ? parseInt("{{ $parameterSikap->first()->bobot_p7 ?? 0 }}") : 0;
        let d11 = parseInt(document.querySelector('input[name="detail_n11_1"]').value);
        document.querySelector('input[name="total_n11"]').value = (d11===1) ? parseInt("{{ $parameterSikap->first()->bobot_p8 ?? 0 }}") : 0;
        let d12 = Array.from({length:7},(_,i)=>parseInt(document.querySelector('input[name="detail_n12_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n12"]').value = (d12.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p9 ?? 0 }}") : 0;
        let d13 = Array.from({length:4},(_,i)=>parseInt(document.querySelector('input[name="detail_n13_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n13"]').value = (d13.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p10 ?? 0 }}") : 0;
        let d14 = Array.from({length:3},(_,i)=>parseInt(document.querySelector('input[name="detail_n14_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n14"]').value = (d14.every(v=>v===1)) ? parseInt("{{ $parameterSikap->first()->bobot_p11 ?? 0 }}") : 0;
        // SOLUSI
        let d15 = parseInt(document.querySelector('input[name="detail_n15_1"]').value);
        document.querySelector('input[name="total_n15"]').value = (d15===1) ? parseInt("{{ $parameterSolusi->first()->bobot_p1 ?? 0 }}") : 0;
        let d16 = Array.from({length:4},(_,i)=>parseInt(document.querySelector('input[name="detail_n16_'+(i+1)+'"]').value));
        document.querySelector('input[name="total_n16"]').value = (d16.every(v=>v===1)) ? parseInt("{{ $parameterSolusi->first()->bobot_p2 ?? 0 }}") : 0;
    });
</script>
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

@endsection
