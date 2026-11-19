<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Simpan pesan dari formulir kontak website publik.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan wajib dipilih atau diisi.',
            'message.required' => 'Isi pesan wajib dituliskan.',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih, pesan Anda telah berhasil dikirimkan kepada tim layanan MOTOVEL. Kami akan segera merespons melalui email atau WhatsApp.');
    }
}
