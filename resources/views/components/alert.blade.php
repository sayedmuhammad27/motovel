@if(session('success'))
    <div class="flash-alert fixed top-6 right-6 z-50 max-w-md w-full bg-[#191A1F] border-l-4 border-emerald-500 border-t border-r border-b border-[#303137] p-4 rounded-lg shadow-2xl flex items-start gap-3 text-[#F4F2EF]">
        <div class="p-1 rounded-full bg-emerald-500/10 text-emerald-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1 text-sm">
            <h4 class="font-semibold text-emerald-400 mb-0.5">Berhasil</h4>
            <p class="text-[#92939A]">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors p-1" aria-label="Tutup notifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="flash-alert fixed top-6 right-6 z-50 max-w-md w-full bg-[#191A1F] border-l-4 border-[#9a1312] border-t border-r border-b border-[#303137] p-4 rounded-lg shadow-2xl flex items-start gap-3 text-[#F4F2EF]">
        <div class="p-1 rounded-full bg-[#9a1312]/10 text-[#b91a19]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="flex-1 text-sm">
            <h4 class="font-semibold text-[#b91a19] mb-0.5">Peringatan / Kesalahan</h4>
            <p class="text-[#92939A]">{{ session('error') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors p-1" aria-label="Tutup notifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="flash-alert fixed top-6 right-6 z-50 max-w-md w-full bg-[#191A1F] border-l-4 border-[#9a1312] border-t border-r border-b border-[#303137] p-4 rounded-lg shadow-2xl flex items-start gap-3 text-[#F4F2EF]">
        <div class="p-1 rounded-full bg-[#9a1312]/10 text-[#b91a19]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1 text-sm">
            <h4 class="font-semibold text-[#b91a19] mb-1">Validasi Formulir Gagal</h4>
            <ul class="list-disc list-inside text-xs text-[#92939A] space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button onclick="this.parentElement.remove()" class="text-[#92939A] hover:text-[#F4F2EF] transition-colors p-1" aria-label="Tutup notifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif
