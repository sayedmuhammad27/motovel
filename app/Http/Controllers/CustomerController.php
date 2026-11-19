<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar pelanggan dengan pencarian dan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $customers = Customer::withCount(['vehicles', 'serviceRegistrations'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('customer_id', 'like', "%{$search}%")
                    ->orWhere('occupation', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers', 'search'));
    }

    /**
     * Tampilkan form penambahan pelanggan baru.
     */
    public function create(): View
    {
        return view('admin.customers.create');
    }

    /**
     * Simpan pelanggan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'address' => ['required', 'string', 'max:500'],
            'occupation' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap pelanggan wajib diisi.',
            'phone.required' => 'Nomor HP pelanggan wajib diisi.',
            'phone.unique' => 'Nomor HP ini sudah terdaftar untuk pelanggan lain.',
            'address.required' => 'Alamat pelanggan wajib diisi.',
            'occupation.required' => 'Pekerjaan pelanggan wajib diisi.',
        ]);

        $customer = Customer::create($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', "Pelanggan {$customer->name} ({$customer->customer_id}) berhasil ditambahkan.");
    }

    /**
     * Tampilkan detail pelanggan dan daftar sepeda motor miliknya.
     */
    public function show(Customer $customer): View
    {
        $customer->load(['vehicles.serviceRegistrations', 'serviceRegistrations.serviceDetail', 'serviceRegistrations.payment']);

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Tampilkan form edit pelanggan.
     */
    public function edit(Customer $customer): View
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Perbarui data pelanggan.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone,' . $customer->id],
            'address' => ['required', 'string', 'max:500'],
            'occupation' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap pelanggan wajib diisi.',
            'phone.required' => 'Nomor HP pelanggan wajib diisi.',
            'phone.unique' => 'Nomor HP ini sudah digunakan pelanggan lain.',
            'address.required' => 'Alamat pelanggan wajib diisi.',
            'occupation.required' => 'Pekerjaan pelanggan wajib diisi.',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', "Data pelanggan {$customer->name} ({$customer->customer_id}) berhasil diperbarui.");
    }

    /**
     * Hapus data pelanggan.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $name = $customer->name;
        $id = $customer->customer_id;

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', "Data pelanggan {$name} ({$id}) berhasil dihapus beserta data kendaraannya.");
    }
}
