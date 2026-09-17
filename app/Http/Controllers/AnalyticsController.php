<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $dateFrom = $request->input('date_from', now()->subMonths(6)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());

        $base = Installation::query()
            ->whereDate('installation_date', '>=', $dateFrom)
            ->whereDate('installation_date', '<=', $dateTo);

        $totalInstallations = (clone $base)->count();
        $uniqueProducts = (clone $base)->distinct('product_id')->count('product_id');
        $uniqueTrucks = (clone $base)->distinct('vin')->count('vin');
        $uniqueCompanies = (clone $base)->distinct('company_name')->count('company_name');

        $byProduct = Product::query()
            ->withCount(['installations as installations_count' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereDate('installation_date', '>=', $dateFrom)
                    ->whereDate('installation_date', '<=', $dateTo);
            }])
            ->having('installations_count', '>', 0)
            ->orderByDesc('installations_count')
            ->limit(15)
            ->get();

        $driver = DB::getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', installation_date)"
            : "DATE_FORMAT(installation_date, '%Y-%m')";

        $byMonth = Installation::query()
            ->select(DB::raw("{$monthExpr} as month"), DB::raw('COUNT(*) as total'))
            ->whereDate('installation_date', '>=', $dateFrom)
            ->whereDate('installation_date', '<=', $dateTo)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recent = Installation::with('product')
            ->latest('installation_date')
            ->latest('id')
            ->limit(8)
            ->get();

        return view('analytics.index', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'totalInstallations' => $totalInstallations,
            'uniqueProducts' => $uniqueProducts,
            'uniqueTrucks' => $uniqueTrucks,
            'uniqueCompanies' => $uniqueCompanies,
            'byProduct' => $byProduct,
            'byMonth' => $byMonth,
            'recent' => $recent,
            'maxProductCount' => max(1, (int) $byProduct->max('installations_count')),
        ]);
    }
}
