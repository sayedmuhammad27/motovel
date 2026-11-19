@props([
    'title',
    'value',
    'subtitle' => null,
    'icon' => null,
    'accent' => 'red', // red, blue, emerald, amber
])

@php
    $accentMap = [
        'red' => 'from-[#C62828]/20 to-transparent border-[#C62828]/30 text-[#E23B3B]',
        'emerald' => 'from-emerald-500/20 to-transparent border-emerald-500/30 text-emerald-400',
        'blue' => 'from-blue-500/20 to-transparent border-blue-500/30 text-blue-400',
        'amber' => 'from-amber-500/20 to-transparent border-amber-500/30 text-amber-400',
    ];
    $iconBg = [
        'red' => 'bg-[#C62828]/10 text-[#E23B3B] border-[#C62828]/20',
        'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
        'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
        'amber' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
    ];
    $accentClass = $accentMap[$accent] ?? $accentMap['red'];
    $iconClass = $iconBg[$accent] ?? $iconBg['red'];
@endphp

<div class="relative overflow-hidden rounded-xl bg-[#191A1F] border border-[#303137] p-5 shadow-lg hover:border-[#303137]/80 transition-all duration-300 group">
    <div class="absolute inset-0 bg-gradient-to-br {{ $accentClass }} opacity-40 group-hover:opacity-70 transition-opacity pointer-events-none"></div>
    <div class="relative z-10 flex items-start justify-between">
        <div>
            <p class="text-xs uppercase tracking-wider font-medium text-[#92939A] mb-1">{{ $title }}</p>
            <h3 class="text-2xl lg:text-3xl font-bold text-[#F4F2EF] tracking-tight font-display">{{ $value }}</h3>
            @if($subtitle)
                <p class="text-xs text-[#92939A] mt-1.5 flex items-center gap-1">{{ $subtitle }}</p>
            @endif
        </div>
        @if($icon)
            <div class="p-3 rounded-lg border {{ $iconClass }} transition-transform duration-300 group-hover:scale-110">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
