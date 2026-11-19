<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SparepartController extends Controller
{
    /**
     * Tampilkan katalog suku cadang dengan pencarian, filter kategori, dan status stok.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $categories = Sparepart::select('category')->distinct()->pluck('category');

        $spareparts = Sparepart::withCount('serviceDetails')
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sparepart_id', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.spareparts.index', compact('spareparts', 'categories', 'search', 'category'));
    }

    /**
     * Tampilkan form penambahan sparepart baru.
     */
    public function create(): View
    {
        return view('admin.spareparts.create');
    }

    /**
     * Simpan data sparepart baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama suku cadang wajib diisi.',
            'category.required' => 'Kategori suku cadang wajib diisi.',
            'price.required' => 'Harga jual suku cadang wajib ditentukan.',
            'price.min' => 'Harga jual tidak boleh bernilai negatif.',
            'stock.required' => 'Jumlah stok awal wajib diisi.',
            'stock.min' => 'Jumlah stok tidak boleh kurang dari 0.',
        ]);

        $sparepart = Sparepart::create($validated);

        return redirect()->route('admin.spareparts.index')
            ->with('success', "Suku cadang {$sparepart->name} ({$sparepart->sparepart_id}) berhasil ditambahkan ke katalog.");
    }

    /**
     * Tampilkan detail suku cadang dan riwayat penggunaannya dalam servis.
     */
    public function show(Sparepart $sparepart): View
    {
        $sparepart->load(['serviceDetails.serviceRegistration.vehicle', 'serviceDetails.mechanic']);

        return view('admin.spareparts.show', compact('sparepart'));
    }

    /**
     * Tampilkan form edit sparepart.
     */
    public function edit(Sparepart $sparepart): View
    {
        return view('admin.spareparts.edit', compact('sparepart'));
    }

    /**
     * Perbarui data sparepart.
     */
    public function update(Request $request, Sparepart $sparepart): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama suku cadang wajib diisi.',
            'category.required' => 'Kategori suku cadang wajib diisi.',
            'price.required' => 'Harga jual suku cadang wajib diisi.',
            'price.min' => 'Harga jual tidak boleh negatif.',
            'stock.required' => 'Jumlah stok wajib diisi.',
            'stock.min' => 'Jumlah stok tidak boleh negatif.',
        ]);

        $sparepart->update($validated);

        return redirect()->route('admin.spareparts.index')
            ->with('success', "Data suku cadang {$sparepart->name} ({$sparepart->sparepart_id}) berhasil diperbarui.");
    }

    /**
     * Hapus sparepart.
     */
    public function destroy(Sparepart $sparepart): RedirectResponse
    {
        // Periksa apakah sparepart pernah digunakan di servis yang sudah ada
        if ($sparepart->serviceDetails()->count() > 0) {
            return back()->with('error', "Suku cadang {$sparepart->name} tidak dapat dihapus karena tercatat dalam riwayat pengerjaan servis bengkel.");
        }

        $name = $sparepart->name;
        $id = $sparepart->sparepart_id;

        $sparepart->delete();

        return redirect()->route('admin.spareparts.index')
            ->with('success', "Suku cadang {$name} ({$id}) berhasil dihapus dari inventaris.");
    }
}
