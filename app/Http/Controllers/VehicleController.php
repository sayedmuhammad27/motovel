<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Tampilkan daftar sepeda motor dengan pencarian dan relasi pelanggan.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $vehicles = Vehicle::with('customer')
            ->withCount('serviceRegistrations')
            ->when($search, function ($query, $search) {
                $query->where('plate_number', 'like', "%{$search}%")
                    ->orWhere('stnk_number', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('customer_id', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.vehicles.index', compact('vehicles', 'search'));
    }

    /**
     * Tampilkan form registrasi sepeda motor baru.
     */
    public function create(): View
    {
        $customers = Customer::orderBy('name')->get();
        return view('admin.vehicles.create', compact('customers'));
    }

    /**
     * Simpan sepeda motor baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plate_number' => ['required', 'string', 'max:20', 'unique:vehicles,plate_number'],
            'type' => ['required', 'in:matic,manual'],
            'stnk_number' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'customer_id' => ['required', 'exists:customers,id'],
            'color' => ['required', 'string', 'max:50'],
        ], [
            'plate_number.required' => 'Nomor plat kendaraan wajib diisi.',
            'plate_number.unique' => 'Nomor plat kendaraan ini sudah terdaftar.',
            'type.required' => 'Pilih jenis transmisi motor (matic atau manual).',
            'stnk_number.required' => 'Nomor STNK wajib diisi.',
            'year.required' => 'Tahun perakitan wajib diisi.',
            'customer_id.required' => 'Pemilik kendaraan wajib dipilih dari data pelanggan.',
            'color.required' => 'Warna motor wajib diisi.',
        ]);

        $validated['plate_number'] = strtoupper(trim($validated['plate_number']));
        $validated['stnk_number'] = strtoupper(trim($validated['stnk_number']));

        $vehicle = Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', "Sepeda motor plat {$vehicle->plate_number} berhasil didaftarkan.");
    }

    /**
     * Tampilkan detail sepeda motor dan riwayat servisnya.
     */
    public function show(Vehicle $vehicle): View
    {
        $vehicle->load(['customer', 'serviceRegistrations.serviceDetail.mechanic', 'serviceRegistrations.payment']);

        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Tampilkan form edit sepeda motor.
     */
    public function edit(Vehicle $vehicle): View
    {
        $customers = Customer::orderBy('name')->get();
        return view('admin.vehicles.edit', compact('vehicle', 'customers'));
    }

    /**
     * Perbarui data sepeda motor.
     */
    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'plate_number' => ['required', 'string', 'max:20', 'unique:vehicles,plate_number,' . $vehicle->id],
            'type' => ['required', 'in:matic,manual'],
            'stnk_number' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'customer_id' => ['required', 'exists:customers,id'],
            'color' => ['required', 'string', 'max:50'],
        ], [
            'plate_number.required' => 'Nomor plat kendaraan wajib diisi.',
            'plate_number.unique' => 'Nomor plat kendaraan ini sudah terdaftar untuk unit lain.',
            'type.required' => 'Pilih jenis transmisi motor.',
            'stnk_number.required' => 'Nomor STNK wajib diisi.',
            'year.required' => 'Tahun perakitan wajib diisi.',
            'customer_id.required' => 'Pemilik kendaraan wajib dipilih.',
            'color.required' => 'Warna motor wajib diisi.',
        ]);

        $validated['plate_number'] = strtoupper(trim($validated['plate_number']));
        $validated['stnk_number'] = strtoupper(trim($validated['stnk_number']));

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', "Data sepeda motor plat {$vehicle->plate_number} berhasil diperbarui.");
    }

    /**
     * Hapus data sepeda motor.
     */
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $plate = $vehicle->plate_number;
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', "Data sepeda motor plat {$plate} berhasil dihapus.");
    }
}
