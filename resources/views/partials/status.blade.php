@php
    $map = [
        'pending' => ['Pending', 'bg-amber-100 text-amber-700'],
        'approved' => ['Approved', 'bg-green-100 text-green-700'],
        'rejected' => ['Rejected', 'bg-red-100 text-red-700'],
        'return_requested' => ['Menunggu Retur', 'bg-orange-100 text-orange-700'],
        'returned' => ['Dikembalikan', 'bg-sky-100 text-sky-700'],
    ];
    [$label, $classes] = $map[$status] ?? [ucfirst($status), 'bg-slate-100 text-slate-600'];
@endphp
<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $classes }}">{{ $label }}</span>
