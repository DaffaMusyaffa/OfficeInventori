@extends('layouts.app')
@section('title', 'Profile')
@section('heading', 'Profile')

@section('content')
    <div class="mx-auto max-w-2xl space-y-6">
        <!-- Info Profil -->
        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="text-base font-semibold text-slate-800">Informasi Profil</h2>
            <p class="mb-5 text-sm text-slate-400">Perbarui nama dan email akun Anda.</p>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                    @error('name') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                    @error('email') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Role</label>
                    <input type="text" value="{{ ucfirst($user->role) }}" disabled
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-400">
                </div>
                <div class="flex justify-end">
                    <button class="rounded-lg bg-brand-blue px-5 py-2 text-sm font-semibold text-white hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Ganti Password -->
        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="text-base font-semibold text-slate-800">Ubah Password</h2>
            <p class="mb-5 text-sm text-slate-400">Pastikan menggunakan password yang aman.</p>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                    @error('current_password') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Password Baru</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                    @error('password') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                </div>
                <div class="flex justify-end">
                    <button class="rounded-lg bg-brand-blue px-5 py-2 text-sm font-semibold text-white hover:bg-blue-600">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
