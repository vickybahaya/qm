
@extends('layouts.administrator.master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="fw-bold">Parameter Quality Management</h3>
            <p class="text-muted">Akses dan kelola parameter Proses, Sikap, dan Solusi untuk Quality Management</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <b>Parameter</b>
                </div>
                <div class="card-body p-2">
                    <!-- Tombol Create dihapus sesuai permintaan -->
                    <div class="table-responsive">
                        @forelse($proses as $row)
                        <form action="{{ route('parameter-proses.update', $row->id) }}" method="POST" class="border rounded mb-3 p-3 bg-light">
                            @csrf
                            @method('PUT')
                            <div class="table-responsive">
                                <ul class="nav nav-tabs mb-3" id="parameterTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="proses-tab" data-bs-toggle="tab" data-bs-target="#proses" type="button" role="tab" aria-controls="proses" aria-selected="true">Proses</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sikap-tab" data-bs-toggle="tab" data-bs-target="#sikap" type="button" role="tab" aria-controls="sikap" aria-selected="false">Sikap</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="solusi-tab" data-bs-toggle="tab" data-bs-target="#solusi" type="button" role="tab" aria-controls="solusi" aria-selected="false">Solusi</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="parameterTabContent">
                                    <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                                        <div class="table-responsive">
                                            @forelse($proses as $row)
                                            <form action="{{ route('parameter-proses.update', $row->id) }}" method="POST" class="border rounded mb-3 p-3 bg-light">
                                                @csrf
                                                @method('PUT')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:40%">Parameter</th>
                                                                <th>Nilai</th>
                                                                <th style="width:5%; min-width:60px;">Bobot</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="header_parameter_pembuka" class="form-control form-control-sm" value="{{ $row->header_parameter_pembuka }}" disabled></td>
                                                                <td>
                                                                    <input type="number" step="any" name="bobot_proses" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_proses }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_p1" class="form-control form-control-sm" value="{{ $row->detail_p1 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_p2" class="form-control form-control-sm" value="{{ $row->detail_p2 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_p3" class="form-control form-control-sm" value="{{ $row->detail_p3 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_p4" class="form-control form-control-sm" value="{{ $row->detail_p4 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_p5" class="form-control form-control-sm" value="{{ $row->detail_p5 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_parameter_verifikasi" class="form-control form-control-sm" value="{{ $row->header_parameter_verifikasi }}" disabled></td>
                                                                <td>
                                                                    <input type="number" step="any" name="bobot_verifikasi" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_verifikasi }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_v1" class="form-control form-control-sm" value="{{ $row->detail_v1 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_parameter_penutup" class="form-control form-control-sm" value="{{ $row->header_parameter_penutup }}" disabled></td>
                                                                <td>
                                                                    <input type="number" step="any" name="bobot_penutup" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_penutup }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_sp1" class="form-control form-control-sm" value="{{ $row->detail_sp1 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="detail_sp2" class="form-control form-control-sm" value="{{ $row->detail_sp2 }}"></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-2 text-center">
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Simpan</button>
                                                </div>
                                            </form>
                                            @empty
                                            <div class="text-center text-muted">Tidak ada data</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sikap" role="tabpanel" aria-labelledby="sikap-tab">
                                        <div class="table-responsive">
                                            @forelse($sikap as $row)
                                            <form action="{{ route('parameter-sikap.update', $row->id) }}" method="POST" class="border rounded mb-3 p-3 bg-light">
                                                @csrf
                                                @method('PUT')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:40%">Parameter</th>
                                                                <th>Nilai</th>
                                                                <th style="width:5%; min-width:60px;">Bobot</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="header_p1" class="form-control form-control-sm" value="{{ $row->header_p1 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p1" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p1 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_1_1" class="form-control form-control-sm" value="{{ $row->detail_1_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_1_2" class="form-control form-control-sm" value="{{ $row->detail_1_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_1_3" class="form-control form-control-sm" value="{{ $row->detail_1_3 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p2" class="form-control form-control-sm" value="{{ $row->header_p2 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p2" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p2 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_2_1" class="form-control form-control-sm" value="{{ $row->detail_2_1 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p3" class="form-control form-control-sm" value="{{ $row->header_p3 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p3" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p3 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_3_1" class="form-control form-control-sm" value="{{ $row->detail_3_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_3_2" class="form-control form-control-sm" value="{{ $row->detail_3_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_3_3" class="form-control form-control-sm" value="{{ $row->detail_3_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_3_4" class="form-control form-control-sm" value="{{ $row->detail_3_4 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p4" class="form-control form-control-sm" value="{{ $row->header_p4 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p4" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p4 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_4_1" class="form-control form-control-sm" value="{{ $row->detail_4_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_4_2" class="form-control form-control-sm" value="{{ $row->detail_4_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_4_3" class="form-control form-control-sm" value="{{ $row->detail_4_3 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p5" class="form-control form-control-sm" value="{{ $row->header_p5 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p5" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p5 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_1" class="form-control form-control-sm" value="{{ $row->detail_5_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_2" class="form-control form-control-sm" value="{{ $row->detail_5_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_3" class="form-control form-control-sm" value="{{ $row->detail_5_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_4" class="form-control form-control-sm" value="{{ $row->detail_5_4 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_5" class="form-control form-control-sm" value="{{ $row->detail_5_5 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_6" class="form-control form-control-sm" value="{{ $row->detail_5_6 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_7" class="form-control form-control-sm" value="{{ $row->detail_5_7 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_8" class="form-control form-control-sm" value="{{ $row->detail_5_8 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_9" class="form-control form-control-sm" value="{{ $row->detail_5_9 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_5_10" class="form-control form-control-sm" value="{{ $row->detail_5_10 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p6" class="form-control form-control-sm" value="{{ $row->header_p6 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p6" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p6 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_6_1" class="form-control form-control-sm" value="{{ $row->detail_6_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_6_2" class="form-control form-control-sm" value="{{ $row->detail_6_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_6_3" class="form-control form-control-sm" value="{{ $row->detail_6_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_6_4" class="form-control form-control-sm" value="{{ $row->detail_6_4 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_6_5" class="form-control form-control-sm" value="{{ $row->detail_6_5 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p7" class="form-control form-control-sm" value="{{ $row->header_p7 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p7" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p7 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_7_1" class="form-control form-control-sm" value="{{ $row->detail_7_1 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p8" class="form-control form-control-sm" value="{{ $row->header_p8 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p8" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p8 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_8_1" class="form-control form-control-sm" value="{{ $row->detail_8_1 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p9" class="form-control form-control-sm" value="{{ $row->header_p9 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p9" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p9 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_1" class="form-control form-control-sm" value="{{ $row->detail_9_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_2" class="form-control form-control-sm" value="{{ $row->detail_9_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_3" class="form-control form-control-sm" value="{{ $row->detail_9_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_4" class="form-control form-control-sm" value="{{ $row->detail_9_4 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_5" class="form-control form-control-sm" value="{{ $row->detail_9_5 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_6" class="form-control form-control-sm" value="{{ $row->detail_9_6 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_9_7" class="form-control form-control-sm" value="{{ $row->detail_9_7 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p10" class="form-control form-control-sm" value="{{ $row->header_p10 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p10" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p10 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_10_1" class="form-control form-control-sm" value="{{ $row->detail_10_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_10_2" class="form-control form-control-sm" value="{{ $row->detail_10_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_10_3" class="form-control form-control-sm" value="{{ $row->detail_10_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_10_4" class="form-control form-control-sm" value="{{ $row->detail_10_4 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p11" class="form-control form-control-sm" value="{{ $row->header_p11 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p11" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p11 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_11_1" class="form-control form-control-sm" value="{{ $row->detail_11_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_11_2" class="form-control form-control-sm" value="{{ $row->detail_11_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_11_3" class="form-control form-control-sm" value="{{ $row->detail_11_3 }}"></td><td></td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Simpan</button>
                                                </div>
                                            </form>
                                            @empty
                                            <div class="text-center text-muted">Tidak ada data</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="solusi" role="tabpanel" aria-labelledby="solusi-tab">
                                        <div class="table-responsive">
                                            @forelse($solusi as $row)
                                            <form action="{{ route('parameter-solusi.update', $row->id) }}" method="POST" class="border rounded mb-3 p-3 bg-light">
                                                @csrf
                                                @method('PUT')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:40%">Parameter</th>
                                                                <th>Nilai</th>
                                                                <th style="width:5%; min-width:60px;">Bobot</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="2"><input type="text" name="header_p1" class="form-control form-control-sm" value="{{ $row->header_p1 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p1" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p1 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_p1" class="form-control form-control-sm" value="{{ $row->detail_p1 }}"></td><td></td></tr>
                                                            <tr class="table-secondary">
                                                                <td colspan="2"><input type="text" name="header_p2" class="form-control form-control-sm" value="{{ $row->header_p2 }}" disabled></td>
                                                                <td><input type="number" step="any" name="bobot_p2" class="form-control form-control-sm" style="max-width:70px; min-width:50px;" value="{{ $row->bobot_p2 }}"></td>
                                                            </tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_p2_1" class="form-control form-control-sm" value="{{ $row->detail_p2_1 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_p2_2" class="form-control form-control-sm" value="{{ $row->detail_p2_2 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_p2_3" class="form-control form-control-sm" value="{{ $row->detail_p2_3 }}"></td><td></td></tr>
                                                            <tr><td colspan="2"><input type="text" name="detail_p2_4" class="form-control form-control-sm" value="{{ $row->detail_p2_4 }}"></td><td></td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Simpan</button>
                                                </div>
                                            </form>
                                            @empty
                                            <div class="text-center text-muted">Tidak ada data</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                        @empty
                        <div class="text-center text-muted">Tidak ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function() {
        $('#datatable-proses').DataTable();
        $('#datatable-sikap').DataTable();
        $('#datatable-solusi').DataTable();
    });
</script>
@endpush
@endsection
