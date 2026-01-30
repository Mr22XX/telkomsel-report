<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $year = now()->year;

        // Summary
        $totalReport = Report::whereDate('tanggal',$today)->count();

        // $totalQty = Report::whereDate('tanggal',$today)
        //     ->sum(DB::raw('perdana + byu + lite + orbit'));

        $totalRevenue = Report::whereDate('tanggal',$today)
            ->sum(DB::raw('
                cvm_byu + super_seru + digital + roaming +
                vf_hp + vf_lite_byu + lite_vf + byu_vf + my_telkomsel + orbit + (perdana * 35000)
                + (lite * 35000) + (byu * 35000)
            '));

        // Ranking sales
        $ranking = Report::select(
            'users.name',
            DB::raw('SUM(perdana + byu + lite + orbit) as total_qty'),
            DB::raw('SUM(
                cvm_byu + super_seru + digital + roaming +
                vf_hp + vf_lite_byu + lite_vf + byu_vf + my_telkomsel + orbit + (perdana * 35000)
                + (lite * 35000) + (byu * 35000)
            ) as total_revenue')
        )
        ->join('users','reports.user_id','=','users.id')
        ->whereYear('tanggal', $year)
        ->groupBy('users.name')
        ->orderByDesc('total_revenue')
        ->orderByDesc('total_qty')
        ->limit(5)
        ->get();

        // =====================
        // DATA BULANAN (GRAFIK)
        // =====================
        $monthlyData = Report::selectRaw('
                MONTH(tanggal) as month,
                SUM(perdana + byu + lite + orbit) as total_qty,
                SUM(
                    cvm_byu + super_seru + digital + roaming +
                    vf_hp + vf_lite_byu + lite_vf + byu_vf + my_telkomsel + orbit + (perdana * 35000)
                + (lite * 35000) + (byu * 35000)
                ) as total_revenue
            ')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyQtyTotals = [];
        $monthlyRevenueTotals = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = Carbon::create()->month($m)->format('M');

            $found = $monthlyData->firstWhere('month', $m);

            $monthlyQtyTotals[] = $found ? $found->total_qty : 0;
            $monthlyRevenueTotals[] = $found ? $found->total_revenue : 0;
        }

        return view('manager.dashboard', compact(
            'totalReport',
            // 'totalQty',
            'totalRevenue',
            'ranking',
            'monthlyLabels',
            'monthlyQtyTotals',
            'monthlyRevenueTotals'
        ));
    }


public function monitoring()
{
    $today = Carbon::today();

    $sales = User::where('role','sales')
        ->with(['reports' => function($q) use ($today){
            $q->whereDate('tanggal',$today);
        }])
        ->get();

    return view('manager.monitoring', compact('sales'));
}

public function rekap(Request $request)
{
    $startDate = $request->start_date;
    $endDate   = $request->end_date;
    $salesName = $request->sales;

    $query = Report::with('user');

    // Filter tanggal hanya jika diisi
    if (!empty($startDate) && !empty($endDate)) {
        $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    // Filter nama sales
    if (!empty($salesName)) {
        $query->whereHas('user', function($q) use ($salesName){
            $q->where('name','like','%'.$salesName.'%');
        });
    }

    // DEFAULT: tampilkan semua data
    $reports = $query->orderBy('tanggal','desc')->paginate(10);

    return view('manager.rekap', compact(
        'reports','startDate','endDate','salesName'
    ));
}


}
