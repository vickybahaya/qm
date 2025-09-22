<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterProses;
use App\Models\ParameterSikap;
use App\Models\ParameterSolusi;
use Yajra\DataTables\Facades\DataTables;

class ParameterQmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proses = ParameterProses::all();
        $sikap = ParameterSikap::all();
        $solusi = ParameterSolusi::all();
        return view('parameter_qm.index', compact('proses', 'sikap', 'solusi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        return view('parameter_qm.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        $request->validate([
            'header_parameter_pembuka' => 'required_if:type,proses',
            'detail_p1' => 'required_if:type,proses',
            'detail_p2' => 'required_if:type,proses',
            'detail_p3' => 'required_if:type,proses',
            'detail_p4' => 'required_if:type,proses',
            'detail_p5' => 'required_if:type,proses',
            'bobot_proses' => 'required_if:type,proses|numeric',
            'header_parameter_verifikasi' => 'required_if:type,proses',
            'detail_v1' => 'required_if:type,proses',
            'bobot_verifikasi' => 'required_if:type,proses|numeric',
            'header_parameter_penutup' => 'required_if:type,proses',
            'detail_sp1' => 'required_if:type,proses',
            'detail_sp2' => 'required_if:type,proses',
            'bobot_penutup' => 'required_if:type,proses|numeric',
        ]);

        switch ($type) {
            case 'proses':
                ParameterProses::create($request->all());
                break;
            case 'sikap':
                ParameterSikap::create($request->all());
                break;
            case 'solusi':
                ParameterSolusi::create($request->all());
                break;
        }

        return redirect()->route('parameter-qm.index')->with('success', 'Parameter ' . ucfirst($type) . ' berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($type, $id)
    {
        switch ($type) {
            case 'proses':
                $parameter = ParameterProses::findOrFail($id);
                break;
            case 'sikap':
                $parameter = ParameterSikap::findOrFail($id);
                break;
            case 'solusi':
                $parameter = ParameterSolusi::findOrFail($id);
                break;
            default:
                abort(404);
        }

        return view('parameter_qm.show', compact('parameter', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($type, $id)
    {
        switch ($type) {
            case 'proses':
                $parameter = ParameterProses::findOrFail($id);
                break;
            case 'sikap':
                $parameter = ParameterSikap::findOrFail($id);
                break;
            case 'solusi':
                $parameter = ParameterSolusi::findOrFail($id);
                break;
            default:
                abort(404);
        }

        return view('parameter_qm.edit', compact('parameter', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $type, $id)
    {
        $request->validate([
            'header_parameter_pembuka' => 'required_if:type,proses',
            'detail_p1' => 'required_if:type,proses',
            'detail_p2' => 'required_if:type,proses',
            'detail_p3' => 'required_if:type,proses',
            'detail_p4' => 'required_if:type,proses',
            'detail_p5' => 'required_if:type,proses',
            'bobot_proses' => 'required_if:type,proses|numeric',
            'header_parameter_verifikasi' => 'required_if:type,proses',
            'detail_v1' => 'required_if:type,proses',
            'bobot_verifikasi' => 'required_if:type,proses|numeric',
            'header_parameter_penutup' => 'required_if:type,proses',
            'detail_sp1' => 'required_if:type,proses',
            'detail_sp2' => 'required_if:type,proses',
            'bobot_penutup' => 'required_if:type,proses|numeric',
        ]);

        switch ($type) {
            case 'proses':
                $parameter = ParameterProses::findOrFail($id);
                break;
            case 'sikap':
                $parameter = ParameterSikap::findOrFail($id);
                break;
            case 'solusi':
                $parameter = ParameterSolusi::findOrFail($id);
                break;
            default:
                abort(404);
        }

        $parameter->update($request->all());

        return redirect()->route('parameter-qm.index')->with('success', 'Parameter ' . ucfirst($type) . ' berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type, $id)
    {
        switch ($type) {
            case 'proses':
                $parameter = ParameterProses::findOrFail($id);
                break;
            case 'sikap':
                $parameter = ParameterSikap::findOrFail($id);
                break;
            case 'solusi':
                $parameter = ParameterSolusi::findOrFail($id);
                break;
            default:
                abort(404);
        }

        $parameter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parameter ' . ucfirst($type) . ' berhasil dihapus'
        ]);
    }
}