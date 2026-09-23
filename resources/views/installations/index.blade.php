<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Installation Records</h2>
                <p class="text-sm text-slate-500 mt-1">Filter and browse saved proofs of application</p>
            </div>
            <a href="{{ route('installations.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-slate-900 text-sm font-semibold rounded-md hover:bg-amber-400">+ New Installation</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <form method="GET" class="bg-white border border-slate-200 rounded-lg p-4 grid sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-3 items-end">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Product</label>
                    <select name="product_id" class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">All products</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(($filters['product_id'] ?? '') == $product->id)>{{ $product->part_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Install from</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Install to</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Submitted from</label>
                    <input type="date" name="submitted_from" value="{{ $filters['submitted_from'] ?? '' }}" class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Submitted to</label>
                    <input type="date" name="submitted_to" value="{{ $filters['submitted_to'] ?? '' }}" class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Company, VIN, invoice..." class="w-full rounded-md border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-3 py-2 bg-slate-900 text-white text-sm rounded-md hover:bg-slate-800">Filter</button>
                    <a href="{{ route('installations.index') }}" class="px-3 py-2 text-sm text-slate-600 border border-slate-200 rounded-md hover:bg-slate-50">Reset</a>
                </div>
            </form>

            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-left">
                            <tr>
                                <th class="px-4 py-3 font-medium">Install date</th>
                                <th class="px-4 py-3 font-medium">Submitted</th>
                                <th class="px-4 py-3 font-medium">Company</th>
                                <th class="px-4 py-3 font-medium">Truck / VIN</th>
                                <th class="px-4 py-3 font-medium">Part</th>
                                <th class="px-4 py-3 font-medium">Invoice</th>
                                <th class="px-4 py-3 font-medium">Proof</th>
                                <th class="px-4 py-3 font-medium"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($installations as $item)
                                <tr class="border-t border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $item->installation_date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-600">
                                        {{ optional($item->submitted_at)->format('Y-m-d H:i') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $item->company_name }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-mono">{{ $item->truck_number }}</div>
                                        <div class="text-xs text-slate-500 font-mono">{{ $item->vin }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-mono">{{ $item->part_number }}</div>
                                        <div class="text-xs text-slate-500">{{ Str::limit($item->part_description, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $item->invoice_number ?: '—' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->hasProofPhotos())
                                            <span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Yes</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-500 border border-slate-200">No</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <a href="{{ route('installations.show', $item) }}" class="text-amber-700 hover:underline">View</a>
                                        <a href="{{ route('installations.edit', $item) }}" class="ms-3 text-slate-600 hover:underline">Edit</a>
                                        <form action="{{ route('installations.destroy', $item) }}" method="POST" class="inline ms-3" onsubmit="return confirm('Delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-slate-500">No installation records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($installations->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100">{{ $installations->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
