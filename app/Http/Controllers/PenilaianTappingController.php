<?php

namespace App\Http\Controllers;

use App\Models\PenilaianTapping;
use App\Models\User;
use App\Models\ParameterProses;
use App\Models\ParameterSikap;
use App\Models\ParameterSolusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;

class PenilaianTappingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PenilaianTapping::with('user')->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    if (auth()->user()->can('read penilaian-tappings')) {
                        $btn .= '<a href="' . route('penilaian-tappings.show', $row->id) . '" class="btn btn-info btn-sm"><i class="ti-eye"></i></a>';
                    }
                    if (auth()->user()->can('update penilaian-tappings')) {
                        $btn .= '<a href="' . route('penilaian-tappings.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="ti-pencil"></i></a>';
                    }
                    if (auth()->user()->can('delete penilaian-tappings')) {
                        $btn .= '<button type="button" class="btn btn-danger btn-sm deletePenilaian" data-id="' . $row->id . '"><i class="ti-trash"></i></button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        // Group data by user for the peak table
        $penilaianTappings = PenilaianTapping::with('user.profile')->get();
        $penilaianTappingsGrouped = [];
        
        foreach ($penilaianTappings as $penilaian) {
            $userId = $penilaian->name_id; // Use name_id as foreign key
            $userName = $penilaian->user->name ?? 'User ID: ' . $userId;
            $perner = $penilaian->perner ?? '';
            $loginId = $penilaian->login_id ?? '';
            $site = $penilaian->site ?? '';
            
            if (!isset($penilaianTappingsGrouped[$userId])) {
                $penilaianTappingsGrouped[$userId] = [
                    'user_id' => $userId,
                    'periode' => date('Y-m', strtotime($penilaian->tanggal_recording)),
                    'name' => $userName,
                    'perner' => $perner,
                    'login_id' => $loginId,
                    'site' => $site,
                    'peak_1' => 0,
                    'peak_2' => 0,
                    'peak_3' => 0,
                    'total_qm' => 0,
                    'keterangan' => 'TIDAK LULUS'
                ];
            }
            
            // Update peak scores
            if ($penilaian->peak == 1) {
                $penilaianTappingsGrouped[$userId]['peak_1'] = $penilaian->total_peak ?? 0;
            } elseif ($penilaian->peak == 2) {
                $penilaianTappingsGrouped[$userId]['peak_2'] = $penilaian->total_peak ?? 0;
            } elseif ($penilaian->peak == 3) {
                $penilaianTappingsGrouped[$userId]['peak_3'] = $penilaian->total_peak ?? 0;
            }
            
            // Calculate total QM (sum of all peaks)
            $totalPeaks = $penilaianTappingsGrouped[$userId]['peak_1'] + 
                         $penilaianTappingsGrouped[$userId]['peak_2'] + 
                         $penilaianTappingsGrouped[$userId]['peak_3'];
            $penilaianTappingsGrouped[$userId]['total_qm'] = $totalPeaks;
            
            // Update keterangan based on total QM
            if ($totalPeaks >= 95) {
                $penilaianTappingsGrouped[$userId]['keterangan'] = 'LULUS';
            }
        }
        
        return view('penilaian_tappings.index', compact('penilaianTappingsGrouped'));
    }

    public function create()
    {
        $users = User::with('profile')->get();
        $parameterProses = ParameterProses::all();
        $parameterSikap = ParameterSikap::all();
        $parameterSolusi = ParameterSolusi::all();
        
        return view('penilaian_tappings.create', compact('users', 'parameterProses', 'parameterSikap', 'parameterSolusi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_id' => 'required|exists:users,id',
            'peak' => 'required|in:1,2,3',
            'tanggal_recording' => 'required|date',
            'file' => 'required|file|mimes:wav|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/recordings', $filename);
        }

        // Get user profile data
        $user = User::with('profile')->find($request->name_id);
        
        // Calculate totals
        $totalProses = $this->calculateTotalProses($request);
        $totalSikap = $this->calculateTotalSikap($request);
        $totalSolusi = $this->calculateTotalSolusi($request);
        $totalQM = $totalProses + $totalSikap + $totalSolusi;

        $data = $request->all();
        $data['file'] = $filename;
        $data['perner'] = $user->profile->perner ?? '';
        $data['login_id'] = $user->profile->login_id ?? '';
        $data['site'] = $user->profile->site ?? '';
        $data['total_proses'] = $totalProses;
        $data['total_sikap'] = $totalSikap;
        $data['total_solusi'] = $totalSolusi;
        $data['total_qm_p1'] = $totalQM;
        $data['total_qm_p2'] = $totalQM;
        $data['total_qm_p3'] = $totalQM;
        $data['total_peak'] = $totalQM;
        $data['keterangan'] = $totalQM >= 95 ? 'LULUS' : 'TIDAK LULUS';

        PenilaianTapping::create($data);

        return redirect()->route('penilaian-tappings.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function show(PenilaianTapping $penilaianTapping)
    {
        $penilaianTapping->load('user.profile');
        return view('penilaian_tappings.show', compact('penilaianTapping'));
    }

    public function edit(PenilaianTapping $penilaianTapping)
    {
        $users = User::with('profile')->get();
        $parameterProses = ParameterProses::all();
        $parameterSikap = ParameterSikap::all();
        $parameterSolusi = ParameterSolusi::all();
        
        return view('penilaian_tappings.edit', compact('penilaianTapping', 'users', 'parameterProses', 'parameterSikap', 'parameterSolusi'));
    }

    public function update(Request $request, PenilaianTapping $penilaianTapping)
    {
        $request->validate([
            'name_id' => 'required|exists:users,id',
            'peak' => 'required|in:1,2,3',
            'tanggal_recording' => 'required|date',
            'file' => 'nullable|file|mimes:wav|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($penilaianTapping->file) {
                Storage::delete('public/recordings/' . $penilaianTapping->file);
            }
            
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/recordings', $filename);
            $data['file'] = $filename;
        }

        // Get user profile data
        $user = User::with('profile')->find($request->name_id);
        
        // Calculate totals
        $totalProses = $this->calculateTotalProses($request);
        $totalSikap = $this->calculateTotalSikap($request);
        $totalSolusi = $this->calculateTotalSolusi($request);
        $totalQM = $totalProses + $totalSikap + $totalSolusi;

        $data = $request->all();
        $data['perner'] = $user->profile->perner ?? '';
        $data['login_id'] = $user->profile->login_id ?? '';
        $data['site'] = $user->profile->site ?? '';
        $data['total_proses'] = $totalProses;
        $data['total_sikap'] = $totalSikap;
        $data['total_solusi'] = $totalSolusi;
        $data['total_qm_p1'] = $totalQM;
        $data['total_qm_p2'] = $totalQM;
        $data['total_qm_p3'] = $totalQM;
        $data['total_peak'] = $totalQM;
        $data['keterangan'] = $totalQM >= 95 ? 'LULUS' : 'TIDAK LULUS';

        $penilaianTapping->update($data);

        return redirect()->route('penilaian-tappings.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(PenilaianTapping $penilaianTapping)
    {
        // Delete file if exists
        if ($penilaianTapping->file) {
            Storage::delete('public/recordings/' . $penilaianTapping->file);
        }
        
        $penilaianTapping->delete();

        return response()->json(['success' => 'Penilaian berhasil dihapus.']);
    }

    private function calculateTotalProses($request)
    {
        $total = 0;
        
        // Calculate pembuka
        $pembuka = 0;
        for ($i = 1; $i <= 5; $i++) {
            if ($request->input("detail_n1_$i") == 1) {
                $pembuka++;
            }
        }
        if ($pembuka == 5) {
            $total += ParameterProses::first()->bobot_proses ?? 0;
        }
        
        // Calculate verifikasi
        if ($request->input('detail_n2_1') == 1) {
            $total += ParameterProses::first()->bobot_verifikasi ?? 0;
        }
        
        // Calculate penutup
        if ($request->input('detail_n3_1') == 1 && $request->input('detail_n3_2') == 1) {
            $total += ParameterProses::first()->bobot_penutup ?? 0;
        }
        
        return $total;
    }

    private function calculateTotalSikap($request)
    {
        $total = 0;
        $parameterSikap = ParameterSikap::first();
        
        // P1
        $p1 = 0;
        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("detail_n4_$i") == 1) {
                $p1++;
            }
        }
        if ($p1 == 3) {
            $total += $parameterSikap->bobot_p1 ?? 0;
        }
        
        // P2
        if ($request->input('detail_n5_1') == 1) {
            $total += $parameterSikap->bobot_p2 ?? 0;
        }
        
        // P3
        $p3 = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($request->input("detail_n6_$i") == 1) {
                $p3++;
            }
        }
        if ($p3 == 4) {
            $total += $parameterSikap->bobot_p3 ?? 0;
        }
        
        // P4
        $p4 = 0;
        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("detail_n7_$i") == 1) {
                $p4++;
            }
        }
        if ($p4 == 3) {
            $total += $parameterSikap->bobot_p4 ?? 0;
        }
        
        // P5
        $p5 = 0;
        for ($i = 1; $i <= 10; $i++) {
            if ($request->input("detail_n8_$i") == 1) {
                $p5++;
            }
        }
        if ($p5 == 10) {
            $total += $parameterSikap->bobot_p5 ?? 0;
        }
        
        // P6
        $p6 = 0;
        for ($i = 1; $i <= 6; $i++) {
            if ($request->input("detail_n9_$i") == 1) {
                $p6++;
            }
        }
        if ($p6 == 6) {
            $total += $parameterSikap->bobot_p6 ?? 0;
        }
        
        // P7
        if ($request->input('detail_n10_1') == 1) {
            $total += $parameterSikap->bobot_p7 ?? 0;
        }
        
        // P8
        if ($request->input('detail_n11_1') == 1) {
            $total += $parameterSikap->bobot_p8 ?? 0;
        }
        
        // P9
        $p9 = 0;
        for ($i = 1; $i <= 7; $i++) {
            if ($request->input("detail_n12_$i") == 1) {
                $p9++;
            }
        }
        if ($p9 == 7) {
            $total += $parameterSikap->bobot_p9 ?? 0;
        }
        
        // P10
        $p10 = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($request->input("detail_n13_$i") == 1) {
                $p10++;
            }
        }
        if ($p10 == 4) {
            $total += $parameterSikap->bobot_p10 ?? 0;
        }
        
        // P11
        $p11 = 0;
        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("detail_n14_$i") == 1) {
                $p11++;
            }
        }
        if ($p11 == 3) {
            $total += $parameterSikap->bobot_p11 ?? 0;
        }
        
        return $total;
    }

    private function calculateTotalSolusi($request)
    {
        $total = 0;
        $parameterSolusi = ParameterSolusi::first();
        
        // P1
        if ($request->input('detail_n15_1') == 1) {
            $total += $parameterSolusi->bobot_p1 ?? 0;
        }
        
        // P2
        $p2 = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($request->input("detail_n16_$i") == 1) {
                $p2++;
            }
        }
        if ($p2 == 4) {
            $total += $parameterSolusi->bobot_p2 ?? 0;
        }
        
        return $total;
    }

    public function downloadPeakDetail($peak)
    {
        $penilaianTappings = PenilaianTapping::with('user.profile')
            ->where('peak', $peak)
            ->get();

        $filename = "Detail_Nilai_Peak_{$peak}_" . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($penilaianTappings, $peak) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Nama Agent',
                'Perner',
                'Login ID',
                'Site',
                'Peak',
                'Tanggal Recording',
                'Nama Checker',
                'Total Proses',
                'Total Sikap',
                'Total Solusi',
                'Total QM',
                'Keterangan',
                'Detail Pembuka (N1)',
                'Detail Verifikasi (N2)',
                'Detail Penutup (N3)',
                'Detail Sikap P1 (N4)',
                'Detail Sikap P2 (N5)',
                'Detail Sikap P3 (N6)',
                'Detail Sikap P4 (N7)',
                'Detail Sikap P5 (N8)',
                'Detail Sikap P6 (N9)',
                'Detail Sikap P7 (N10)',
                'Detail Sikap P8 (N11)',
                'Detail Sikap P9 (N12)',
                'Detail Sikap P10 (N13)',
                'Detail Sikap P11 (N14)',
                'Detail Solusi P1 (N15)',
                'Detail Solusi P2 (N16)'
            ]);

            $no = 1;
            foreach ($penilaianTappings as $penilaian) {
                fputcsv($file, [
                    $no++,
                    $penilaian->user->name ?? '',
                    $penilaian->perner ?? '',
                    $penilaian->login_id ?? '',
                    $penilaian->site ?? '',
                    $penilaian->peak ?? '',
                    $penilaian->tanggal_recording ?? '',
                    $penilaian->nama_checker ?? '',
                    $penilaian->total_proses ?? 0,
                    $penilaian->total_sikap ?? 0,
                    $penilaian->total_solusi ?? 0,
                    $penilaian->total_qm_p1 ?? 0,
                    $penilaian->keterangan ?? '',
                    $this->getDetailNilai($penilaian, 'n1'),
                    $this->getDetailNilai($penilaian, 'n2'),
                    $this->getDetailNilai($penilaian, 'n3'),
                    $this->getDetailNilai($penilaian, 'n4'),
                    $this->getDetailNilai($penilaian, 'n5'),
                    $this->getDetailNilai($penilaian, 'n6'),
                    $this->getDetailNilai($penilaian, 'n7'),
                    $this->getDetailNilai($penilaian, 'n8'),
                    $this->getDetailNilai($penilaian, 'n9'),
                    $this->getDetailNilai($penilaian, 'n10'),
                    $this->getDetailNilai($penilaian, 'n11'),
                    $this->getDetailNilai($penilaian, 'n12'),
                    $this->getDetailNilai($penilaian, 'n13'),
                    $this->getDetailNilai($penilaian, 'n14'),
                    $this->getDetailNilai($penilaian, 'n15'),
                    $this->getDetailNilai($penilaian, 'n16')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getDetailNilai($penilaian, $prefix)
    {
        $details = [];
        $maxFields = $this->getMaxFieldsForPrefix($prefix);
        
        for ($i = 1; $i <= $maxFields; $i++) {
            $fieldName = "detail_{$prefix}_{$i}";
            if (isset($penilaian->$fieldName)) {
                $details[] = $penilaian->$fieldName == 1 ? 'Ya' : 'Tidak';
            }
        }
        
        return implode(', ', $details);
    }

    private function getMaxFieldsForPrefix($prefix)
    {
        $maxFields = [
            'n1' => 5, 'n2' => 2, 'n3' => 2, 'n4' => 3, 'n5' => 1,
            'n6' => 4, 'n7' => 3, 'n8' => 10, 'n9' => 6, 'n10' => 1,
            'n11' => 1, 'n12' => 7, 'n13' => 4, 'n14' => 3, 'n15' => 1, 'n16' => 4
        ];
        
        return $maxFields[$prefix] ?? 1;
    }

    public function downloadAgentDetail($agentId, $peak)
    {
        $penilaianTapping = PenilaianTapping::with('user.profile')
            ->where('name_id', $agentId)
            ->where('peak', $peak)
            ->first();

        if (!$penilaianTapping) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $parameterProses = ParameterProses::all();
        $parameterSikap = ParameterSikap::all();
        $parameterSolusi = ParameterSolusi::all();

        $data = [
            'penilaian' => $penilaianTapping,
            'peak' => $peak,
            'detailNilai' => $this->getAllDetailNilai($penilaianTapping),
            'parameterProses' => $parameterProses,
            'parameterSikap' => $parameterSikap,
            'parameterSolusi' => $parameterSolusi
        ];

        return view('penilaian_tappings.pdf.detail', $data);
    }

    private function getAllDetailNilai($penilaian)
    {
        $details = [];
        
        // Detail Proses - Ambil data aktual dari database
        $details['proses'] = [
            'pembuka' => [
                'n1_1' => $penilaian->detail_n1_1 ?? 0,
                'n1_2' => $penilaian->detail_n1_2 ?? 0,
                'n1_3' => $penilaian->detail_n1_3 ?? 0,
                'n1_4' => $penilaian->detail_n1_4 ?? 0,
                'n1_5' => $penilaian->detail_n1_5 ?? 0,
                'total' => $penilaian->total_n1 ?? 0
            ],
            'verifikasi' => [
                'n2_1' => $penilaian->detail_n2_1 ?? 0,
                'n2_2' => $penilaian->detail_n2_2 ?? 0,
                'total' => $penilaian->total_n2 ?? 0
            ],
            'penutup' => [
                'n3_1' => $penilaian->detail_n3_1 ?? 0,
                'n3_2' => $penilaian->detail_n3_2 ?? 0,
                'total' => $penilaian->total_n3 ?? 0
            ],
            'total' => $penilaian->total_proses ?? 0
        ];
        
        // Detail Sikap - Ambil data aktual dari database
        $details['sikap'] = [
            'p1' => [
                'n4_1' => $penilaian->detail_n4_1 ?? 0,
                'n4_2' => $penilaian->detail_n4_2 ?? 0,
                'n4_3' => $penilaian->detail_n4_3 ?? 0,
                'total' => $penilaian->total_n4 ?? 0
            ],
            'p2' => [
                'n5_1' => $penilaian->detail_n5_1 ?? 0,
                'total' => $penilaian->total_n5 ?? 0
            ],
            'p3' => [
                'n6_1' => $penilaian->detail_n6_1 ?? 0,
                'n6_2' => $penilaian->detail_n6_2 ?? 0,
                'n6_3' => $penilaian->detail_n6_3 ?? 0,
                'n6_4' => $penilaian->detail_n6_4 ?? 0,
                'total' => $penilaian->total_n6 ?? 0
            ],
            'p4' => [
                'n7_1' => $penilaian->detail_n7_1 ?? 0,
                'n7_2' => $penilaian->detail_n7_2 ?? 0,
                'n7_3' => $penilaian->detail_n7_3 ?? 0,
                'total' => $penilaian->total_n7 ?? 0
            ],
            'p5' => [
                'n8_1' => $penilaian->detail_n8_1 ?? 0,
                'n8_2' => $penilaian->detail_n8_2 ?? 0,
                'n8_3' => $penilaian->detail_n8_3 ?? 0,
                'n8_4' => $penilaian->detail_n8_4 ?? 0,
                'n8_5' => $penilaian->detail_n8_5 ?? 0,
                'n8_6' => $penilaian->detail_n8_6 ?? 0,
                'n8_7' => $penilaian->detail_n8_7 ?? 0,
                'n8_8' => $penilaian->detail_n8_8 ?? 0,
                'n8_9' => $penilaian->detail_n8_9 ?? 0,
                'n8_10' => $penilaian->detail_n8_10 ?? 0,
                'total' => $penilaian->total_n8 ?? 0
            ],
            'p6' => [
                'n9_1' => $penilaian->detail_n9_1 ?? 0,
                'n9_2' => $penilaian->detail_n9_2 ?? 0,
                'n9_3' => $penilaian->detail_n9_3 ?? 0,
                'n9_4' => $penilaian->detail_n9_4 ?? 0,
                'n9_5' => $penilaian->detail_n9_5 ?? 0,
                'n9_6' => $penilaian->detail_n9_6 ?? 0,
                'total' => $penilaian->total_n9 ?? 0
            ],
            'p7' => [
                'n10_1' => $penilaian->detail_n10_1 ?? 0,
                'total' => $penilaian->total_n10 ?? 0
            ],
            'p8' => [
                'n11_1' => $penilaian->detail_n11_1 ?? 0,
                'total' => $penilaian->total_n11 ?? 0
            ],
            'p9' => [
                'n12_1' => $penilaian->detail_n12_1 ?? 0,
                'n12_2' => $penilaian->detail_n12_2 ?? 0,
                'n12_3' => $penilaian->detail_n12_3 ?? 0,
                'n12_4' => $penilaian->detail_n12_4 ?? 0,
                'n12_5' => $penilaian->detail_n12_5 ?? 0,
                'n12_6' => $penilaian->detail_n12_6 ?? 0,
                'n12_7' => $penilaian->detail_n12_7 ?? 0,
                'total' => $penilaian->total_n12 ?? 0
            ],
            'p10' => [
                'n13_1' => $penilaian->detail_n13_1 ?? 0,
                'n13_2' => $penilaian->detail_n13_2 ?? 0,
                'n13_3' => $penilaian->detail_n13_3 ?? 0,
                'n13_4' => $penilaian->detail_n13_4 ?? 0,
                'total' => $penilaian->total_n13 ?? 0
            ],
            'p11' => [
                'n14_1' => $penilaian->detail_n14_1 ?? 0,
                'n14_2' => $penilaian->detail_n14_2 ?? 0,
                'n14_3' => $penilaian->detail_n14_3 ?? 0,
                'total' => $penilaian->total_n14 ?? 0
            ],
            'total' => $penilaian->total_sikap ?? 0
        ];
        
        // Detail Solusi - Ambil data aktual dari database
        $details['solusi'] = [
            'p1' => [
                'n15_1' => $penilaian->detail_n15_1 ?? 0,
                'total' => $penilaian->total_n15 ?? 0
            ],
            'p2' => [
                'n16_1' => $penilaian->detail_n16_1 ?? 0,
                'n16_2' => $penilaian->detail_n16_2 ?? 0,
                'n16_3' => $penilaian->detail_n16_3 ?? 0,
                'n16_4' => $penilaian->detail_n16_4 ?? 0,
                'total' => $penilaian->total_n16 ?? 0
            ],
            'total' => $penilaian->total_solusi ?? 0
        ];
        
        return $details;
    }
}