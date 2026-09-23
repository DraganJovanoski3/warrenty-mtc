<x-public-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-5 sm:mb-6">
            <h1 class="font-semibold text-lg sm:text-xl text-slate-800 leading-tight">INSTALLATION INFORMATION &amp; PROOF OF APPLICATION</h1>
            <p class="text-sm text-slate-500 mt-1">Fill in customer, truck and part details. Submitted date is set automatically.</p>
            <div class="mt-4 rounded-md bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-950">
                <strong>Important:</strong> Warranty must be claimed within <strong>30 days</strong> of purchase.
                See the <a href="{{ route('pages.warranty-policy') }}" class="underline font-medium hover:text-amber-800">Warranty Policy</a> for details.
            </div>
        </div>

        <form method="POST" action="{{ route('public.submit') }}" class="space-y-5 sm:space-y-6" id="installation-form" enctype="multipart/form-data">
            @csrf

            <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="bg-slate-900 text-white px-4 sm:px-5 py-3">
                    <h2 class="font-semibold tracking-wide text-sm uppercase">Customer / Company Information</h2>
                </div>
                <div class="p-4 sm:p-5 grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <x-input-label for="company_name" value="1. Company Name" />
                        <x-text-input id="company_name" name="company_name" class="block mt-1 w-full" :value="old('company_name')" required autocomplete="organization" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="tax_id" value="2. Tax ID" />
                        <x-text-input id="tax_id" name="tax_id" class="block mt-1 w-full" :value="old('tax_id')" />
                        <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="installer_company_name" value="4. Installer Company Name" />
                        <x-text-input id="installer_company_name" name="installer_company_name" class="block mt-1 w-full" :value="old('installer_company_name')" required />
                        <x-input-error :messages="$errors->get('installer_company_name')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="customer_address" value="3. Customer Address" />
                        <textarea id="customer_address" name="customer_address" rows="3" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-base" required>{{ old('customer_address') }}</textarea>
                        <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
                    </div>
                </div>
            </section>

            <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="bg-slate-900 text-white px-4 sm:px-5 py-3">
                    <h2 class="font-semibold tracking-wide text-sm uppercase">Truck Information</h2>
                </div>
                <div class="p-4 sm:p-5 grid sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="truck_number" value="1. Truck Number" />
                        <x-text-input id="truck_number" name="truck_number" class="block mt-1 w-full" :value="old('truck_number')" required />
                        <x-input-error :messages="$errors->get('truck_number')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="vin" value="2. VIN (Vehicle Identification Number)" />
                        <x-text-input id="vin" name="vin" class="block mt-1 w-full font-mono" :value="old('vin')" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('vin')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="mileage_at_installation" value="3. Mileage at Installation" />
                        <x-text-input id="mileage_at_installation" name="mileage_at_installation" type="number" min="0" inputmode="numeric" class="block mt-1 w-full" :value="old('mileage_at_installation')" />
                        <x-input-error :messages="$errors->get('mileage_at_installation')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="installation_date" value="4. Installation Date" />
                        <x-text-input id="installation_date" name="installation_date" type="date" class="block mt-1 w-full" :value="old('installation_date', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('installation_date')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2 rounded-md bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-900">
                        Upload clear photos of the VIN plate and odometer as proof. On a phone you can take a photo directly.
                    </div>
                    <div>
                        <x-input-label for="vin_photo" value="5. VIN Photo" />
                        <input id="vin_photo" name="vin_photo" type="file" accept="image/*" capture="environment" required class="form-file-input" />
                        <x-input-error :messages="$errors->get('vin_photo')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="mileage_photo" value="6. Mileage / Odometer Photo" />
                        <input id="mileage_photo" name="mileage_photo" type="file" accept="image/*" capture="environment" required class="form-file-input" />
                        <x-input-error :messages="$errors->get('mileage_photo')" class="mt-2" />
                    </div>
                </div>
            </section>

            <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="bg-slate-900 text-white px-4 sm:px-5 py-3">
                    <h2 class="font-semibold tracking-wide text-sm uppercase">Part &amp; Purchase Information</h2>
                </div>
                <div class="p-4 sm:p-5 grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <x-input-label for="product_id" value="Select Product" />
                        @php
                            $productOptions = $products->map(fn ($p) => [
                                'id' => $p->id,
                                'part_number' => $p->part_number,
                                'description' => $p->description,
                            ])->values();
                        @endphp
                        <select id="product_id" name="product_id" required class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-base"
                            data-products='@json($productOptions)'>
                            <option value="">— Choose product —</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                    {{ $product->part_number }} — {{ $product->description }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        @if ($products->isEmpty())
                            <p class="mt-2 text-sm text-amber-700">No products are available yet. Please contact MTC staff.</p>
                        @endif
                    </div>
                    <div>
                        <x-input-label for="part_number_display" value="1. Part Number" />
                        <input id="part_number_display" type="text" readonly class="block mt-1 w-full rounded-md border-slate-200 bg-slate-50 text-slate-600 shadow-sm font-mono text-base" value="">
                    </div>
                    <div>
                        <x-input-label for="part_description_display" value="2. Part Description" />
                        <input id="part_description_display" type="text" readonly class="block mt-1 w-full rounded-md border-slate-200 bg-slate-50 text-slate-600 shadow-sm text-base" value="">
                    </div>
                    <div>
                        <x-input-label for="invoice_number" value="3. Invoice Number" />
                        <x-text-input id="invoice_number" name="invoice_number" class="block mt-1 w-full" :value="old('invoice_number')" />
                        <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="invoice_date" value="4. Purchase Date" />
                        <x-text-input id="invoice_date" name="invoice_date" type="date" class="block mt-1 w-full" :value="old('invoice_date')" />
                        <x-input-error :messages="$errors->get('invoice_date')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2 rounded-md bg-slate-50 border border-slate-200 px-4 py-3 text-sm text-slate-600">
                        Submitted date will be set automatically when you save.
                    </div>
                </div>
            </section>

            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 sticky bottom-0 sm:static bg-slate-100/95 sm:bg-transparent py-3 -mx-4 px-4 sm:mx-0 sm:px-0 border-t border-slate-200 sm:border-0 backdrop-blur sm:backdrop-blur-none">
                <button type="submit"
                    class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 sm:py-2.5 bg-amber-500 border border-transparent rounded-md font-semibold text-sm text-slate-900 uppercase tracking-widest hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50"
                    @if ($products->isEmpty()) disabled @endif>
                    Submit Installation
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('product_id');
            const partNumber = document.getElementById('part_number_display');
            const partDesc = document.getElementById('part_description_display');
            const products = JSON.parse(select.dataset.products || '[]');

            const sync = () => {
                const product = products.find(p => String(p.id) === String(select.value));
                partNumber.value = product ? product.part_number : '';
                partDesc.value = product ? product.description : '';
            };

            select.addEventListener('change', sync);
            sync();
        });
    </script>
</x-public-layout>
