<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tap' => 'required|string',
            'fokus_1' => 'nullable|string',
            'fokus_2' => 'nullable|string',
            'fokus_3' => 'nullable|string',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'tap' => $request->tap,
            'nama_sales' => Auth::user()->name,

            'fokus_1' => $request->fokus_1,
            'fokus_2' => $request->fokus_2,
            'fokus_3' => $request->fokus_3,

            'perdana' => $request->perdana ?? 0,
            'byu' => $request->byu ?? 0,
            'lite' => $request->lite ?? 0,
            'orbit' => $request->orbit ?? 0,
            'cvm_byu' => $request->cvm_byu ?? 0,
            'super_seru' => $request->super_seru ?? 0,
            'digital' => $request->digital ?? 0,
            'roaming' => $request->roaming ?? 0,

            'vf_hp' => $request->vf_hp ?? 0,
            'vf_lite_byu' => $request->vf_lite_byu ?? 0,
            'lite_vf' => $request->lite_vf ?? 0,
            'byu_vf' => $request->byu_vf ?? 0,

            'my_telkomsel' => $request->my_telkomsel ?? 0,
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $this->authorizeOwner($report);
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        $this->authorizeOwner($report);
        return view('reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $this->authorizeOwner($report);

        $report->update($request->all());

        return redirect()->route('reports.index')
            ->with('success', 'Report berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->authorizeOwner($report);
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report berhasil dihapus');
    }

    /**
     * CEK KEPEMILIKAN DATA
     */
    private function authorizeOwner(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
