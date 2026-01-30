<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalesDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $year = now()->year;

        // ambil semua report user tahun ini
        $reports = Report::where('user_id', $userId)
            ->whereYear('tanggal', $year)
            ->get();

        // ================= TOTAL REPORT =================
        $totalReport = $reports->count();

        // ================= TOTAL REVENUE TAHUN INI =================
        $totalRevenue = $reports->sum(function ($r) {
            return
                $r->cvm_byu + $r->super_seru + $r->digital + $r->roaming +
                $r->vf_hp + $r->vf_lite_byu + $r->lite_vf + $r->byu_vf + $r->my_telkomsel + $r->orbit
                + ($r->perdana * 35000)
                + ($r->lite * 35000)
                + ($r->byu * 35000);
        });

        // ================= TODAY REVENUE =================
        $todayRevenue = $reports
            ->where('tanggal', now()->toDateString())
            ->sum(function ($r) {
                return
                    $r->cvm_byu + $r->super_seru + $r->digital + $r->roaming +
                    $r->vf_hp + $r->vf_lite_byu + $r->lite_vf + $r->byu_vf + $r->my_telkomsel + $r->orbit
                    + ($r->perdana * 35000)
                    + ($r->lite * 35000)
                    + ($r->byu * 35000);
            });

        // ================= DATA CHART PER BULAN =================
        $monthlyLabels = [];
        $monthlyRevenueTotals = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = Carbon::create()->month($m)->translatedFormat('F');

            $monthlyRevenueTotals[] = $reports
                ->filter(fn($r) => Carbon::parse($r->tanggal)->month == $m)
                ->sum(function ($r) {
                    return
                        $r->cvm_byu + $r->super_seru + $r->digital + $r->roaming +
                        $r->vf_hp + $r->vf_lite_byu + $r->lite_vf + $r->byu_vf + $r->my_telkomsel + $r->orbit
                        + ($r->perdana * 35000)
                        + ($r->lite * 35000)
                        + ($r->byu * 35000);
                });
        }

        return view('sales.dashboard', compact(
            'totalReport',
            'totalRevenue',
            'todayRevenue',
            'monthlyLabels',
            'monthlyRevenueTotals'
        ));
    }
}
