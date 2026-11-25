@extends('layouts.admin')

@section('title', 'Data Mekanik | MOTOVEL')
@section('header_title', 'Master Data Mekanik Bengkel')
@section('header_subtitle', 'Pengelolaan data teknisi bengkel, spesialisasi keahlian, dan penugasan servis.')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.mechanics.index') }}" class="relative flex-1 max-w-md">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="Cari ID, nama teknisi, nomor HP, keahlian..." 
                   class="w-full bg-[#191A1F] border border-[#303137] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#F4F2EF] placeholder-[#92939A]/50 focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
            <svg class="w-4 h-4 text-[#92939A] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <a href="{{ route('admin.mechanics.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-[#92939A] hover:text-[#F4F2EF]">Reset</a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.mechanics.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-5 rounded-xl shadow-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Mekanik</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#92939A]">
                <thead class="text-xs uppercase tracking-wider bg-[#111216] text-[#92939A] border-b border-[#303137]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Mekanik</th>
                        <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4">Nomor HP</th>
                        <th scope="col" class="px-6 py-4">Bidang Spesialisasi</th>
                        <th scope="col" class="px-6 py-4">Alamat Domisili</th>
                        <th scope="col" class="px-6 py-4 text-center">Penugasan Servis</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#303137]/60">
                    @forelse($mechanics as $m)
                        <tr class="hover:bg-[#222329]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-[#b91a19]">
                                {{ $m->mechanic_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.mechanics.show', $m->id) }}" class="font-semibold text-[#F4F2EF] hover:text-[#b91a19] transition-colors">
                                    {{ $m->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#F4F2EF]">
                                {{ $m->phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#111216] border border-[#303137] text-white">
                                    {{ $m->specialty }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-xs">
                                {{ $m->address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#111216] border border-[#303137] text-[#92939A]">
                                    {{ $m->service_details_count }} Unit
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.mechanics.show', $m->id) }}" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors" title="Lihat Profil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.mechanics.edit', $m->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.mechanics.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus teknisi {{ $m->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-500 hover:text-[#b91a19] transition-colors" title="Hapus Mekanik">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-[#92939A]">
                                Tidak ada data mekanik yang cocok dengan pencarian Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $mechanics->links('vendor.pagination.tailwind') }}
    </div>

</div>
@endsection
