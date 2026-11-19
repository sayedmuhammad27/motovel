<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MechanicController extends Controller
{
    /**
     * Tampilkan daftar teknisi / mekanik bengkel.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $mechanics = Mechanic::withCount('serviceDetails')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('mechanic_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.mechanics.index', compact('mechanics', 'search'));
    }

    /**
     * Tampilkan form penambahan mekanik baru.
     */
    public function create(): View
    {
        return view('admin.mechanics.create');
    }

    /**
     * Simpan data mekanik baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'specialty' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap mekanik wajib diisi.',
            'phone.required' => 'Nomor HP mekanik wajib diisi.',
            'address.required' => 'Alamat tempat tinggal mekanik wajib diisi.',
            'specialty.required' => 'Bidang keahlian / spesialisasi teknisi wajib diisi.',
        ]);

        $mechanic = Mechanic::create($validated);

        return redirect()->route('admin.mechanics.index')
            ->with('success', "Data mekanik {$mechanic->name} ({$mechanic->mechanic_id}) berhasil ditambahkan.");
    }

    /**
     * Tampilkan detail mekanik dan riwayat pengerjaan servisnya.
     */
    public function show(Mechanic $mechanic): View
    {
        $mechanic->load(['serviceDetails.serviceRegistration.vehicle', 'serviceDetails.serviceRegistration.customer']);

        return view('admin.mechanics.show', compact('mechanic'));
    }

    /**
     * Tampilkan form edit data mekanik.
     */
    public function edit(Mechanic $mechanic): View
    {
        return view('admin.mechanics.edit', compact('mechanic'));
    }

    /**
     * Perbarui data mekanik.
     */
    public function update(Request $request, Mechanic $mechanic): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'specialty' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap mekanik wajib diisi.',
            'phone.required' => 'Nomor HP mekanik wajib diisi.',
            'address.required' => 'Alamat mekanik wajib diisi.',
            'specialty.required' => 'Spesialisasi keahlian mekanik wajib diisi.',
        ]);

        $mechanic->update($validated);

        return redirect()->route('admin.mechanics.index')
            ->with('success', "Data mekanik {$mechanic->name} ({$mechanic->mechanic_id}) berhasil diperbarui.");
    }

    /**
     * Hapus data mekanik.
     */
    public function destroy(Mechanic $mechanic): RedirectResponse
    {
        $name = $mechanic->name;
        $id = $mechanic->mechanic_id;

        $mechanic->delete();

        return redirect()->route('admin.mechanics.index')
            ->with('success', "Data mekanik {$name} ({$id}) berhasil dihapus.");
    }
}
