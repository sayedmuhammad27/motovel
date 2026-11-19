@props(['status', 'type' => 'service'])

@php
    $classes = '';
    $label = '';
    $dotColor = '';

    if ($type === 'service') {
        switch ($status) {
            case 'waiting':
                $classes = 'bg-amber-500/10 text-amber-400 border-amber-500/30';
                $dotColor = 'bg-amber-400';
                $label = 'Menunggu';
                break;
            case 'in_progress':
                $classes = 'bg-blue-500/10 text-blue-400 border-blue-500/30';
                $dotColor = 'bg-blue-400 animate-pulse';
                $label = 'Sedang Dikerjakan';
                break;
            case 'completed':
                $classes = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30';
                $dotColor = 'bg-emerald-400';
                $label = 'Selesai';
                break;
            case 'cancelled':
                $classes = 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30';
                $dotColor = 'bg-zinc-400';
                $label = 'Dibatalkan';
                break;
            default:
                $classes = 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30';
                $dotColor = 'bg-zinc-400';
                $label = ucfirst($status);
        }
    } elseif ($type === 'payment') {
        switch ($status) {
            case 'paid':
                $classes = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30';
                $dotColor = 'bg-emerald-400';
                $label = 'Lunas';
                break;
            case 'pending':
                $classes = 'bg-amber-500/10 text-amber-400 border-amber-500/30';
                $dotColor = 'bg-amber-400';
                $label = 'Belum Lunas';
                break;
            default:
                $classes = 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30';
                $dotColor = 'bg-zinc-400';
                $label = ucfirst($status);
        }
    } elseif ($type === 'vehicle') {
        switch ($status) {
            case 'matic':
                $classes = 'bg-purple-500/10 text-purple-400 border-purple-500/30';
                $dotColor = 'bg-purple-400';
                $label = 'Matic';
                break;
            case 'manual':
                $classes = 'bg-sky-500/10 text-sky-400 border-sky-500/30';
                $dotColor = 'bg-sky-400';
                $label = 'Manual';
                break;
            default:
                $classes = 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30';
                $dotColor = 'bg-zinc-400';
                $label = ucfirst($status);
        }
    } elseif ($type === 'role') {
        switch ($status) {
            case 'admin':
                $classes = 'bg-[#C62828]/15 text-[#E23B3B] border-[#C62828]/40';
                $dotColor = 'bg-[#C62828]';
                $label = 'Administrator';
                break;
            case 'petugas':
                $classes = 'bg-blue-500/10 text-blue-400 border-blue-500/30';
                $dotColor = 'bg-blue-400';
                $label = 'Petugas Bengkel';
                break;
            default:
                $classes = 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30';
                $dotColor = 'bg-zinc-400';
                $label = ucfirst($status);
        }
    }
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $classes }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    {{ $label }}
</span>
