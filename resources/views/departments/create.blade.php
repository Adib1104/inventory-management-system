@extends('layouts.app')

@section('title', 'Add Department')
@section('page-title', 'Add Department')

@section('content')

{{-- Error Message --}}
@if($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;">
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('departments.store') }}"
      style="background:white;padding:20px;border-radius:10px;max-width:520px;">
    @csrf

    {{-- Department Name --}}
    <div style="margin-bottom:16px;">
        <label style="display:block;font-weight:600;margin-bottom:6px;">
            Department Name
        </label>
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               required
               placeholder=""
               style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;">
    </div>

    {{-- Location --}}
    <div style="margin-bottom:16px;">
        <label style="display:block;font-weight:600;margin-bottom:6px;">
            Location
        </label>
        <input type="text"
               name="location"
               value="{{ old('location') }}"
               placeholder=""
               style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;">
    </div>

    {{-- Actions --}}
    <div style="display:flex;gap:10px;">
        <button type="submit"
                style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
            Save
        </button>

        <a href="{{ route('departments.index') }}"
           style="padding:10px 16px;border-radius:8px;border:1px solid #cbd5f5;text-decoration:none;color:#374151;">
            Cancel
        </a>
    </div>
</form>

@endsection
