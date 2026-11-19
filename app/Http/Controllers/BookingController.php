<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceRegistration;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran servis publik (multi-step wizard).
     */
    public function index(): View
    {
        return view('public.booking');
    }

    /**
     * Endpoint API internal untuk memeriksa nomor HP pelanggan secara asynchronous.
     */
    public function checkPhone(Request $request): JsonResponse
    {
        $phone = trim($request->query('phone', ''));

        if (empty($phone)) {
            return response()->json(['found' => false, 'message' => 'Nomor HP tidak boleh kosong.'], 400);
        }

        // Cari pelanggan berdasarkan nomor telepon
        $customer = Customer::with('vehicles')->where('phone', $phone)->first();

        if ($customer) {
            return response()->json([
                'found' => true,
                'customer' => [
                    'id' => $customer->id,
                    'customer_id' => $customer->customer_id,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'occupation' => $customer->occupation,
                ],
                'vehicles' => $customer->vehicles->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'plate_number' => $v->plate_number,
                        'type' => $v->type,
                        'stnk_number' => $v->stnk_number,
                        'year' => $v->year,
                        'color' => $v->color,
                    ];
                }),
            ]);
        }

        return response()->json([
            'found' => false,
            'message' => 'Nomor HP belum terdaftar dalam sistem.',
        ]);
    }

    /**
     * Simpan pendaftaran servis dari website publik ke database MySQL.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input Umum
        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'complaint' => ['required', 'string', 'min:5', 'max:1000'],
            'service_date' => ['required', 'date', 'after_or_equal:today'],
            'vehicle_mode' => ['required', 'in:existing,new'],
        ], [
            'phone.required' => 'Nomor HP wajib diisi untuk konfirmasi antrean.',
            'complaint.required' => 'Keluhan atau jenis perawatan yang diinginkan wajib dituliskan.',
            'service_date.required' => 'Tanggal servis wajib dipilih.',
            'service_date.after_or_equal' => 'Tanggal servis tidak boleh di masa lampau.',
        ]);

        return DB::transaction(function () use ($request) {
            $phone = trim($request->input('phone'));
            $customer = Customer::where('phone', $phone)->first();

            // 2. Registrasi Pelanggan Baru Jika Belum Ada
            if (!$customer) {
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'address' => ['required', 'string', 'max:500'],
                    'occupation' => ['required', 'string', 'max:100'],
                ], [
                    'name.required' => 'Nama lengkap wajib diisi untuk registrasi pelanggan baru.',
                    'address.required' => 'Alamat tinggal wajib diisi.',
                    'occupation.required' => 'Profesi / pekerjaan wajib diisi.',
                ]);

                $customer = Customer::create([
                    'name' => $request->input('name'),
                    'phone' => $phone,
                    'address' => $request->input('address'),
                    'occupation' => $request->input('occupation'),
                ]);
            }

            // 3. Penanganan Kendaraan (Pilih Terdaftar vs Tambah Baru)
            $vehicleId = null;

            if ($request->input('vehicle_mode') === 'existing' && $request->filled('vehicle_id')) {
                $vehicle = Vehicle::where('id', $request->input('vehicle_id'))
                    ->where('customer_id', $customer->id)
                    ->firstOrFail();
                $vehicleId = $vehicle->id;
            } else {
                // Tambah kendaraan baru
                $request->validate([
                    'plate_number' => ['required', 'string', 'max:15', 'unique:vehicles,plate_number'],
                    'type' => ['required', 'in:matic,manual'],
                    'stnk_number' => ['required', 'string', 'max:50'],
                    'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
                    'color' => ['required', 'string', 'max:50'],
                ], [
                    'plate_number.required' => 'Nomor plat kendaraan wajib diisi.',
                    'plate_number.unique' => 'Nomor plat ini sudah terdaftar dalam sistem.',
                    'type.required' => 'Pilih jenis motor (matic atau manual).',
                    'stnk_number.required' => 'Nomor STNK wajib diisi untuk verifikasi unit.',
                    'year.required' => 'Tahun pembuatan motor wajib diisi.',
                    'color.required' => 'Warna motor wajib diisi.',
                ]);

                $vehicle = Vehicle::create([
                    'customer_id' => $customer->id,
                    'plate_number' => strtoupper(trim($request->input('plate_number'))),
                    'type' => $request->input('type'),
                    'stnk_number' => strtoupper(trim($request->input('stnk_number'))),
                    'year' => (int) $request->input('year'),
                    'color' => trim($request->input('color')),
                ]);

                $vehicleId = $vehicle->id;
            }

            // 4. Simpan Pendaftaran Servis
            $service = ServiceRegistration::create([
                'vehicle_id' => $vehicleId,
                'customer_id' => $customer->id,
                'complaint' => $request->input('complaint'),
                'service_date' => $request->input('service_date'),
                'status' => 'waiting',
            ]);

            return redirect()->route('booking.success', ['id' => $service->id])
                ->with('success', 'Pendaftaran servis motor Anda berhasil dicatat dengan kode: ' . $service->service_id);
        });
    }

    /**
     * Halaman konfirmasi sukses setelah pendaftaran servis mandiri berhasil.
     */
    public function success(int $id): View
    {
        $service = ServiceRegistration::with(['customer', 'vehicle'])->findOrFail($id);

        return view('public.booking-success', compact('service'));
    }
}
