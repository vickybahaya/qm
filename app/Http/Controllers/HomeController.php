<?php

namespace App\Http\Controllers;

use App\Models\PenilaianTapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Statistik ringkas
        $stat = [];
        $stat['total_penilaian'] = PenilaianTapping::count();
        $stat['total_agent'] = PenilaianTapping::distinct('name_id')->count('name_id');
        $stat['avg_qm'] = round(PenilaianTapping::avg('total_qm_p1'), 2);
        $stat['persen_lulus'] = PenilaianTapping::where('keterangan', 'LULUS')->count() > 0
            ? round(PenilaianTapping::where('keterangan', 'LULUS')->count() / max(PenilaianTapping::count(),1) * 100, 1)
            : 0;

        // Data chart tren nilai QM per bulan (12 bulan terakhir)
        $chart = [];
        $bulan = [];
        $nilai = [];
        $now = now();
        for ($i = 11; $i >= 0; $i--) {
            $bln = $now->copy()->subMonths($i)->format('Y-m');
            $bulan[] = $now->copy()->subMonths($i)->format('M Y');
            $nilai[] = PenilaianTapping::where(DB::raw('DATE_FORMAT(tanggal_recording, "%Y-%m")'), $bln)->avg('total_qm_p1') ?? 0;
        }
        $chart['labels'] = $bulan;
        $chart['data'] = $nilai;
        // Pie chart status lulus/tidak
        $chart['pie'] = [
            PenilaianTapping::where('keterangan', 'LULUS')->count(),
            PenilaianTapping::where('keterangan', 'TIDAK LULUS')->count()
        ];

        // Penilaian terbaru (10 data)
        $latest = PenilaianTapping::with('user')->orderByDesc('tanggal_recording')->limit(10)->get();

        return view('home', compact('stat', 'chart', 'latest'));
    }
}
