@extends('layouts.app')
@section('title', 'Users')
@section('heading', 'Kelola Users')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white">
        <div class="flex items-center justify-between border-b border-slate-100 p-5">
            <h2 class="text-base font-semibold text-slate-800">Daftar User</h2>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand-blue px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
                @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
                Tambah User
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium">Total Request</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-blue text-xs font-semibold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <span class="font-medium text-slate-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-brand-purple' : 'bg-blue-100 text-brand-blue' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $user->requests_count }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-brand-blue" title="Edit">
                                        @include('partials.icon', ['name' => 'edit', 'class' => 'h-4 w-4'])
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              @submit.prevent="$dispatch('confirm', { title: 'Hapus User', message: 'Yakin hapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.', danger: true, form: $el })">
                                            @csrf @method('DELETE')
                                            <button class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-brand-red" title="Hapus">
                                                @include('partials.icon', ['name' => 'trash', 'class' => 'h-4 w-4'])
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-5 py-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
