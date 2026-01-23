<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesDashboardController extends Controller
{
    public function index()
{
    $userId = Auth::id();
    $today = Carbon::today();

    $todayReport = Report::where('user_id', $userId)
        // ->whereDate('tanggal', $today)
        ->first();

    $todayQty = $todayReport
    ? ($todayReport->perdana
     + $todayReport->byu
     + $todayReport->lite
     + $todayReport->orbit)
    : 0;

    $todayRevenue = $todayReport
    ? ($todayReport->cvm_byu
     + $todayReport->super_seru
     + $todayReport->digital
     + $todayReport->roaming
     + $todayReport->vf_hp
     + $todayReport->vf_lite_byu
     + $todayReport->lite_vf
     + $todayReport->byu_vf
     + $todayReport->my_telkomsel)
    : 0;


        $year = now()->year;

        $monthlyData = DB::table('reports')
            ->selectRaw('
                MONTH(tanggal) as month,
                SUM(
                    perdana + byu + lite + orbit + cvm_byu + super_seru +
                    digital + roaming + vf_hp + vf_lite_byu +
                    lite_vf + byu_vf + my_telkomsel
                ) as total 
            ')
            ->whereYear('tanggal', $year)
            ->where('user_id', $userId)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // FIX biar Januari–Desember selalu ada
        $monthlyLabels = [];
        $monthlyTotals = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = Carbon::create()->month($m)->format('M');
            $found = $monthlyData->firstWhere('month', $m);
            $monthlyTotals[] = $found ? $found->total : 0;
        }



    return view('sales.dashboard', [
        'totalReport' => Report::where('user_id', $userId)->count(),
        'totalSellingToday' => $todayReport
            ? $todayReport -> totalSelling()
            : 0,
        'monthlyLabels' => $monthlyLabels,
        'monthlyTotals'=> $monthlyTotals,
        'totalQty' => $todayReport ? $todayReport->totalQty() : 0,
        'totalRevenue' => $todayReport ? $todayReport->totalRevenue() : 0,


        // DATA CHART
        'chartData' => [
            'perdana' => $todayReport->perdana ?? 0,
            'byu' => $todayReport->byu ?? 0,
            'lite' => $todayReport->lite ?? 0,
            'orbit' => $todayReport->orbit ?? 0,
            'cvm_byu' => $todayReport->cvm_byu ?? 0,
            'super_seru' => $todayReport->super_seru ?? 0,
            'digital' => $todayReport->digital ?? 0,
            'roaming' => $todayReport->roaming ?? 0,
            'vf_hp' => $todayReport->vf_hp ?? 0,
            'vf_lite_byu' => $todayReport->vf_lite_byu ?? 0,
            'lite_vf' => $todayReport->lite_vf ?? 0,
            'byu_vf' => $todayReport->byu_vf ?? 0,
            'my_telkomsel' => $todayReport->my_telkomsel ?? 0,
        ]
    ]);
}
}
