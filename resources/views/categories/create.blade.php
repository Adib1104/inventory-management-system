@extends('layouts.app')

@section('title', 'Add Category')
@section('page-title', 'Add Category')

@section('content')

<div style="max-width:520px;">

    {{-- Error Message --}}
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:500;margin-bottom:6px;">
                Category Name
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Enter category name"
                   required
                   style="width:100%;padding:10px 12px;border:1px solid #cbd5f5;border-radius:8px;">
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit"
                    style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
                Save
            </button>

            <a href="{{ route('categories.index') }}"
               style="padding:10px 16px;border-radius:8px;border:1px solid #cbd5f5;text-decoration:none;color:#1f2937;">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection
