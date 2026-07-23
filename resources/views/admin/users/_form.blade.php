@php $u = $user ?? null; @endphp
<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama <span class="text-brand-red">*</span></label>
        <input type="text" name="name" value="{{ old('name', $u->name ?? '') }}" required
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('name') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Email <span class="text-brand-red">*</span></label>
        <input type="email" name="email" value="{{ old('email', $u->email ?? '') }}" required
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('email') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Role <span class="text-brand-red">*</span></label>
        <select name="role" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
            <option value="employee" @selected(old('role', $u->role ?? 'employee') === 'employee')>Employee</option>
            <option value="admin" @selected(old('role', $u->role ?? '') === 'admin')>Admin</option>
        </select>
        @error('role') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Password @if (! $u) <span class="text-brand-red">*</span> @else <span class="text-xs font-normal text-slate-400">(kosongkan bila tidak diubah)</span> @endif
        </label>
        <input type="password" name="password" {{ $u ? '' : 'required' }}
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('password') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
    </div>
</div>
