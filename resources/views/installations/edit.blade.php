@php
    $isEdit = isset($installation);
    $action = $isEdit ? route('installations.update', $installation) : route('installations.store');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ $isEdit ? 'Edit Installation Record' : 'INSTALLATION INFORMATION & PROOF OF APPLICATION' }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Fill in customer, truck and part details</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ $action }}" class="space-y-6" id="installation-form">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- CUSTOMER / COMPANY --}}
                <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                    <div class="bg-slate-900 text-white px-5 py-3">
                        <h3 class="font-semibold tracking-wide text-sm uppercase">Customer / Company Information</h3>
                    </div>
                    <div class="p-5 grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="company_name" value="1. Company Name" />
                            <x-text-input id="company_name" name="company_name" class="block mt-1 w-full" :value="old('company_name', $installation->company_name ?? '')" required />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tax_id" value="2. Tax ID" />
                            <x-text-input id="tax_id" name="tax_id" class="block mt-1 w-full" :value="old('tax_id', $installation->tax_id ?? '')" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="installer_company_name" value="4. Installer Company Name" />
                            <x-text-input id="installer_company_name" name="installer_company_name" class="block mt-1 w-full" :value="old('installer_company_name', $installation->installer_company_name ?? '')" required />
                            <x-input-error :messages="$errors->get('installer_company_name')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="customer_address" value="3. Customer Address" />
                            <textarea id="customer_address" name="customer_address" rows="3" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>{{ old('customer_address', $installation->customer_address ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
                        </div>
                    </div>
                </section>

                {{-- TRUCK --}}
                <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                    <div class="bg-slate-900 text-white px-5 py-3">
                        <h3 class="font-semibold tracking-wide text-sm uppercase">Truck Information</h3>
                    </div>
                    <div class="p-5 grid sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="truck_number" value="1. Truck Number" />
                            <x-text-input id="truck_number" name="truck_number" class="block mt-1 w-full" :value="old('truck_number', $installation->truck_number ?? '')" required />
                            <x-input-error :messages="$errors->get('truck_number')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="vin" value="2. VIN (Vehicle Identification Number)" />
                            <x-text-input id="vin" name="vin" class="block mt-1 w-full font-mono" :value="old('vin', $installation->vin ?? '')" required />
                            <x-input-error :messages="$errors->get('vin')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="mileage_at_installation" value="3. Mileage at Installation" />
                            <x-text-input id="mileage_at_installation" name="mileage_at_installation" type="number" min="0" class="block mt-1 w-full" :value="old('mileage_at_installation', $installation->mileage_at_installation ?? '')" />
                            <x-input-error :messages="$errors->get('mileage_at_installation')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="installation_date" value="4. Installation Date" />
                            <x-text-input id="installation_date" name="installation_date" type="date" class="block mt-1 w-full" :value="old('installation_date', isset($installation) ? $installation->installation_date->format('Y-m-d') : now()->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('installation_date')" class="mt-2" />
                        </div>
                    </div>
                </section>

                {{-- PART & PURCHASE --}}
                <section class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                    <div class="bg-slate-900 text-white px-5 py-3">
                        <h3 class="font-semibold tracking-wide text-sm uppercase">Part &amp; Purchase Information</h3>
                    </div>
                    <div class="p-5 grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="product_id" value="Select Product" />
                            <select id="product_id" name="product_id" required class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                                data-products='@json($products->map(fn($p) => ["id" => $p->id, "part_number" => $p->part_number, "description" => $p->description]))'>
                                <option value="">— Choose product —</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id', $installation->product_id ?? '') == $product->id)>
                                        {{ $product->part_number }} — {{ $product->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                            @if ($products->isEmpty())
                                <p class="mt-2 text-sm text-amber-700">No active products. <a href="{{ route('products.create') }}" class="underline">Add a product</a> first.</p>
                            @endif
                        </div>
                        <div>
                            <x-input-label for="part_number_display" value="1. Part Number" />
                            <input id="part_number_display" type="text" readonly class="block mt-1 w-full rounded-md border-slate-200 bg-slate-50 text-slate-600 shadow-sm font-mono" value="{{ old('part_number', $installation->part_number ?? '') }}">
                        </div>
                        <div>
                            <x-input-label for="part_description_display" value="2. Part Description" />
                            <input id="part_description_display" type="text" readonly class="block mt-1 w-full rounded-md border-slate-200 bg-slate-50 text-slate-600 shadow-sm" value="{{ old('part_description', $installation->part_description ?? '') }}">
                        </div>
                        <div>
                            <x-input-label for="invoice_number" value="3. Invoice Number" />
                            <x-text-input id="invoice_number" name="invoice_number" class="block mt-1 w-full" :value="old('invoice_number', $installation->invoice_number ?? '')" />
                            <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="invoice_date" value="4. Purchase Date" />
                            <x-text-input id="invoice_date" name="invoice_date" type="date" class="block mt-1 w-full" :value="old('invoice_date', isset($installation) && $installation->invoice_date ? $installation->invoice_date->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('invoice_date')" class="mt-2" />
                        </div>
                        @unless ($isEdit)
                            <div class="sm:col-span-2 rounded-md bg-slate-50 border border-slate-200 px-4 py-3 text-sm text-slate-600">
                                Submitted date will be set automatically when you save.
                            </div>
                        @endunless
                    </div>
                </section>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('installations.index') }}" class="text-sm text-slate-600 hover:underline">Cancel</a>
                    <x-primary-button class="!bg-amber-500 !text-slate-900 hover:!bg-amber-400 focus:!bg-amber-500 active:!bg-amber-600">
                        {{ $isEdit ? 'Update Record' : 'Save Installation' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
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
</x-app-layout>
