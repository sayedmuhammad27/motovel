<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\ServiceRegistration;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Halaman Landing Page Utama (10 Section Sinematik).
     */
    public function landing(): View
    {
        $services = [
            [
                'title' => 'General Motorcycle Service',
                'category' => 'Servis Ringan & Tune Up',
                'description' => 'Pembersihan ruang bakar, pengecekan celah klep, kalibrasi sistem injeksi, dan pelumasan 18 titik krusial motor.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Perawatan Rutin',
            ],
            [
                'title' => 'Engine Overhaul & Tuning',
                'category' => 'Performa & Mesin',
                'description' => 'Servis besar, pembersihan kerak piston, peremajaan paking mesin, porting polish presisi, dan peningkatan kompresi.',
                'image' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Spesialis Sport',
            ],
            [
                'title' => 'Oil & Fluid Replacement',
                'category' => 'Pelumas Sintetis',
                'description' => 'Pengurasan oli mesin vakum bertekanan, penggantian oli gardan, flushing minyak rem DOT 4/5.1, dan kuras cairan radiator coolant.',
                'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Proteksi Gesekan',
            ],
            [
                'title' => 'Brake & Chassis Inspection',
                'category' => 'Pengereman & Rangka',
                'description' => 'Inspeksi ketebalan piringan cakram, pembersihan kaliper rem, bleeding master rem, serta kalibrasi komstir dan as roda.',
                'image' => 'https://images.unsplash.com/photo-1630155014421-5e7d9b1b3b1b?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Keselamatan Utama',
            ],
            [
                'title' => 'CVT Modern & Drivetrain Service',
                'category' => 'Transmisi Matic',
                'description' => 'Penanganan gredek tarikan awal, servis puli depan & belakang, balancing roller, pelumasan grease high-temp, dan penggantian V-belt.',
                'image' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Matic Bebas Gredek',
            ],
            [
                'title' => 'Tire & Wheel Balancing',
                'category' => 'Ban & Kaki-kaki',
                'description' => 'Pemasangan ban tubeless dengan tyre changer elektrik bebas baret velg, pengisian nitrogen murni, dan pengecekan bearing roda.',
                'image' => 'https://images.unsplash.com/photo-1449426468159-d96dbf08f19f?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Grip Maksimal',
            ],
            [
                'title' => 'Motorcycle Diagnostics & ECU Remap',
                'category' => 'Kelistrikan & Injeksi',
                'description' => 'Pemindaian sensor FI dengan scanner komputer OEM, pembacaan riwayat kode kerusakan DTC, reset TPS, dan dyno check.',
                'image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&auto=format&fit=crop&q=80',
                'badge' => 'Teknologi Komputer',
            ],
        ];

        // Statistik Bengkel untuk Social Proof Nyata dari DB
        $totalCustomers = Customer::count();
        $totalServicesDone = ServiceRegistration::where('status', 'completed')->count();
        $totalMechanics = Mechanic::count();

        // 6 Sparepart unggulan
        $featuredParts = Sparepart::orderBy('price', 'desc')->take(4)->get();

        return view('public.landing', compact(
            'services',
            'totalCustomers',
            'totalServicesDone',
            'totalMechanics',
            'featuredParts'
        ));
    }

    /**
     * Halaman Profil & Visi Misi Bengkel MOTOVEL.
     */
    public function about(): View
    {
        $mechanics = Mechanic::all();
        return view('public.about', compact('mechanics'));
    }

    /**
     * Halaman Daftar Lengkap Layanan Servis.
     */
    public function services(): View
    {
        return view('public.services');
    }

    /**
     * Halaman Galeri Sepeda Motor & Aktivitas Bengkel.
     */
    public function gallery(): View
    {
        return view('public.gallery');
    }

    /**
     * Halaman Kontak & Form Kirim Pesan.
     */
    public function contact(): View
    {
        return view('public.contact');
    }
}
