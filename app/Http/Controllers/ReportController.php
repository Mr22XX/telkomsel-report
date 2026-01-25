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

            'perdana' => 'nullable|integer|min:0',
            'byu' => 'nullable|integer|min:0',
            'lite' => 'nullable|integer|min:0',
            'orbit' => 'nullable|integer|min:0',

            // revenue tetap numeric setelah dibersihkan
            'cvm_byu' => 'nullable',
            'super_seru' => 'nullable',
            'digital' => 'nullable',
            'roaming' => 'nullable',
            'vf_hp' => 'nullable',
            'vf_lite_byu' => 'nullable',
            'lite_vf' => 'nullable',
            'byu_vf' => 'nullable',
            'my_telkomsel' => 'nullable',
        ]);

        // FIELD REVENUE
        $revenueFields = [
            'cvm_byu','super_seru','digital','roaming','vf_hp',
            'vf_lite_byu','lite_vf','byu_vf','my_telkomsel'
        ];

        $data = $request->all();

        // bersihkan Rp dan titik
        foreach ($revenueFields as $field) {
            $data[$field] = isset($data[$field])
                ? preg_replace('/[^0-9]/', '', $data[$field])
                : 0;
        }

        Report::create([
            'user_id' => Auth::id(),
            'tanggal' => $data['tanggal'],
            'tap' => $data['tap'],
            'nama_sales' => Auth::user()->name,

            'fokus_1' => $data['fokus_1'] ?? null,
            'fokus_2' => $data['fokus_2'] ?? null,
            'fokus_3' => $data['fokus_3'] ?? null,

            'perdana' => $data['perdana'] ?? 0,
            'byu' => $data['byu'] ?? 0,
            'lite' => $data['lite'] ?? 0,
            'orbit' => $data['orbit'] ?? 0,

            'cvm_byu' => $data['cvm_byu'] ?? 0,
            'super_seru' => $data['super_seru'] ?? 0,
            'digital' => $data['digital'] ?? 0,
            'roaming' => $data['roaming'] ?? 0,
            'vf_hp' => $data['vf_hp'] ?? 0,
            'vf_lite_byu' => $data['vf_lite_byu'] ?? 0,
            'lite_vf' => $data['lite_vf'] ?? 0,
            'byu_vf' => $data['byu_vf'] ?? 0,
            'my_telkomsel' => $data['my_telkomsel'] ?? 0,
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

        $revenueFields = [
            'cvm_byu','super_seru','digital','roaming','vf_hp',
            'vf_lite_byu','lite_vf','byu_vf','my_telkomsel'
        ];

        $data = $request->all();

        foreach ($revenueFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = preg_replace('/[^0-9]/', '', $data[$field]);
            }
        }

        $report->update($data);

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
