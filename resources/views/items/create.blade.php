@extends('layouts.app')

@section('title', 'Add Item')
@section('page-title', 'Add Item')

@section('content')

<div class="card" style="max-width:500px; padding:20px;">

    {{-- Error Message --}}
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('items.store') }}">
        @csrf

        <label>Item's Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required
               style="width:100%;padding:10px;margin-bottom:12px;border-radius:8px;border:1px solid #e5e7eb;">

        <label>Category</label><br>
        <select name="category_id" required
                style="width:100%;padding:10px;margin-bottom:12px;border-radius:8px;border:1px solid #e5e7eb;">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Supplier(s)</label><br>
        <select name="supplier_ids[]" multiple
                style="width:100%;padding:10px;margin-bottom:12px;border-radius:8px;border:1px solid #e5e7eb; height:120px;">
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->sup_id }}" {{ (collect(old('supplier_ids'))->contains($supplier->sup_id)) ? 'selected' : '' }}>
                    {{ $supplier->com_name }}
                </option>
            @endforeach
        </select>

        <label>Quantity</label><br>
        <input type="number" name="quantity" min="0" value="{{ old('quantity') }}" required
               style="width:100%;padding:10px;margin-bottom:12px;border-radius:8px;border:1px solid #e5e7eb;">

        <div style="display:flex;gap:10px;">
            <button type="submit"
                    style="background:#2563eb;color:white;padding:10px 14px;border:none;border-radius:8px;">
                Save
            </button>

            <a href="{{ route('items.index') }}"
               style="padding:10px 14px;border-radius:8px;border:1px solid #cbd5f5;text-decoration:none;color:#1f2937;">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
