@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Tambah Parameter {{ ucfirst($type) }}</h4>
                <a href="{{ route('parameter-qm.index') }}" class="btn btn-secondary btn-sm">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Parameter {{ ucfirst($type) }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('parameter-qm.store', $type) }}" method="POST">
                        @csrf
                        
                        @if($type == 'proses')
                            <!-- Parameter Proses -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="fw-bold">Parameter Pembuka</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="header_parameter_pembuka" class="form-label">Header Parameter Pembuka</label>
                                        <input type="text" class="form-control" id="header_parameter_pembuka" name="header_parameter_pembuka" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bobot_proses" class="form-label">Bobot Proses</label>
                                        <input type="number" step="0.01" class="form-control" id="bobot_proses" name="bobot_proses" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_p1" class="form-label">Detail P1</label>
                                        <textarea class="form-control" id="detail_p1" name="detail_p1" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_p2" class="form-label">Detail P2</label>
                                        <textarea class="form-control" id="detail_p2" name="detail_p2" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_p3" class="form-label">Detail P3</label>
                                        <textarea class="form-control" id="detail_p3" name="detail_p3" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_p4" class="form-label">Detail P4</label>
                                        <textarea class="form-control" id="detail_p4" name="detail_p4" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_p5" class="form-label">Detail P5</label>
                                        <textarea class="form-control" id="detail_p5" name="detail_p5" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="fw-bold">Parameter Verifikasi</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="header_parameter_verifikasi" class="form-label">Header Parameter Verifikasi</label>
                                        <input type="text" class="form-control" id="header_parameter_verifikasi" name="header_parameter_verifikasi" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bobot_verifikasi" class="form-label">Bobot Verifikasi</label>
                                        <input type="number" step="0.01" class="form-control" id="bobot_verifikasi" name="bobot_verifikasi" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_v1" class="form-label">Detail V1</label>
                                        <textarea class="form-control" id="detail_v1" name="detail_v1" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="fw-bold">Parameter Penutup</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="header_parameter_penutup" class="form-label">Header Parameter Penutup</label>
                                        <input type="text" class="form-control" id="header_parameter_penutup" name="header_parameter_penutup" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bobot_penutup" class="form-label">Bobot Penutup</label>
                                        <input type="number" step="0.01" class="form-control" id="bobot_penutup" name="bobot_penutup" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_sp1" class="form-label">Detail SP1</label>
                                        <textarea class="form-control" id="detail_sp1" name="detail_sp1" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail_sp2" class="form-label">Detail SP2</label>
                                        <textarea class="form-control" id="detail_sp2" name="detail_sp2" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>

                        @elseif($type == 'sikap')
                            <!-- Parameter Sikap -->
                            @for($i = 1; $i <= 11; $i++)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="fw-bold">Parameter {{ $i }}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="header_p{{ $i }}" class="form-label">Header P{{ $i }}</label>
                                            <input type="text" class="form-control" id="header_p{{ $i }}" name="header_p{{ $i }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bobot_p{{ $i }}" class="form-label">Bobot P{{ $i }}</label>
                                            <input type="number" step="0.01" class="form-control" id="bobot_p{{ $i }}" name="bobot_p{{ $i }}" required>
                                        </div>
                                    </div>
                                    @php
                                        $details = [];
                                        switch($i) {
                                            case 1: $details = ['1_1', '1_2', '1_3']; break;
                                            case 2: $details = ['2_1']; break;
                                            case 3: $details = ['3_1', '3_2', '3_3', '3_4']; break;
                                            case 4: $details = ['4_1', '4_2', '4_3']; break;
                                            case 5: $details = ['5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '5_7', '5_8', '5_9', '5_10']; break;
                                            case 6: $details = ['6_1', '6_2', '6_3', '6_4', '6_5', '6_6']; break;
                                            case 7: $details = ['7_1']; break;
                                            case 8: $details = ['8_1']; break;
                                            case 9: $details = ['9_1', '9_2', '9_3', '9_4', '9_5', '9_6', '9_7']; break;
                                            case 10: $details = ['10_1', '10_2', '10_3', '10_4']; break;
                                            case 11: $details = ['11_1', '11_2', '11_3']; break;
                                        }
                                    @endphp
                                    @foreach($details as $detail)
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_{{ $detail }}" class="form-label">Detail {{ $detail }}</label>
                                                <textarea class="form-control" id="detail_{{ $detail }}" name="detail_{{ $detail }}" rows="2" required></textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($i < 11) <hr> @endif
                            @endfor

                        @elseif($type == 'solusi')
                            <!-- Parameter Solusi -->
                            @for($i = 1; $i <= 2; $i++)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="fw-bold">Parameter {{ $i }}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="header_p{{ $i }}" class="form-label">Header P{{ $i }}</label>
                                            <input type="text" class="form-control" id="header_p{{ $i }}" name="header_p{{ $i }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bobot_p{{ $i }}" class="form-label">Bobot P{{ $i }}</label>
                                            <input type="number" step="0.01" class="form-control" id="bobot_p{{ $i }}" name="bobot_p{{ $i }}" required>
                                        </div>
                                    </div>
                                    @if($i == 1)
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_p1" class="form-label">Detail P1</label>
                                                <textarea class="form-control" id="detail_p1" name="detail_p1" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_1_2" class="form-label">Detail 1_2</label>
                                                <textarea class="form-control" id="detail_1_2" name="detail_1_2" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_p2_1" class="form-label">Detail P2_1</label>
                                                <textarea class="form-control" id="detail_p2_1" name="detail_p2_1" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_p2_2" class="form-label">Detail P2_2</label>
                                                <textarea class="form-control" id="detail_p2_2" name="detail_p2_2" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_p2_3" class="form-label">Detail P2_3</label>
                                                <textarea class="form-control" id="detail_p2_3" name="detail_p2_3" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_p2_4" class="form-label">Detail P2_4</label>
                                                <textarea class="form-control" id="detail_p2_4" name="detail_p2_4" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($i < 2) <hr> @endif
                            @endfor
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-save"></i> Simpan
                                </button>
                                <a href="{{ route('parameter-qm.index') }}" class="btn btn-secondary">
                                    <i class="ti-close"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
