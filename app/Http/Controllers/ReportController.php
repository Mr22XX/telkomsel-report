<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

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

            // jumlah pcs orbit
            'sp_telkom' => 'nullable|integer|min:0',
            'orbit_n1' => 'nullable|integer|min:0',
            'orbit_n2' => 'nullable|integer|min:0',
            'orbit_n2_new' => 'nullable|integer|min:0',
            'orbit_h2' => 'nullable|integer|min:0',
            'orbit_h2_np01' => 'nullable|integer|min:0',
            'orbit_h3' => 'nullable|integer|min:0',

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

        $revenueFields = [
            'cvm_byu','super_seru','digital','roaming','vf_hp',
            'vf_lite_byu','lite_vf','byu_vf','my_telkomsel'
        ];

        $data = $request->all();

        foreach ($revenueFields as $field) {
            $data[$field] = isset($data[$field])
                ? preg_replace('/[^0-9]/', '', $data[$field])
                : 0;
        }

        // ================= ORBIT CALCULATION =================
        $prices = config('orbit_price.orbit');

        $orbit_total =
            ($data['sp_telkom'] ?? 0) * $prices['SP Telkomsel Lite'] +
            ($data['orbit_n1'] ?? 0) * $prices['Orbit N1'] +
            ($data['orbit_n2'] ?? 0) * $prices['Orbit Star N2'] +
            ($data['orbit_n2_new'] ?? 0) * $prices['Orbit Star N2 (New-01)'] +
            ($data['orbit_h2'] ?? 0) * $prices['Orbit Star H2'] +
            ($data['orbit_h2_np01'] ?? 0) * $prices['Orbit Star H2 (Np-01)'] +
            ($data['orbit_h3'] ?? 0) * $prices['Orbit Star H3'];
        // =====================================================

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

            // jumlah pcs orbit
            'sp_telkom' => $data['sp_telkom'] ?? 0,
            'orbit_n1' => $data['orbit_n1'] ?? 0,
            'orbit_n2' => $data['orbit_n2'] ?? 0,
            'orbit_n2_new' => $data['orbit_n2_new'] ?? 0,
            'orbit_h2' => $data['orbit_h2'] ?? 0,
            'orbit_h2_np01' => $data['orbit_h2_np01'] ?? 0,
            'orbit_h3' => $data['orbit_h3'] ?? 0,

            // hasil rupiah orbit
            'orbit' => $orbit_total,

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

    public function show(Report $report)
    {
        $this->authorizeOwner($report);
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $this->authorizeOwner($report);
        return view('reports.edit', compact('report'));
    }

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

        // ================= ORBIT CALCULATION =================
        $prices = config('orbit_price.orbit');

        $orbit_total =
            ($data['sp_telkom'] ?? 0) * $prices['SP Telkomsel Lite'] +
            ($data['orbit_n1'] ?? 0) * $prices['Orbit N1'] +
            ($data['orbit_n2'] ?? 0) * $prices['Orbit Star N2'] +
            ($data['orbit_n2_new'] ?? 0) * $prices['Orbit Star N2 (New-01)'] +
            ($data['orbit_h2'] ?? 0) * $prices['Orbit Star H2'] +
            ($data['orbit_h2_np01'] ?? 0) * $prices['Orbit Star H2 (Np-01)'] +
            ($data['orbit_h3'] ?? 0) * $prices['Orbit Star H3'];

        $data['orbit'] = $orbit_total;
        // =====================================================

        $report->update($data);

        return redirect()->route('reports.index')
            ->with('success', 'Report berhasil diupdate');
    }

    public function destroy(Report $report)
    {
        $this->authorizeOwner($report);
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report berhasil dihapus');
    }

    private function authorizeOwner(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
