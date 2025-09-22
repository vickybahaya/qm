<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterSikap;
use Yajra\DataTables\Facades\DataTables;

class ParameterSikapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil data proses, sikap, solusi untuk tab
        $proses = \App\Models\ParameterProses::all();
        $sikap = \App\Models\ParameterSikap::all();
        $solusi = \App\Models\ParameterSolusi::all();
        return view('parameter_qm.index', compact('proses', 'sikap', 'solusi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parameter_sikap.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'header_p1' => 'required',
            'detail_1_1' => 'required',
            'detail_1_2' => 'required',
            'detail_1_3' => 'required',
            'bobot_p1' => 'required|numeric',
            'header_p2' => 'required',
            'detail_2_1' => 'required',
            'bobot_p2' => 'required|numeric',
            'header_p3' => 'required',
            'detail_3_1' => 'required',
            'detail_3_2' => 'required',
            'detail_3_3' => 'required',
            'detail_3_4' => 'required',
            'bobot_p3' => 'required|numeric',
            'header_p4' => 'required',
            'detail_4_1' => 'required',
            'detail_4_2' => 'required',
            'detail_4_3' => 'required',
            'bobot_p4' => 'required|numeric',
            'header_p5' => 'required',
            'detail_5_1' => 'required',
            'detail_5_2' => 'required',
            'detail_5_3' => 'required',
            'detail_5_4' => 'required',
            'detail_5_5' => 'required',
            'detail_5_6' => 'required',
            'detail_5_7' => 'required',
            'detail_5_8' => 'required',
            'detail_5_9' => 'required',
            'detail_5_10' => 'required',
            'bobot_p5' => 'required|numeric',
            'header_p6' => 'required',
            'detail_6_1' => 'required',
            'detail_6_2' => 'required',
            'detail_6_3' => 'required',
            'detail_6_4' => 'required',
            'detail_6_5' => 'required',
            'detail_6_6' => 'required',
            'bobot_p6' => 'required|numeric',
            'header_p7' => 'required',
            'detail_7_1' => 'required',
            'bobot_p7' => 'required|numeric',
            'header_p8' => 'required',
            'detail_8_1' => 'required',
            'bobot_p8' => 'required|numeric',
            'header_p9' => 'required',
            'detail_9_1' => 'required',
            'detail_9_2' => 'required',
            'detail_9_3' => 'required',
            'detail_9_4' => 'required',
            'detail_9_5' => 'required',
            'detail_9_6' => 'required',
            'detail_9_7' => 'required',
            'bobot_p9' => 'required|numeric',
            'header_p10' => 'required',
            'detail_10_1' => 'required',
            'detail_10_2' => 'required',
            'detail_10_3' => 'required',
            'detail_10_4' => 'required',
            'bobot_p10' => 'required|numeric',
            'header_p11' => 'required',
            'detail_11_1' => 'required',
            'detail_11_2' => 'required',
            'detail_11_3' => 'required',
            'bobot_p11' => 'required|numeric',
        ]);

        ParameterSikap::create($request->all());

        return redirect()->route('parameter-sikap.index')->with('success', 'Parameter Sikap berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParameterSikap $parameterSikap)
    {
        return view('parameter_sikap.show', compact('parameterSikap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParameterSikap $parameterSikap)
    {
        return view('parameter_sikap.edit', compact('parameterSikap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParameterSikap $parameterSikap)
    {
        $request->validate([
            // Hanya field yang bisa diubah user (tidak di-disable) yang divalidasi required
            'detail_1_1' => 'required',
            'detail_1_2' => 'required',
            'detail_1_3' => 'required',
            'bobot_p1' => 'required|numeric',
            'detail_2_1' => 'required',
            'bobot_p2' => 'required|numeric',
            'detail_3_1' => 'required',
            'detail_3_2' => 'required',
            'detail_3_3' => 'required',
            'detail_3_4' => 'required',
            'bobot_p3' => 'required|numeric',
            'detail_4_1' => 'required',
            'detail_4_2' => 'required',
            'detail_4_3' => 'required',
            'bobot_p4' => 'required|numeric',
            'detail_5_1' => 'required',
            'detail_5_2' => 'required',
            'detail_5_3' => 'required',
            'detail_5_4' => 'required',
            'detail_5_5' => 'required',
            'detail_5_6' => 'required',
            'detail_5_7' => 'required',
            'detail_5_8' => 'required',
            'detail_5_9' => 'required',
            'detail_5_10' => 'required',
            'bobot_p5' => 'required|numeric',
            'detail_6_1' => 'required',
            'detail_6_2' => 'required',
            'detail_6_3' => 'required',
            'detail_6_4' => 'required',
            'detail_6_5' => 'required',
            'bobot_p6' => 'required|numeric',
            'detail_7_1' => 'required',
            'bobot_p7' => 'required|numeric',
            'detail_8_1' => 'required',
            'bobot_p8' => 'required|numeric',
            'detail_9_1' => 'required',
            'detail_9_2' => 'required',
            'detail_9_3' => 'required',
            'detail_9_4' => 'required',
            'detail_9_5' => 'required',
            'detail_9_6' => 'required',
            'detail_9_7' => 'required',
            'bobot_p9' => 'required|numeric',
            'detail_10_1' => 'required',
            'detail_10_2' => 'required',
            'detail_10_3' => 'required',
            'detail_10_4' => 'required',
            'bobot_p10' => 'required|numeric',
            'detail_11_1' => 'required',
            'detail_11_2' => 'required',
            'detail_11_3' => 'required',
            'bobot_p11' => 'required|numeric',
        ]);

        $parameterSikap->update($request->all());

        return redirect()->route('parameter-sikap.index')->with('success', 'Parameter Sikap berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParameterSikap $parameterSikap)
    {
        $parameterSikap->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parameter Sikap berhasil dihapus'
        ]);
    }
}
