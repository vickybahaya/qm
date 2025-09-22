@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Detail Parameter {{ ucfirst($type) }}</h4>
                <div>
                    @can('update parameter-qm')
                        <a href="{{ route('parameter-qm.edit', [$type, $parameter->id]) }}" class="btn btn-warning btn-sm">
                            <i class="ti-pencil"></i> Edit
                        </a>
                    @endcan
                    <a href="{{ route('parameter-qm.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Parameter {{ ucfirst($type) }}</h5>
                </div>
                <div class="card-body">
                    @if($type == 'proses')
                        <!-- Parameter Proses -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Parameter Pembuka</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Header Parameter Pembuka:</label>
                                    <p class="form-control-plaintext">{{ $parameter->header_parameter_pembuka }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bobot Proses:</label>
                                    <p class="form-control-plaintext">{{ $parameter->bobot_proses }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail P1:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_p1 }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail P2:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_p2 }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail P3:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_p3 }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail P4:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_p4 }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail P5:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_p5 }}</p>
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
                                    <label class="form-label fw-bold">Header Parameter Verifikasi:</label>
                                    <p class="form-control-plaintext">{{ $parameter->header_parameter_verifikasi }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bobot Verifikasi:</label>
                                    <p class="form-control-plaintext">{{ $parameter->bobot_verifikasi }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail V1:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_v1 }}</p>
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
                                    <label class="form-label fw-bold">Header Parameter Penutup:</label>
                                    <p class="form-control-plaintext">{{ $parameter->header_parameter_penutup }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bobot Penutup:</label>
                                    <p class="form-control-plaintext">{{ $parameter->bobot_penutup }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail SP1:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_sp1 }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail SP2:</label>
                                    <p class="form-control-plaintext">{{ $parameter->detail_sp2 }}</p>
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
                                        <label class="form-label fw-bold">Header P{{ $i }}:</label>
                                        <p class="form-control-plaintext">{{ $parameter->{'header_p' . $i} }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Bobot P{{ $i }}:</label>
                                        <p class="form-control-plaintext">{{ $parameter->{'bobot_p' . $i} }}</p>
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
                                            <label class="form-label fw-bold">Detail {{ $detail }}:</label>
                                            <p class="form-control-plaintext">{{ $parameter->{'detail_' . $detail} }}</p>
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
                                        <label class="form-label fw-bold">Header P{{ $i }}:</label>
                                        <p class="form-control-plaintext">{{ $parameter->{'header_p' . $i} }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Bobot P{{ $i }}:</label>
                                        <p class="form-control-plaintext">{{ $parameter->{'bobot_p' . $i} }}</p>
                                    </div>
                                </div>
                                @if($i == 1)
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail P1:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_p1 }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail 1_2:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_1_2 }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail P2_1:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_p2_1 }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail P2_2:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_p2_2 }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail P2_3:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_p2_3 }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Detail P2_4:</label>
                                            <p class="form-control-plaintext">{{ $parameter->detail_p2_4 }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($i < 2) <hr> @endif
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
