<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstallationController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['product_id', 'date_from', 'date_to', 'submitted_from', 'submitted_to', 'search']);

        $installations = Installation::query()
            ->with('product')
            ->filtered($filters)
            ->latest('installation_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $products = Product::orderBy('part_number')->get();

        return view('installations.index', compact('installations', 'products', 'filters'));
    }

    public function create(): View
    {
        $products = Product::active()->orderBy('part_number')->get();

        return view('installations.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);

        $product = Product::findOrFail($data['product_id']);
        unset($data['vin_photo'], $data['mileage_photo']);

        $installation = Installation::create([
            ...$data,
            'part_number' => $product->part_number,
            'part_description' => $product->description,
            'user_id' => $request->user()->id,
        ]);

        $this->storeProofPhotos(
            $installation,
            $request->file('vin_photo'),
            $request->file('mileage_photo')
        );

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation record saved successfully.');
    }

    public function show(Installation $installation): View
    {
        $installation->load('product', 'user');

        return view('installations.show', compact('installation'));
    }

    public function edit(Installation $installation): View
    {
        $products = Product::active()->orderBy('part_number')->get();

        if ($installation->product && ! $products->contains('id', $installation->product_id)) {
            $products->prepend($installation->product);
        }

        return view('installations.edit', compact('installation', 'products'));
    }

    public function update(Request $request, Installation $installation): RedirectResponse
    {
        $data = $this->validated($request, false);

        $product = Product::findOrFail($data['product_id']);
        unset($data['vin_photo'], $data['mileage_photo']);

        $installation->update([
            ...$data,
            'part_number' => $product->part_number,
            'part_description' => $product->description,
        ]);

        if ($request->hasFile('vin_photo')) {
            $this->replacePhoto($installation, 'vin_photo', $request->file('vin_photo'));
        }

        if ($request->hasFile('mileage_photo')) {
            $this->replacePhoto($installation, 'mileage_photo', $request->file('mileage_photo'));
        }

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation record updated.');
    }

    public function destroy(Installation $installation): RedirectResponse
    {
        $installation->delete();

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation record deleted.');
    }

    private function validated(Request $request, bool $photosRequired): array
    {
        $photoRules = $photosRequired
            ? ['required', 'image', 'max:5120']
            : ['nullable', 'image', 'max:5120'];

        return $request->validate([
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
            'vin_photo' => $photoRules,
            'mileage_photo' => $photoRules,
        ]);
    }

    private function storeProofPhotos(Installation $installation, UploadedFile $vinPhoto, UploadedFile $mileagePhoto): void
    {
        $folder = 'installations/'.$installation->id;

        $installation->update([
            'vin_photo' => $vinPhoto->store($folder, 'public'),
            'mileage_photo' => $mileagePhoto->store($folder, 'public'),
        ]);
    }

    private function replacePhoto(Installation $installation, string $field, UploadedFile $file): void
    {
        if ($installation->{$field}) {
            Storage::disk('public')->delete($installation->{$field});
        }

        $installation->update([
            $field => $file->store('installations/'.$installation->id, 'public'),
        ]);
    }
}
