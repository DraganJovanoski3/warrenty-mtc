<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicInstallationController extends Controller
{
    public function create(): View
    {
        $products = Product::active()->orderBy('part_number')->get();

        return view('public.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:100'],
            'customer_address' => ['required', 'string', 'max:1000'],
            'installer_company_name' => ['required', 'string', 'max:255'],
            'truck_number' => ['required', 'string', 'max:100'],
            'vin' => ['required', 'string', 'max:100'],
            'mileage_at_installation' => ['nullable', 'integer', 'min:0'],
            'installation_date' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'invoice_number' => ['nullable', 'string', 'max:100'],
            'invoice_date' => ['nullable', 'date'],
        ]);

        $product = Product::active()->findOrFail($data['product_id']);

        Installation::create([
            ...$data,
            'part_number' => $product->part_number,
            'part_description' => $product->description,
            'user_id' => null,
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('public.form')
            ->with('success', 'Thank you. Your installation information has been submitted successfully.');
    }
}
