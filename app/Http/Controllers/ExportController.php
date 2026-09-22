<?php

namespace App\Http\Controllers;

use App\Exports\InstallationsExport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('part_number')->get();

        return view('export.index', compact('products'));
    }

    public function download(Request $request): BinaryFileResponse
    {
        $filters = $request->validate([
            'product_id' => ['nullable', 'exists:products,id'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'submitted_from' => ['nullable', 'date'],
            'submitted_to' => ['nullable', 'date', 'after_or_equal:submitted_from'],
        ]);

        $filename = 'mtc-installations-'.now()->format('Y-m-d-His').'.xlsx';

        return Excel::download(new InstallationsExport($filters), $filename);
    }
}
