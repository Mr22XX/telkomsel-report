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
        ->whereDate('tanggal', $today);
        // ->first();

    $totalQty = $todayReport->sum(DB::raw('perdana + byu + lite + orbit'));

    $totalRevenue = $todayReport->sum(DB::raw('
        cvm_byu + super_seru + digital + roaming +
        vf_hp + vf_lite_byu + lite_vf + byu_vf + my_telkomsel
    '));


        $year = now()->year;

        $monthlyData = DB::table('reports')
            ->selectRaw('
                MONTH(tanggal) as month,
                SUM(perdana + byu + lite + orbit) as total_qty,
                SUM(
                    cvm_byu + super_seru + digital + roaming +
                    vf_hp + vf_lite_byu + lite_vf + byu_vf + my_telkomsel
                ) as total_revenue
            ')
            ->whereYear('tanggal', $year)
            ->where('user_id', $userId)
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        // FIX biar Januari–Desember selalu ada
        $monthlyLabels = [];
        $monthlyQtyTotals = [];
        $monthlyRevenueTotals = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = Carbon::create()->month($m)->format('M');

            $found = $monthlyData->firstWhere('month', $m);

            $monthlyQtyTotals[] = $found ? $found->total_qty : 0;
            $monthlyRevenueTotals[] = $found ? $found->total_revenue : 0;
        }


        $chartQty = [
            'perdana' => $todayReport->sum('perdana'),
            'byu' => $todayReport->sum('byu'),
            'lite' => $todayReport->sum('lite'),
            'orbit' => $todayReport->sum('orbit'),
        ];


        $chartRevenue = [
            'cvm_byu' => $todayReport->sum('cvm_byu'),
            'super_seru' => $todayReport->sum('super_seru'),
            'digital' => $todayReport->sum('digital'),
            'roaming' => $todayReport->sum('roaming'),
            'vf_hp' => $todayReport->sum('vf_hp'),
            'vf_lite_byu' => $todayReport->sum('vf_lite_byu'),
            'lite_vf' => $todayReport->sum('lite_vf'),
            'byu_vf' => $todayReport->sum('byu_vf'),
            'my_telkomsel' => $todayReport->sum('my_telkomsel'),
        ];


        $totalReport = Report::where('user_id', $userId)
        ->whereDate('tanggal', $today)
        ->count();




    return view('sales.dashboard', [
    'totalReport' => $totalReport,
    'totalSellingToday' => $totalQty, 
    'monthlyLabels' => $monthlyLabels,
    'totalQty' => $totalQty,
    'totalRevenue' => $totalRevenue,
    'chartQty' => $chartQty,
    'chartRevenue' => $chartRevenue,
    'monthlyQtyTotals' => $monthlyQtyTotals,
    'monthlyRevenueTotals' => $monthlyRevenueTotals,
]);


}
}
