@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Penilaian Quality Monitoring</h4>
                <a href="{{ route('penilaian-tappings.index') }}" class="btn btn-secondary btn-sm">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>


    <form method="POST" action="{{ route('penilaian-tappings.store') }}" enctype="multipart/form-data">
        @csrf
        
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
                                    <select name="name_id" class="form-control" id="user_id_dropdown" required>
                                        <option value="">Pilih Agent</option>
                                        @foreach($users as $user)
                                            @if(isset($user->role) ? $user->role === 'Agent' : (isset($user->roles) && (is_array($user->roles) ? in_array('Agent', $user->roles) : $user->roles->contains('name', 'Agent'))))
                                                <option value="{{ $user->id }}" 
                                                    data-perner="{{ $user->profile->perner ?? '' }}"
                                                    data-site="{{ $user->profile->site ?? '' }}" 
                                                    data-login="{{ $user->profile->login_id ?? '' }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Perner</label>
                                    <input type="text" name="perner" class="form-control" id="perner_input" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Login ID</label>
                                    <input type="text" name="login_id" class="form-control" id="login_id_input" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Site</label>
                                    <input type="text" name="site" class="form-control" id="site_input" readonly>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">Peak</label>
                                    <select class="form-control" name="peak" required>
                                        <option value="">Pilih</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Recording</label>
                                    <input type="date" name="tanggal_recording" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload File Recording (WAV)</label>
                                    <input type="file" class="form-control" name="file" id="file" accept=".wav" required>
                                    <div class="mt-2">
                                        <progress id="progressBar" value="0" max="100" class="w-100"></progress>
                                    </div>
                                    <audio id="audioPlayer" controls style="display: none;" class="w-100 mt-2"></audio>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="periode" value="{{ date('Y-m') }}">
                        <input type="hidden" name="nama_checker" value="{{ Auth::user()->name }}">
                    </div>
                </div>
            </div>
        </div>



        <!-- Parameter Penilaian -->
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
                                                        <input type="number" class="form-control text-center" name="total_n1" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_1" value="1" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p2 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_2" value="1" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p3 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_3" value="1" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p4 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_4" value="1" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_p5 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n1_5" value="1" min="0" max="1" onchange="calculateTotal('n1')">
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $proses->header_parameter_verifikasi }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control text-center" name="total_n2" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_v1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n2_1" value="1" min="0" max="1" onchange="calculateTotal('n2')">
                                                    </td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <td><strong>{{ $proses->header_parameter_penutup }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control text-center" name="total_n3" readonly="readonly" style="font-weight: bold;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_sp1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n3_1" value="1" min="0" max="1" onchange="calculateTotal('n3')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $proses->detail_sp2 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-center detail-input" name="detail_n3_2" value="1" min="0" max="1" onchange="calculateTotal('n3')">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
            <div class="tab-pane fade" id="sikap" role="tabpanel" aria-labelledby="sikap-tab">
                <div class="card">
<div class="card-header">     
<table id='parameter_sikap' class="table table-bordered table-hover"style="width:100%">
<thead>      
<br>
<tr>
<th style="width: 90%">Parameter</th>
<th style="width: 8%">Nilai</th>


</tr>
</thead>
<tbody>

@foreach ($parameterSikap as $sikap)
        <tr>
            <h3>Parameter Sikap</h3>
          
            <td><b>{{ $sikap->header_p1}}</td>
            <td><input type="number" class="form-control" name="total_n4"readonly="readonly"></td>
            <tr>  
            <td>{{ $sikap->detail_1_1}}</td>
            <td><input type="number" class="form-control" name="detail_n4_1"value="1"></td>
            <tr>
            <td>{{ $sikap->detail_1_2}}</td>
            <td><input type="number" class="form-control" name="detail_n4_2"value="1"></td>
            <tr>
            <td>{{ $sikap->detail_1_3}}</td>
            <td><input type="number" class="form-control" name="detail_n4_3"value="1"></td>
            <tr>
            <td><b>{{ $sikap->header_p2}}</td>
            <td><input type="number" class="form-control" name="total_n5"readonly="readonly"></td>
            <tr>
            <td>{{ $sikap->detail_2_1}}</td>
            <td><input type="number" class="form-control" name="detail_n5_1"value="1"></td>
            <tr>
            <td>{{ $sikap->header_p3 }}</td>
            <td><input type="number" class="form-control" name="total_n6"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_3_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n6_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_3_2}}</td>
            <td><input type="number" class="form-control" name="detail_n6_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_3_3}}</td>
            <td><input type="number" class="form-control" name="detail_n6_3"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_3_4 }}</td>
            <td><input type="number" class="form-control" name="detail_n6_4"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p4 }}</td>
            <td><input type="number" class="form-control" name="total_n7"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_4_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n7_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_4_2 }}</td>
            <td><input type="number" class="form-control" name="detail_n7_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_4_3}}</td>
            <td><input type="number" class="form-control" name="detail_n7_3"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p5 }}</td>
            <td><input type="number" class="form-control" name="total_n8"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_5_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_2  }}</td>
            <td><input type="number" class="form-control" name="detail_n8_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_3 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_3"value="1"></td>
            <tr>
      
            <td>{{ $sikap->detail_5_4}}</td>
            <td><input type="number" class="form-control" name="detail_n8_4"value="1"></td>
            <tr>
  
            <td>{{ $sikap->detail_5_5 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_5"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_6 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_6"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_7}}</td>
            <td><input type="number" class="form-control" name="detail_n8_7"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_8 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_8"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_9 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_9"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_5_10 }}</td>
            <td><input type="number" class="form-control" name="detail_n8_10"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p6 }}</td>
            <td><input type="number" class="form-control" name="total_n9"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_6_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_6_2 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_6_3 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_3"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_6_4 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_4"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_6_5 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_5"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_6_6 }}</td>
            <td><input type="number" class="form-control" name="detail_n9_6"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p7 }}</td>
            <td><input type="number" class="form-control" name="total_n10"readonly="readonly"></td>
            <tr>
            
            <td>{{ $sikap->detail_7_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n10_1"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p8 }}</td>
            <td><input type="number" class="form-control" name="total_n11"readonly="readonly"</td>
            <tr>

            <td>{{ $sikap->detail_8_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n11_1"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p9 }}</td>
            <td><input type="number" class="form-control" name="total_n12"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_9_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_2 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_3 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_3"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_4 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_4"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_5 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_5"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_6 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_6"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_9_7 }}</td>
            <td><input type="number" class="form-control" name="detail_n12_7"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p10 }}</td>
            <td><input type="number" class="form-control" name="total_n13"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_10_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n13_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_10_2 }}</td>
            <td><input type="number" class="form-control" name="detail_n13_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_10_3 }}</td>
            <td><input type="number" class="form-control" name="detail_n13_3"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_10_4 }}</td>
            <td><input type="number" class="form-control" name="detail_n13_4"value="1"></td>
            <tr>

            <td><b>{{ $sikap->header_p11 }}</td>
            <td><input type="number" class="form-control" name="total_n14"readonly="readonly"></td>
            <tr>

            <td>{{ $sikap->detail_11_1 }}</td>
            <td><input type="number" class="form-control" name="detail_n14_1"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_11_2 }}</td>
            <td><input type="number" class="form-control" name="detail_n14_2"value="1"></td>
            <tr>

            <td>{{ $sikap->detail_11_3 }}</td>
            <td><input type="number" class="form-control" name="detail_n14_3"value="1"></td>
            <tr>
        </tr>

       
        @endforeach
    </table>
</div>
</div>

            </div>
            <div class="tab-pane fade" id="solusi" role="tabpanel" aria-labelledby="solusi-tab">
            <div class="card">
<div class="card-header">     
<table id='parameterqm' class="table table-bordered table-hover"style="width:100%">
<thead>      
<br>
<tr>
<th style="width: 90%">Parameter</th>
<th style="width: 8%">Nilai</th>


</tr>
</thead>
<tbody>

@foreach ($parameterSolusi as $solusi)
        <tr>
            <h3> Parameter Solusi </h3>
       
            <td><b>{{ $solusi->header_p1}}</td>
            <td><input type="number" class="form-control" name="total_n15" readonly="readonly"></td>
            <tr>  
            <td>{{ $solusi->detail_p1}}</td>
            <td><input type="number" class="form-control" name="detail_n15_1"value="1"></td>
            <tr>
            <td><b>{{ $solusi->header_p2}}</td>
            <td><input type="number" class="form-control" name="total_n16"readonly="readonly"></td>
            <tr>
            <td>{{ $solusi->detail_p2_1}}</td>
            <td><input type="number" class="form-control" name="detail_n16_1"value="1"></td>
            <tr>
            <td>{{ $solusi->detail_p2_2}}</td>
            <td><input type="number" class="form-control" name="detail_n16_2"value="1"></td>
            <tr>
            <td>{{ $solusi->detail_p2_3}}</td>
            <td><input type="number" class="form-control" name="detail_n16_3"value="1"></td>
            <tr>
            <td>{{ $solusi->detail_p2_4 }}</td>
            <td><input type="number" class="form-control" name="detail_n16_4"value="1"></td>
            <tr>
        </tr>
   
       
        @endforeach
    </table>
    
</div>
</div>
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
                            <i class="ti-save"></i> Simpan Penilaian
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
    // Fungsi untuk menghitung total berdasarkan parameter
    function calculateTotal(parameter) {
        let total = 0;
        let allOnes = true;
        
        if (parameter === 'n1') {
            // Parameter Proses - Pembuka
            for (let i = 1; i <= 5; i++) {
                let value = parseInt(document.querySelector(`input[name="detail_n1_${i}"]`).value);
                if (isNaN(value) || value !== 1) {
                    allOnes = false;
                    break;
                }
            }
            if (allOnes) {
                total = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
            }
            document.querySelector('input[name="total_n1"]').value = total;
        } else if (parameter === 'n2') {
            // Parameter Proses - Verifikasi
            let value = parseInt(document.querySelector('input[name="detail_n2_1"]').value);
            if (value === 1) {
                total = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
            }
            document.querySelector('input[name="total_n2"]').value = total;
        } else if (parameter === 'n3') {
            // Parameter Proses - Penutup
            let detail1 = parseInt(document.querySelector('input[name="detail_n3_1"]').value);
            let detail2 = parseInt(document.querySelector('input[name="detail_n3_2"]').value);
            if (detail1 === 1 && detail2 === 1) {
                total = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
            }
            document.querySelector('input[name="total_n3"]').value = total;
        }
    }

    // Event listener untuk dropdown user
    document.getElementById('user_id_dropdown').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var site = selectedOption.getAttribute('data-site');
        var loginId = selectedOption.getAttribute('data-login');
        var perner = selectedOption.getAttribute('data-perner');
        
        document.getElementById('site_input').value = site || '';
        document.getElementById('login_id_input').value = loginId || '';
        document.getElementById('perner_input').value = perner || '';
    });

    // Set initial values
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial values for totals
        let bobot_proses = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
        let bobot_verifikasi = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
        let bobot_penutup = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
        
        document.querySelector('input[name="total_n1"]').value = bobot_proses;
        document.querySelector('input[name="total_n2"]').value = bobot_verifikasi;
        document.querySelector('input[name="total_n3"]').value = bobot_penutup;
        
        // Set initial values for user profile
        var initialAgent = document.getElementById('user_id_dropdown').options[document.getElementById('user_id_dropdown').selectedIndex];
        if (initialAgent) {
            var initialSite = initialAgent.getAttribute('data-site');
            var initialLoginId = initialAgent.getAttribute('data-login');
            var initialPerner = initialAgent.getAttribute('data-perner');
            
            document.getElementById('site_input').value = initialSite || '';
            document.getElementById('login_id_input').value = initialLoginId || '';
            document.getElementById('perner_input').value = initialPerner || '';
        }
    });

    // File upload handling
    const fileInput = document.getElementById('file');
    const progressBar = document.getElementById('progressBar');
    const audioPlayer = document.getElementById('audioPlayer');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const objectURL = URL.createObjectURL(file);
            audioPlayer.src = objectURL;
            audioPlayer.style.display = 'block';
        }
    });

    audioPlayer.addEventListener('timeupdate', function() {
        const percentage = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.value = percentage;
    });
</script>
@endpush
<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n13_')) {
            let detail_n13_1 = parseInt(document.querySelector('input[name="detail_n13_1"]').value);
            let detail_n13_2 = parseInt(document.querySelector('input[name="detail_n13_2"]').value);
            let detail_n13_3 = parseInt(document.querySelector('input[name="detail_n13_3"]').value);
            let detail_n13_4 = parseInt(document.querySelector('input[name="detail_n13_4"]').value);
           
            let total_n13 = 0;
            if (detail_n13_1 === 1 && detail_n13_2 === 1 && detail_n13_3 === 1 && detail_n13_4 === 1 ) {
                let bobot_p10 = parseInt("{{ $parameterSikap->first()->bobot_p10 ?? 0 }}");
                if (!isNaN(bobot_p10)) {
                    total_n13 = bobot_p10;
                }
            }
            document.querySelector('input[name="total_n13"]').value = total_n13;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n14_')) {
            let detail_n14_1 = parseInt(document.querySelector('input[name="detail_n14_1"]').value);
            let detail_n14_2 = parseInt(document.querySelector('input[name="detail_n14_2"]').value);
            let detail_n14_3 = parseInt(document.querySelector('input[name="detail_n14_3"]').value);
           
            let total_n14 = 0;
            if (detail_n14_1 === 1 && detail_n14_2 === 1 && detail_n14_3 === 1 ) {
                let bobot_p11 = parseInt("{{ $parameterSikap->first()->bobot_p11 ?? 0 }}");
                if (!isNaN(bobot_p11)) {
                    total_n14 = bobot_p11;
                }
            }
            document.querySelector('input[name="total_n14"]').value = total_n14;
        }
    });
</script>
<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n15_')) {
            let detail_n15_1 = parseInt(document.querySelector('input[name="detail_n15_1"]').value);
            
           
            let total_n15 = 0;
            if (detail_n15_1 === 1  ) {
                let bobot_p1 = parseInt("{{ $parameterSolusi->first()->bobot_p1 ?? 0 }}");
                if (!isNaN(bobot_p1)) {
                    total_n15 = bobot_p1;
                }
            }
            document.querySelector('input[name="total_n15"]').value = total_n15;
        }
    });
</script>
<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n16_')) {
            let detail_n16_1 = parseInt(document.querySelector('input[name="detail_n16_1"]').value);
            let detail_n16_2 = parseInt(document.querySelector('input[name="detail_n16_2"]').value);
            let detail_n16_3 = parseInt(document.querySelector('input[name="detail_n16_3"]').value);
            let detail_n16_4 = parseInt(document.querySelector('input[name="detail_n16_4"]').value);
           
            let total_n16 = 0;
            if (detail_n16_1 === 1 && detail_n16_2 === 1 && detail_n16_3 === 1 && detail_n16_4 === 1) {
                let bobot_p2 = parseInt("{{ $parameterSolusi->first()->bobot_p2 ?? 0 }}");
                if (!isNaN(bobot_p2)) {
                    total_n16 = bobot_p2;
                }
            }
            document.querySelector('input[name="total_n16"]').value = total_n16;
        }
    });
</script>


<script>
    // Set default nilai bobot saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Parameter Proses
        document.querySelector('input[name="total_n1"]').value = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
        document.querySelector('input[name="total_n2"]').value = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
        document.querySelector('input[name="total_n3"]').value = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
        
        // Parameter Sikap
        document.querySelector('input[name="total_n4"]').value = parseInt("{{ $parameterSikap->first()->bobot_p1 ?? 0 }}");
        document.querySelector('input[name="total_n5"]').value = parseInt("{{ $parameterSikap->first()->bobot_p2 ?? 0 }}");
        document.querySelector('input[name="total_n6"]').value = parseInt("{{ $parameterSikap->first()->bobot_p3 ?? 0 }}");
        document.querySelector('input[name="total_n7"]').value = parseInt("{{ $parameterSikap->first()->bobot_p4 ?? 0 }}");
        document.querySelector('input[name="total_n8"]').value = parseInt("{{ $parameterSikap->first()->bobot_p5 ?? 0 }}");
        document.querySelector('input[name="total_n9"]').value = parseInt("{{ $parameterSikap->first()->bobot_p6 ?? 0 }}");
        document.querySelector('input[name="total_n10"]').value = parseInt("{{ $parameterSikap->first()->bobot_p7 ?? 0 }}");
        document.querySelector('input[name="total_n11"]').value = parseInt("{{ $parameterSikap->first()->bobot_p8 ?? 0 }}");
        document.querySelector('input[name="total_n12"]').value = parseInt("{{ $parameterSikap->first()->bobot_p9 ?? 0 }}");
        document.querySelector('input[name="total_n13"]').value = parseInt("{{ $parameterSikap->first()->bobot_p10 ?? 0 }}");
        document.querySelector('input[name="total_n14"]').value = parseInt("{{ $parameterSikap->first()->bobot_p11 ?? 0 }}");
        
        // Parameter Solusi
        document.querySelector('input[name="total_n15"]').value = parseInt("{{ $parameterSolusi->first()->bobot_p1 ?? 0 }}");
        document.querySelector('input[name="total_n16"]').value = parseInt("{{ $parameterSolusi->first()->bobot_p2 ?? 0 }}");
    });
</script>

<script>
    // Event listener untuk parameter proses
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n1_')) {
            let detail_n1_1 = parseInt(document.querySelector('input[name="detail_n1_1"]').value);
            let detail_n1_2 = parseInt(document.querySelector('input[name="detail_n1_2"]').value);
            let detail_n1_3 = parseInt(document.querySelector('input[name="detail_n1_3"]').value);
            let detail_n1_4 = parseInt(document.querySelector('input[name="detail_n1_4"]').value);
            let detail_n1_5 = parseInt(document.querySelector('input[name="detail_n1_5"]').value);
           
            let total_n1 = 0;
            if (detail_n1_1 === 1 && detail_n1_2 === 1 && detail_n1_3 === 1 && detail_n1_4 === 1 && detail_n1_5 === 1) {
                let bobot_proses = parseInt("{{ $parameterProses->first()->bobot_proses ?? 0 }}");
                if (!isNaN(bobot_proses)) {
                    total_n1 = bobot_proses;
                }
            }
            document.querySelector('input[name="total_n1"]').value = total_n1;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n2_')) {
            let detail_n2_1 = parseInt(document.querySelector('input[name="detail_n2_1"]').value);
           
            let total_n2 = 0;
            if (detail_n2_1 === 1) {
                let bobot_verifikasi = parseInt("{{ $parameterProses->first()->bobot_verifikasi ?? 0 }}");
                if (!isNaN(bobot_verifikasi)) {
                    total_n2 = bobot_verifikasi;
                }
            }
            document.querySelector('input[name="total_n2"]').value = total_n2;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n3_')) {
            let detail_n3_1 = parseInt(document.querySelector('input[name="detail_n3_1"]').value);
            let detail_n3_2 = parseInt(document.querySelector('input[name="detail_n3_2"]').value);
           
            let total_n3 = 0;
            if (detail_n3_1 === 1 && detail_n3_2 === 1) {
                let bobot_penutup = parseInt("{{ $parameterProses->first()->bobot_penutup ?? 0 }}");
                if (!isNaN(bobot_penutup)) {
                    total_n3 = bobot_penutup;
                }
            }
            document.querySelector('input[name="total_n3"]').value = total_n3;
        }
    });

    // Event listener untuk parameter sikap
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n4_')) {
            let detail_n4_1 = parseInt(document.querySelector('input[name="detail_n4_1"]').value);
            let detail_n4_2 = parseInt(document.querySelector('input[name="detail_n4_2"]').value);
            let detail_n4_3 = parseInt(document.querySelector('input[name="detail_n4_3"]').value);
           
            let total_n4 = 0;
            if (detail_n4_1 === 1 && detail_n4_2 === 1 && detail_n4_3 === 1) {
                let bobot_p1 = parseInt("{{ $parameterSikap->first()->bobot_p1 ?? 0 }}");
                if (!isNaN(bobot_p1)) {
                    total_n4 = bobot_p1;
                }
            }
            document.querySelector('input[name="total_n4"]').value = total_n4;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n5_')) {
            let detail_n5_1 = parseInt(document.querySelector('input[name="detail_n5_1"]').value);
           
            let total_n5 = 0;
            if (detail_n5_1 === 1) {
                let bobot_p2 = parseInt("{{ $parameterSikap->first()->bobot_p2 ?? 0 }}");
                if (!isNaN(bobot_p2)) {
                    total_n5 = bobot_p2;
                }
            }
            document.querySelector('input[name="total_n5"]').value = total_n5;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n6_')) {
            let detail_n6_1 = parseInt(document.querySelector('input[name="detail_n6_1"]').value);
            let detail_n6_2 = parseInt(document.querySelector('input[name="detail_n6_2"]').value);
            let detail_n6_3 = parseInt(document.querySelector('input[name="detail_n6_3"]').value);
            let detail_n6_4 = parseInt(document.querySelector('input[name="detail_n6_4"]').value);
           
            let total_n6 = 0;
            if (detail_n6_1 === 1 && detail_n6_2 === 1 && detail_n6_3 === 1 && detail_n6_4 === 1) {
                let bobot_p3 = parseInt("{{ $parameterSikap->first()->bobot_p3 ?? 0 }}");
                if (!isNaN(bobot_p3)) {
                    total_n6 = bobot_p3;
                }
            }
            document.querySelector('input[name="total_n6"]').value = total_n6;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n7_')) {
            let detail_n7_1 = parseInt(document.querySelector('input[name="detail_n7_1"]').value);
            let detail_n7_2 = parseInt(document.querySelector('input[name="detail_n7_2"]').value);
            let detail_n7_3 = parseInt(document.querySelector('input[name="detail_n7_3"]').value);
           
            let total_n7 = 0;
            if (detail_n7_1 === 1 && detail_n7_2 === 1 && detail_n7_3 === 1) {
                let bobot_p4 = parseInt("{{ $parameterSikap->first()->bobot_p4 ?? 0 }}");
                if (!isNaN(bobot_p4)) {
                    total_n7 = bobot_p4;
                }
            }
            document.querySelector('input[name="total_n7"]').value = total_n7;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n8_')) {
            let detail_n8_1 = parseInt(document.querySelector('input[name="detail_n8_1"]').value);
            let detail_n8_2 = parseInt(document.querySelector('input[name="detail_n8_2"]').value);
            let detail_n8_3 = parseInt(document.querySelector('input[name="detail_n8_3"]').value);
            let detail_n8_4 = parseInt(document.querySelector('input[name="detail_n8_4"]').value);
            let detail_n8_5 = parseInt(document.querySelector('input[name="detail_n8_5"]').value);
            let detail_n8_6 = parseInt(document.querySelector('input[name="detail_n8_6"]').value);
            let detail_n8_7 = parseInt(document.querySelector('input[name="detail_n8_7"]').value);
            let detail_n8_8 = parseInt(document.querySelector('input[name="detail_n8_8"]').value);
            let detail_n8_9 = parseInt(document.querySelector('input[name="detail_n8_9"]').value);
            let detail_n8_10 = parseInt(document.querySelector('input[name="detail_n8_10"]').value);
           
            let total_n8 = 0;
            if (detail_n8_1 === 1 && detail_n8_2 === 1 && detail_n8_3 === 1 && detail_n8_4 === 1 && 
                detail_n8_5 === 1 && detail_n8_6 === 1 && detail_n8_7 === 1 && detail_n8_8 === 1 && 
                detail_n8_9 === 1 && detail_n8_10 === 1) {
                let bobot_p5 = parseInt("{{ $parameterSikap->first()->bobot_p5 ?? 0 }}");
                if (!isNaN(bobot_p5)) {
                    total_n8 = bobot_p5;
                }
            }
            document.querySelector('input[name="total_n8"]').value = total_n8;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n9_')) {
            let detail_n9_1 = parseInt(document.querySelector('input[name="detail_n9_1"]').value);
            let detail_n9_2 = parseInt(document.querySelector('input[name="detail_n9_2"]').value);
            let detail_n9_3 = parseInt(document.querySelector('input[name="detail_n9_3"]').value);
            let detail_n9_4 = parseInt(document.querySelector('input[name="detail_n9_4"]').value);
            let detail_n9_5 = parseInt(document.querySelector('input[name="detail_n9_5"]').value);
            let detail_n9_6 = parseInt(document.querySelector('input[name="detail_n9_6"]').value);
           
            let total_n9 = 0;
            if (detail_n9_1 === 1 && detail_n9_2 === 1 && detail_n9_3 === 1 && detail_n9_4 === 1 && 
                detail_n9_5 === 1 && detail_n9_6 === 1) {
                let bobot_p6 = parseInt("{{ $parameterSikap->first()->bobot_p6 ?? 0 }}");
                if (!isNaN(bobot_p6)) {
                    total_n9 = bobot_p6;
                }
            }
            document.querySelector('input[name="total_n9"]').value = total_n9;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n10_')) {
            let detail_n10_1 = parseInt(document.querySelector('input[name="detail_n10_1"]').value);
           
            let total_n10 = 0;
            if (detail_n10_1 === 1) {
                let bobot_p7 = parseInt("{{ $parameterSikap->first()->bobot_p7 ?? 0 }}");
                if (!isNaN(bobot_p7)) {
                    total_n10 = bobot_p7;
                }
            }
            document.querySelector('input[name="total_n10"]').value = total_n10;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n11_')) {
            let detail_n11_1 = parseInt(document.querySelector('input[name="detail_n11_1"]').value);
           
            let total_n11 = 0;
            if (detail_n11_1 === 1) {
                let bobot_p8 = parseInt("{{ $parameterSikap->first()->bobot_p8 ?? 0 }}");
                if (!isNaN(bobot_p8)) {
                    total_n11 = bobot_p8;
                }
            }
            document.querySelector('input[name="total_n11"]').value = total_n11;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target && e.target.name.startsWith('detail_n12_')) {
            let detail_n12_1 = parseInt(document.querySelector('input[name="detail_n12_1"]').value);
            let detail_n12_2 = parseInt(document.querySelector('input[name="detail_n12_2"]').value);
            let detail_n12_3 = parseInt(document.querySelector('input[name="detail_n12_3"]').value);
            let detail_n12_4 = parseInt(document.querySelector('input[name="detail_n12_4"]').value);
            let detail_n12_5 = parseInt(document.querySelector('input[name="detail_n12_5"]').value);
            let detail_n12_6 = parseInt(document.querySelector('input[name="detail_n12_6"]').value);
            let detail_n12_7 = parseInt(document.querySelector('input[name="detail_n12_7"]').value);
           
            let total_n12 = 0;
            if (detail_n12_1 === 1 && detail_n12_2 === 1 && detail_n12_3 === 1 && detail_n12_4 === 1 && 
                detail_n12_5 === 1 && detail_n12_6 === 1 && detail_n12_7 === 1) {
                let bobot_p9 = parseInt("{{ $parameterSikap->first()->bobot_p9 ?? 0 }}");
                if (!isNaN(bobot_p9)) {
                    total_n12 = bobot_p9;
                }
            }
            document.querySelector('input[name="total_n12"]').value = total_n12;
        }
    });
</script>

<script>
    const fileInput = document.getElementById('file');
    const progressBar = document.getElementById('progressBar');
    const audioPlayer = document.getElementById('audioPlayer');
    const playButton = document.getElementById('playButton');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        const objectURL = URL.createObjectURL(file);
        audioPlayer.src = objectURL;
        audioPlayer.style.display = 'block';
    });

    playButton.addEventListener('click', function() {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playButton.textContent = 'Pause';
        } else {
            audioPlayer.pause();
            playButton.textContent = 'Play';
        }
    });

    audioPlayer.addEventListener('timeupdate', function() {
        const percentage = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.value = percentage;
    });
</script>


<script>
    document.getElementById('user_id_dropdown').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var site = selectedOption.getAttribute('data-site');
        var loginId = selectedOption.getAttribute('data-login');
        var perner = selectedOption.getAttribute('data-perner'); // Ambil data perner
        var userId = selectedOption.textContent; // Menggunakan textContent untuk mendapatkan user_id
        document.getElementById('site_input').value = site;
        document.getElementById('login_id_input').value = loginId;
        document.getElementById('perner_input').value = perner; // Set nilai perner
        document.getElementById('user_id_input').value = userId; // Menambahkan user_id ke input field
    });

    // Set initial values for site, login id, perner, and user id based on the default selected agent
    var initialAgent = document.getElementById('user_id_dropdown').options[document.getElementById('user_id_dropdown').selectedIndex];
    var initialSite = initialAgent.getAttribute('data-site');
    var initialLoginId = initialAgent.getAttribute('data-login');
    var initialPerner = initialAgent.getAttribute('data-perner'); // Ambil data perner awal
    var initialUserId = initialAgent.textContent; // Menggunakan textContent untuk mendapatkan user_id
    document.getElementById('site_input').value = initialSite;
    document.getElementById('login_id_input').value = initialLoginId;
    document.getElementById('perner_input').value = initialPerner; // Set nilai perner awal
    document.getElementById('user_id_input').value = initialUserId; // Menambahkan user_id ke input field

</script>

@endsection
