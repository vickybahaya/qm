<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterSolusi;
use Yajra\DataTables\Facades\DataTables;

class ParameterSolusiController extends Controller
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
        return view('parameter_solusi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'header_p1' => 'required',
            'detail_p1' => 'required',
            'detail_1_2' => 'required',
            'bobot_p1' => 'required|numeric',
            'header_p2' => 'required',
            'detail_p2_1' => 'required',
            'detail_p2_2' => 'required',
            'detail_p2_3' => 'required',
            'detail_p2_4' => 'required',
            'bobot_p2' => 'required|numeric',
        ]);

        ParameterSolusi::create($request->all());

        return redirect()->route('parameter-solusi.index')->with('success', 'Parameter Solusi berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParameterSolusi $parameterSolusi)
    {
        return view('parameter_solusi.show', compact('parameterSolusi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParameterSolusi $parameterSolusi)
    {
        return view('parameter_solusi.edit', compact('parameterSolusi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParameterSolusi $parameterSolusi)
    {
        $request->validate([
            // Hanya field yang bisa diubah user (tidak di-disable) yang divalidasi required
            'detail_p1' => 'required',
            'bobot_p1' => 'required|numeric',
            'detail_p2_1' => 'required',
            'detail_p2_2' => 'required',
            'detail_p2_3' => 'required',
            'detail_p2_4' => 'required',
            'bobot_p2' => 'required|numeric',
        ]);

        $parameterSolusi->update($request->all());

        return redirect()->route('parameter-solusi.index')->with('success', 'Parameter Solusi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParameterSolusi $parameterSolusi)
    {
        $parameterSolusi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parameter Solusi berhasil dihapus'
        ]);
    }
}
