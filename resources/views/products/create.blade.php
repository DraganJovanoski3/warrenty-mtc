@php
    $isEdit = isset($product);
    $action = $isEdit ? route('products.update', $product) : route('products.store');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ $isEdit ? 'Edit Product' : 'Add Product' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ $action }}" class="bg-white border border-slate-200 rounded-lg p-6 space-y-4">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div>
                    <x-input-label for="part_number" value="Part Number" />
                    <x-text-input id="part_number" name="part_number" class="block mt-1 w-full font-mono" :value="old('part_number', $product->part_number ?? '')" required />
                    <x-input-error :messages="$errors->get('part_number')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Part Description" />
                    <x-text-input id="description" name="description" class="block mt-1 w-full" :value="old('description', $product->description ?? '')" required />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <input type="hidden" name="is_active" value="0">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500"
                            @checked(old('is_active', $product->is_active ?? true))>
                        <span class="text-sm text-slate-700">Active (shown in installation form)</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-600 hover:underline">Cancel</a>
                    <x-primary-button class="!bg-amber-500 !text-slate-900 hover:!bg-amber-400">
                        {{ $isEdit ? 'Update Product' : 'Save Product' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
