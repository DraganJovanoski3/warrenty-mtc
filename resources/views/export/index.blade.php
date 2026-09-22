<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Excel Export</h2>
        <p class="text-sm text-slate-500 mt-1">Download installation data filtered by product, installation date, or submitted date</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('export.download') }}" class="bg-white border border-slate-200 rounded-lg p-6 space-y-4">
                <div>
                    <x-input-label for="product_id" value="Product (optional)" />
                    <select id="product_id" name="product_id" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">All products</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->part_number }} — {{ $product->description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="date_from" value="Installation from" />
                        <x-text-input id="date_from" name="date_from" type="date" class="block mt-1 w-full" />
                    </div>
                    <div>
                        <x-input-label for="date_to" value="Installation to" />
                        <x-text-input id="date_to" name="date_to" type="date" class="block mt-1 w-full" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="submitted_from" value="Submitted from" />
                        <x-text-input id="submitted_from" name="submitted_from" type="date" class="block mt-1 w-full" />
                    </div>
                    <div>
                        <x-input-label for="submitted_to" value="Submitted to" />
                        <x-text-input id="submitted_to" name="submitted_to" type="date" class="block mt-1 w-full" />
                    </div>
                </div>

                <p class="text-xs text-slate-500">Leave filters empty to export all records.</p>

                <div class="pt-2">
                    <x-primary-button class="!bg-emerald-600 hover:!bg-emerald-500 focus:!bg-emerald-600">
                        Download Excel (.xlsx)
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
