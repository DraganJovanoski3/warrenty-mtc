<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Installation #{{ $installation->id }}</h2>
                <p class="text-sm text-slate-500 mt-1">Proof of application details</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('installations.edit', $installation) }}" class="px-4 py-2 bg-slate-900 text-white text-sm rounded-md hover:bg-slate-800">Edit</a>
                <a href="{{ route('installations.index') }}" class="px-4 py-2 border border-slate-200 text-sm rounded-md hover:bg-slate-50">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-xs uppercase tracking-wide text-slate-500 mb-3">Customer / Company</h3>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-slate-500">Company Name</dt><dd class="font-medium">{{ $installation->company_name }}</dd></div>
                    <div><dt class="text-slate-500">Tax ID</dt><dd class="font-medium">{{ $installation->tax_id ?: '—' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-slate-500">Customer Address</dt><dd class="font-medium whitespace-pre-line">{{ $installation->customer_address }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-slate-500">Installer Company</dt><dd class="font-medium">{{ $installation->installer_company_name }}</dd></div>
                </dl>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-xs uppercase tracking-wide text-slate-500 mb-3">Truck</h3>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-slate-500">Truck Number</dt><dd class="font-mono font-medium">{{ $installation->truck_number }}</dd></div>
                    <div><dt class="text-slate-500">VIN</dt><dd class="font-mono font-medium">{{ $installation->vin }}</dd></div>
                    <div><dt class="text-slate-500">Mileage</dt><dd class="font-medium">{{ $installation->mileage_at_installation ?? '—' }}</dd></div>
                    <div><dt class="text-slate-500">Installation Date</dt><dd class="font-medium">{{ $installation->installation_date->format('Y-m-d') }}</dd></div>
                </dl>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-xs uppercase tracking-wide text-slate-500 mb-3">Proof Photos</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-slate-500 mb-2">VIN Photo</div>
                        @if ($installation->vinPhotoUrl())
                            <a href="{{ $installation->vinPhotoUrl() }}" target="_blank" rel="noopener">
                                <img src="{{ $installation->vinPhotoUrl() }}" alt="VIN proof" class="w-full max-h-72 object-contain rounded border border-slate-200 bg-slate-50">
                            </a>
                        @else
                            <p class="text-sm text-slate-400">No VIN photo uploaded.</p>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 mb-2">Mileage / Odometer Photo</div>
                        @if ($installation->mileagePhotoUrl())
                            <a href="{{ $installation->mileagePhotoUrl() }}" target="_blank" rel="noopener">
                                <img src="{{ $installation->mileagePhotoUrl() }}" alt="Mileage proof" class="w-full max-h-72 object-contain rounded border border-slate-200 bg-slate-50">
                            </a>
                        @else
                            <p class="text-sm text-slate-400">No mileage photo uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-xs uppercase tracking-wide text-slate-500 mb-3">Part &amp; Purchase</h3>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-slate-500">Part Number</dt><dd class="font-mono font-medium">{{ $installation->part_number }}</dd></div>
                    <div><dt class="text-slate-500">Part Description</dt><dd class="font-medium">{{ $installation->part_description }}</dd></div>
                    <div><dt class="text-slate-500">Invoice Number</dt><dd class="font-medium">{{ $installation->invoice_number ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Purchase Date</dt><dd class="font-medium">{{ optional($installation->invoice_date)->format('Y-m-d') ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Submitted At</dt><dd class="font-medium">{{ optional($installation->submitted_at)->format('Y-m-d H:i') ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Submitted by</dt><dd class="font-medium">{{ $installation->user?->name ?: 'Public form' }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
