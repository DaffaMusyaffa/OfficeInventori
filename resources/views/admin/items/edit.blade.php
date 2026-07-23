@extends('layouts.app')
@section('title', 'Edit Barang')
@section('heading', 'Edit Barang')

@section('content')
    <div class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('admin.items.update', $item) }}">
            @csrf @method('PUT')
            @include('admin.items._form')

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.items.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</a>
                <button class="rounded-lg bg-brand-blue px-5 py-2 text-sm font-semibold text-white hover:bg-blue-600">Perbarui</button>
            </div>
        </form>
    </div>

    <datalist id="categories">
        <option value="Elektronik"><option value="ATK"><option value="Furnitur">
    </datalist>
@endsection
