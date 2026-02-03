@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

@section('content')

<div style="max-width:520px;">

    {{-- Error Message --}}
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('suppliers.update', $supplier->sup_id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:500;margin-bottom:6px;">Company Name</label>
            <input type="text"
                   name="com_name"
                   value="{{ old('com_name', $supplier->com_name) }}"
                   placeholder="Enter company name"
                   required
                   style="width:100%;padding:10px 12px;border:1px solid #cbd5f5;border-radius:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:500;margin-bottom:6px;">Contact Name</label>
            <input type="text"
                   name="contact_name"
                   value="{{ old('contact_name', $supplier->contact_name) }}"
                   placeholder="Enter contact name"
                   style="width:100%;padding:10px 12px;border:1px solid #cbd5f5;border-radius:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:500;margin-bottom:6px;">Phone</label>
            <input type="text"
                   name="phone"
                   value="{{ old('phone', $supplier->phone) }}"
                   placeholder="Enter phone"
                   style="width:100%;padding:10px 12px;border:1px solid #cbd5f5;border-radius:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:500;margin-bottom:6px;">Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $supplier->email) }}"
                   placeholder="Enter email"
                   style="width:100%;padding:10px 12px;border:1px solid #cbd5f5;border-radius:8px;">
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit"
                    style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
                Update
            </button>

            <a href="{{ route('suppliers.index') }}"
               style="padding:10px 16px;border-radius:8px;border:1px solid #cbd5f5;text-decoration:none;color:#1f2937;">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection
