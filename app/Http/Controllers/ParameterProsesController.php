<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterProses;
use Yajra\DataTables\Facades\DataTables;

class ParameterProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Redirect ke halaman utama parameter_qm
        return redirect()->route('parameter-qm.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parameter_proses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'header_parameter_pembuka' => 'required',
            'detail_p1' => 'required',
            'detail_p2' => 'required',
            'detail_p3' => 'required',
            'detail_p4' => 'required',
            'detail_p5' => 'required',
            'bobot_proses' => 'required|numeric',
            'header_parameter_verifikasi' => 'required',
            'detail_v1' => 'required',
            'bobot_verifikasi' => 'required|numeric',
            'header_parameter_penutup' => 'required',
            'detail_sp1' => 'required',
            'detail_sp2' => 'required',
            'bobot_penutup' => 'required|numeric',
        ]);

        ParameterProses::create($request->all());

        return redirect()->route('parameter-proses.index')->with('success', 'Parameter Proses berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParameterProses $parameterProse)
    {
        return view('parameter_proses.show', compact('parameterProse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParameterProses $parameterProse)
    {
        return view('parameter_proses.edit', compact('parameterProse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParameterProses $parameterProse)
    {
        // Jika request dari index (inline), update hanya field yang dikirim
        $fields = [
            'header_parameter_pembuka', 'detail_p1', 'detail_p2', 'detail_p3', 'detail_p4', 'detail_p5', 'bobot_proses',
            'header_parameter_verifikasi', 'detail_v1', 'bobot_verifikasi',
            'header_parameter_penutup', 'detail_sp1', 'detail_sp2', 'bobot_penutup',
        ];
        $input = $request->only($fields);
        // Convert empty string to null for all fields
        foreach ($input as $key => $val) {
            if ($val === '') {
                $input[$key] = null;
            }
        }
        // Jika request hanya field di atas (tanpa field lain seperti _token, _method)
        if (count(array_diff(array_keys($request->all()), array_merge($fields, ['_token','_method']))) === 0) {
            $rules = [];
            foreach ($input as $key => $val) {
                if (str_contains($key, 'bobot')) {
                    $rules[$key] = 'nullable|numeric';
                } else {
                    $rules[$key] = 'nullable|string';
                }
            }
            $validated = $request->validate($rules);
            // Use $input to ensure empty string is null
            $parameterProse->update(array_merge($validated, $input));
            return redirect()->route('parameter-qm.index')->with('success', 'Parameter berhasil diperbarui');
        }
        // Update full data (halaman edit)
        $request->validate([
            'header_parameter_pembuka' => 'required',
            'detail_p1' => 'required',
            'detail_p2' => 'required',
            'detail_p3' => 'required',
            'detail_p4' => 'required',
            'detail_p5' => 'required',
            'bobot_proses' => 'required|numeric',
            'header_parameter_verifikasi' => 'required',
            'detail_v1' => 'required',
            'bobot_verifikasi' => 'required|numeric',
            'header_parameter_penutup' => 'required',
            'detail_sp1' => 'required',
            'detail_sp2' => 'required',
            'bobot_penutup' => 'required|numeric',
        ]);
        $parameterProse->update($request->all());
        return redirect()->route('parameter-proses.index')->with('success', 'Parameter Proses berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParameterProses $parameterProse)
    {
        $parameterProse->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parameter Proses berhasil dihapus'
        ]);
    }
}