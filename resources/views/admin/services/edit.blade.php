@extends('layouts.admin')

@section('title', 'Edit Pendaftaran Servis | MOTOVEL')
@section('header_title', 'Edit Pendaftaran Servis')
@section('header_subtitle', "Perbarui data registrasi servis unit {{ \$service->service_id }}.")

@section('content')
<div class="max-w-3xl">
    <div class="bg-[#191A1F] border border-[#303137] rounded-2xl p-6 sm:p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.services.update', $service->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- ID Servis (Read Only Badge) -->
            <div class="flex items-center justify-between p-4 rounded-xl bg-[#111216] border border-[#303137]">
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Nomor Registrasi Servis</span>
                    <div class="font-mono text-base font-bold text-[#b91a19]">{{ $service->service_id }}</div>
                </div>
                <div class="text-right">
                    <span class="text-xs uppercase tracking-wider text-[#92939A]">Dibuat Pada</span>
                    <div class="text-xs text-[#F4F2EF] font-mono">{{ $service->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <!-- Pilihan Sepeda Motor -->
            <div>
                <label for="vehicle_id" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Sepeda Motor Pelanggan <span class="text-[#b91a19]">*</span>
                </label>
                <select name="vehicle_id" id="vehicle_id" required class="w-full bg-[#111216] border @error('vehicle_id') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" {{ old('vehicle_id', $service->vehicle_id) == $v->id ? 'selected' : '' }}>
                            {{ $v->plate_number }} ({{ $v->brand }} {{ $v->model }}) : Pemilik {{ $v->customer->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Servis -->
            <div>
                <label for="service_date" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Tanggal Pendaftaran Servis <span class="text-[#b91a19]">*</span>
                </label>
                <input type="date" 
                       name="service_date" 
                       id="service_date" 
                       value="{{ old('service_date', \Carbon\Carbon::parse($service->service_date)->format('Y-m-d')) }}" 
                       required
                       class="w-full bg-[#111216] border @error('service_date') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">
                @error('service_date')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keluhan / Kebutuhan Servis -->
            <div>
                <label for="complaint" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Keluhan / Rincian Permintaan Servis <span class="text-[#b91a19]">*</span>
                </label>
                <textarea name="complaint" 
                          id="complaint" 
                          rows="4" 
                          required
                          class="w-full bg-[#111216] border @error('complaint') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312] focus:ring-1 focus:ring-[#9a1312]">{{ old('complaint', $service->complaint) }}</textarea>
                @error('complaint')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Servis -->
            <div>
                <label for="status" class="block text-xs uppercase tracking-wider text-[#92939A] font-semibold mb-2">
                    Status Pengerjaan Servis <span class="text-[#b91a19]">*</span>
                </label>
                <select name="status" id="status" required class="w-full bg-[#111216] border @error('status') border-[#b91a19] @else border-[#303137] @enderror rounded-xl px-4 py-3 text-sm text-[#F4F2EF] focus:outline-none focus:border-[#9a1312]">
                    <option value="waiting" {{ old('status', $service->status) == 'waiting' ? 'selected' : '' }}>Menunggu Pengerjaan (Waiting)</option>
                    <option value="in_progress" {{ old('status', $service->status) == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
                    <option value="completed" {{ old('status', $service->status) == 'completed' ? 'selected' : '' }}>Pengerjaan Selesai (Completed)</option>
                    <option value="cancelled" {{ old('status', $service->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
                @error('status')
                    <p class="mt-1.5 text-xs text-[#b91a19]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-[#303137]">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl border border-[#303137] text-xs font-semibold text-[#92939A] hover:text-[#F4F2EF] hover:bg-[#222329] transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-[#9a1312] hover:bg-[#b91a19] text-white text-xs uppercase tracking-wider font-semibold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                    Perbarui Servis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
