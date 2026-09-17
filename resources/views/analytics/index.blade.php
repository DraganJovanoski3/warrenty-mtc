<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Product Analytics</h2>
                <p class="text-sm text-slate-500 mt-1">Installation volumes by product and period</p>
            </div>
            <form method="GET" class="flex flex-wrap items-end gap-2">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">From</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">To</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <button class="inline-flex items-center px-3 py-2 bg-slate-900 text-white text-sm rounded-md hover:bg-slate-800">Apply</button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Installations</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalInstallations }}</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Products used</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $uniqueProducts }}</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Unique trucks (VIN)</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $uniqueTrucks }}</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Companies</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $uniqueCompanies }}</div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-lg p-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Top products</h3>
                    @forelse ($byProduct as $product)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-mono text-slate-700">{{ $product->part_number }}</span>
                                <span class="font-semibold">{{ $product->installations_count }}</span>
                            </div>
                            <div class="text-xs text-slate-500 mb-1 truncate">{{ $product->description }}</div>
                            <div class="h-2 bg-slate-100 rounded overflow-hidden">
                                <div class="h-full bg-amber-500 rounded" style="width: {{ ($product->installations_count / $maxProductCount) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No installations in this period.</p>
                    @endforelse
                </div>

                <div class="bg-white border border-slate-200 rounded-lg p-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Installations by month</h3>
                    @forelse ($byMonth as $row)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0 text-sm">
                            <span class="font-mono text-slate-600">{{ $row->month }}</span>
                            <span class="font-semibold text-slate-900">{{ $row->total }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No monthly data yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Recent installations</h3>
                    <a href="{{ route('installations.create') }}" class="text-sm text-amber-700 hover:underline font-medium">+ New record</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-left">
                            <tr>
                                <th class="px-4 py-3 font-medium">Date</th>
                                <th class="px-4 py-3 font-medium">Company</th>
                                <th class="px-4 py-3 font-medium">Truck</th>
                                <th class="px-4 py-3 font-medium">Part</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recent as $item)
                                <tr class="border-t border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $item->installation_date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">{{ $item->company_name }}</td>
                                    <td class="px-4 py-3 font-mono">{{ $item->truck_number }}</td>
                                    <td class="px-4 py-3 font-mono">{{ $item->part_number }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No records yet. Create your first installation.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
