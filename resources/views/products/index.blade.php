<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Products</h2>
                <p class="text-sm text-slate-500 mt-1">Catalog used in the installation form</p>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-slate-900 text-sm font-semibold rounded-md hover:bg-amber-400">+ Add Product</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium">Part Number</th>
                            <th class="px-4 py-3 font-medium">Description</th>
                            <th class="px-4 py-3 font-medium">Installations</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-mono font-medium">{{ $product->part_number }}</td>
                                <td class="px-4 py-3">{{ $product->description }}</td>
                                <td class="px-4 py-3">{{ $product->installations_count }}</td>
                                <td class="px-4 py-3">
                                    @if ($product->is_active)
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <a href="{{ route('products.edit', $product) }}" class="text-amber-700 hover:underline">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline ms-3" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-500">No products yet. Add your first part.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($products->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
