<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Payment;
use App\Models\ServiceDetail;
use App\Models\ServiceRegistration;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users (Admin & Petugas)
        User::create([
            'name' => 'Administrator MOTOVEL',
            'email' => 'admin@motovel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Front Office',
            'email' => 'petugas@motovel.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // 2. Mechanics (5 Mekanik Profesional)
        $mechanicsData = [
            [
                'name' => 'Bambang Sudiro',
                'phone' => '081234567801',
                'address' => 'Jl. Ketintang Baru No. 14, Surabaya',
                'specialty' => 'Sportbike Performance & Engine Tuning',
            ],
            [
                'name' => 'Ahmad Rian Hidayat',
                'phone' => '081234567802',
                'address' => 'Jl. Mayjen Sungkono No. 88, Surabaya',
                'specialty' => 'Automatic Transmission, CVT & Detailing',
            ],
            [
                'name' => 'Dwi Santoso',
                'phone' => '081234567803',
                'address' => 'Jl. Raya Darmo Permai No. 23, Surabaya',
                'specialty' => 'Electrical Systems, ECU Remap & Diagnostics',
            ],
            [
                'name' => 'Fajar Pratama',
                'phone' => '081234567804',
                'address' => 'Jl. Rungkut Madya No. 45, Surabaya',
                'specialty' => 'Suspension, Chassis & Braking Systems',
            ],
            [
                'name' => 'Hendra Setiawan',
                'phone' => '081234567805',
                'address' => 'Jl. Jemursari Barat No. 12, Surabaya',
                'specialty' => 'General Maintenance & Routine Inspection',
            ],
        ];

        $mechanics = [];
        foreach ($mechanicsData as $data) {
            $mechanics[] = Mechanic::create($data);
        }

        // 3. Customers (20 Pelanggan)
        $customersData = [
            ['name' => 'Dimas Arya Pratama', 'phone' => '081390123401', 'address' => 'Jl. Manyar Kertoarjo No. 15, Surabaya', 'occupation' => 'Software Engineer'],
            ['name' => 'Reza Fahlevi', 'phone' => '081390123402', 'address' => 'Jl. Kertajaya Indah No. 34, Surabaya', 'occupation' => 'Architect'],
            ['name' => 'Siti Nurhaliza', 'phone' => '081390123403', 'address' => 'Jl. Dharmahusada Indah No. 5, Surabaya', 'occupation' => 'Dokter Umum'],
            ['name' => 'Bayu Wicaksono', 'phone' => '081390123404', 'address' => 'Jl. Barata Jaya No. 19, Surabaya', 'occupation' => 'Creative Director'],
            ['name' => 'Indra Gunawan', 'phone' => '081390123405', 'address' => 'Jl. Ngagel Jaya Selatan No. 8, Surabaya', 'occupation' => 'Wirausaha'],
            ['name' => 'Nadia Putri Maharani', 'phone' => '081390123406', 'address' => 'Jl. Diponegoro No. 112, Surabaya', 'occupation' => 'Brand Manager'],
            ['name' => 'Kevin Sanjaya', 'phone' => '081390123407', 'address' => 'Jl. HR Muhammad No. 71, Surabaya', 'occupation' => 'Financial Analyst'],
            ['name' => 'Aditya Rahman', 'phone' => '081390123408', 'address' => 'Jl. Graha Famili Blok C No. 9, Surabaya', 'occupation' => 'Pilot Komersial'],
            ['name' => 'Maya Anggraini', 'phone' => '081390123409', 'address' => 'Jl. CitraLand Utama No. 42, Surabaya', 'occupation' => 'Notaris'],
            ['name' => 'Gilang Ramadhan', 'phone' => '081390123410', 'address' => 'Jl. Dukuh Kupang Barat No. 27, Surabaya', 'occupation' => 'Fotografer'],
            ['name' => 'Eko Prasetyo', 'phone' => '081390123411', 'address' => 'Jl. Gubeng Kertajaya No. 3, Surabaya', 'occupation' => 'Dosen Teknik'],
            ['name' => 'Vina Panduwinata', 'phone' => '081390123412', 'address' => 'Jl. Kusuma Bangsa No. 101, Surabaya', 'occupation' => 'Konsultan Bisnis'],
            ['name' => 'Arif Budiman', 'phone' => '081390123413', 'address' => 'Jl. Pahlawan No. 56, Surabaya', 'occupation' => 'Pegawai BUMN'],
            ['name' => 'Lestari Handayani', 'phone' => '081390123414', 'address' => 'Jl. Undaan Wetan No. 18, Surabaya', 'occupation' => 'Apoteker'],
            ['name' => 'Taufik Hidayat', 'phone' => '081390123415', 'address' => 'Jl. Pemuda No. 77, Surabaya', 'occupation' => 'Product Specialist'],
            ['name' => 'Rian Ardiansyah', 'phone' => '081390123416', 'address' => 'Jl. Menur Pumpungan No. 30, Surabaya', 'occupation' => 'Data Scientist'],
            ['name' => 'Citra Kirana', 'phone' => '081390123417', 'address' => 'Jl. Mulyosari Tengah No. 22, Surabaya', 'occupation' => 'Pengusaha Restoran'],
            ['name' => 'Farhan Nugraha', 'phone' => '081390123418', 'address' => 'Jl. Sutorejo Prima No. 14, Surabaya', 'occupation' => 'Civil Engineer'],
            ['name' => 'Dian Sastrowardoyo', 'phone' => '081390123419', 'address' => 'Jl. Raya Kendangsari No. 60, Surabaya', 'occupation' => 'Produser Media'],
            ['name' => 'Yoga Pratama', 'phone' => '081390123420', 'address' => 'Jl. Tenggilis Mejoyo No. 4, Surabaya', 'occupation' => 'Marketing Lead'],
        ];

        $customers = [];
        foreach ($customersData as $data) {
            $customers[] = Customer::create($data);
        }

        // 4. Vehicles (30 Sepeda Motor)
        $vehiclesData = [
            ['plate_number' => 'L 4521 AB', 'type' => 'manual', 'stnk_number' => 'STNK-0918231', 'year' => 2023, 'customer_id' => $customers[0]->id, 'color' => 'Matte Black Edition'],
            ['plate_number' => 'L 2890 CD', 'type' => 'matic', 'stnk_number' => 'STNK-0918232', 'year' => 2022, 'customer_id' => $customers[0]->id, 'color' => 'Metallic Grey'],
            ['plate_number' => 'L 6102 EF', 'type' => 'manual', 'stnk_number' => 'STNK-0918233', 'year' => 2024, 'customer_id' => $customers[1]->id, 'color' => 'Racing Lime Green'],
            ['plate_number' => 'W 3341 GH', 'type' => 'matic', 'stnk_number' => 'STNK-0918234', 'year' => 2021, 'customer_id' => $customers[2]->id, 'color' => 'Pearl White'],
            ['plate_number' => 'L 5873 IJ', 'type' => 'manual', 'stnk_number' => 'STNK-0918235', 'year' => 2023, 'customer_id' => $customers[3]->id, 'color' => 'Crimson Red'],
            ['plate_number' => 'L 1948 KL', 'type' => 'matic', 'stnk_number' => 'STNK-0918236', 'year' => 2020, 'customer_id' => $customers[4]->id, 'color' => 'Midnight Blue'],
            ['plate_number' => 'W 8029 MN', 'type' => 'matic', 'stnk_number' => 'STNK-0918237', 'year' => 2023, 'customer_id' => $customers[5]->id, 'color' => 'Glossy Black'],
            ['plate_number' => 'L 3710 OP', 'type' => 'manual', 'stnk_number' => 'STNK-0918238', 'year' => 2022, 'customer_id' => $customers[6]->id, 'color' => 'Icon Blue'],
            ['plate_number' => 'L 9942 QR', 'type' => 'manual', 'stnk_number' => 'STNK-0918239', 'year' => 2024, 'customer_id' => $customers[7]->id, 'color' => 'Dark Titan Stealth'],
            ['plate_number' => 'W 6650 ST', 'type' => 'matic', 'stnk_number' => 'STNK-0918240', 'year' => 2022, 'customer_id' => $customers[8]->id, 'color' => 'Prestige Silver'],
            ['plate_number' => 'L 2481 UV', 'type' => 'matic', 'stnk_number' => 'STNK-0918241', 'year' => 2021, 'customer_id' => $customers[9]->id, 'color' => 'Matte Bronze'],
            ['plate_number' => 'L 8812 WX', 'type' => 'manual', 'stnk_number' => 'STNK-0918242', 'year' => 2023, 'customer_id' => $customers[10]->id, 'color' => 'Deep Gloss Black'],
            ['plate_number' => 'W 1403 YZ', 'type' => 'matic', 'stnk_number' => 'STNK-0918243', 'year' => 2024, 'customer_id' => $customers[11]->id, 'color' => 'Candy Apple Red'],
            ['plate_number' => 'L 5019 AA', 'type' => 'manual', 'stnk_number' => 'STNK-0918244', 'year' => 2019, 'customer_id' => $customers[12]->id, 'color' => 'Gunmetal Silver'],
            ['plate_number' => 'L 7723 BB', 'type' => 'matic', 'stnk_number' => 'STNK-0918245', 'year' => 2023, 'customer_id' => $customers[13]->id, 'color' => 'Magma Red'],
            ['plate_number' => 'W 9184 CC', 'type' => 'manual', 'stnk_number' => 'STNK-0918246', 'year' => 2022, 'customer_id' => $customers[14]->id, 'color' => 'Racing Yellow'],
            ['plate_number' => 'L 3267 DD', 'type' => 'matic', 'stnk_number' => 'STNK-0918247', 'year' => 2021, 'customer_id' => $customers[15]->id, 'color' => 'Matte Green Forest'],
            ['plate_number' => 'L 6451 EE', 'type' => 'matic', 'stnk_number' => 'STNK-0918248', 'year' => 2024, 'customer_id' => $customers[16]->id, 'color' => 'Obsidian Black'],
            ['plate_number' => 'W 2038 FF', 'type' => 'manual', 'stnk_number' => 'STNK-0918249', 'year' => 2023, 'customer_id' => $customers[17]->id, 'color' => 'Sapphire Blue'],
            ['plate_number' => 'L 8920 GG', 'type' => 'matic', 'stnk_number' => 'STNK-0918250', 'year' => 2022, 'customer_id' => $customers[18]->id, 'color' => 'Pearl White Tri-Coat'],
            ['plate_number' => 'L 4175 HH', 'type' => 'manual', 'stnk_number' => 'STNK-0918251', 'year' => 2024, 'customer_id' => $customers[19]->id, 'color' => 'Matte Carbon Grey'],
            ['plate_number' => 'W 5632 II', 'type' => 'matic', 'stnk_number' => 'STNK-0918252', 'year' => 2020, 'customer_id' => $customers[1]->id, 'color' => 'Charcoal Grey'],
            ['plate_number' => 'L 1290 JJ', 'type' => 'matic', 'stnk_number' => 'STNK-0918253', 'year' => 2023, 'customer_id' => $customers[3]->id, 'color' => 'Gloss Metallic Red'],
            ['plate_number' => 'L 9043 KK', 'type' => 'manual', 'stnk_number' => 'STNK-0918254', 'year' => 2021, 'customer_id' => $customers[6]->id, 'color' => 'Silver Frost'],
            ['plate_number' => 'W 7421 LL', 'type' => 'matic', 'stnk_number' => 'STNK-0918255', 'year' => 2024, 'customer_id' => $customers[8]->id, 'color' => 'Starlight Black'],
            ['plate_number' => 'L 3819 MM', 'type' => 'matic', 'stnk_number' => 'STNK-0918256', 'year' => 2022, 'customer_id' => $customers[10]->id, 'color' => 'Titanium Grey'],
            ['plate_number' => 'L 8302 NN', 'type' => 'manual', 'stnk_number' => 'STNK-0918257', 'year' => 2023, 'customer_id' => $customers[13]->id, 'color' => 'Orange Fire'],
            ['plate_number' => 'W 4910 OO', 'type' => 'matic', 'stnk_number' => 'STNK-0918258', 'year' => 2021, 'customer_id' => $customers[15]->id, 'color' => 'Deep Brown Metallic'],
            ['plate_number' => 'L 6284 PP', 'type' => 'manual', 'stnk_number' => 'STNK-0918259', 'year' => 2024, 'customer_id' => $customers[17]->id, 'color' => 'Raven Matte Black'],
            ['plate_number' => 'L 1735 QQ', 'type' => 'matic', 'stnk_number' => 'STNK-0918260', 'year' => 2023, 'customer_id' => $customers[19]->id, 'color' => 'Crystal White'],
        ];

        $vehicles = [];
        foreach ($vehiclesData as $data) {
            $vehicles[] = Vehicle::create($data);
        }

        // 5. Spareparts (20 Item Berkualitas Tinggi)
        $sparepartsData = [
            ['name' => 'Motul 7100 4T 10W-40 1L (100% Ester Synthetic)', 'category' => 'Oli & Pelumas', 'price' => 195000, 'stock' => 35, 'description' => 'Oli mesin performa tinggi berbahan dasar Ester untuk proteksi maksimal putaran tinggi.'],
            ['name' => 'Yamalube Super Sport 10W-40 1L (Full Synthetic)', 'category' => 'Oli & Pelumas', 'price' => 105000, 'stock' => 45, 'description' => 'Pelumas mesin sport full synthetic dengan formula kestabilan suhu ekstrem.'],
            ['name' => 'AHM Oil SPX 1 10W-30 0.8L (Superior Protection)', 'category' => 'Oli & Pelumas', 'price' => 78000, 'stock' => 60, 'description' => 'Oli transmisi manual dan sport OEM Honda dengan perlindungan gesekan minimal.'],
            ['name' => 'Motul Scooter Power LE 5W-40 1L', 'category' => 'Oli & Pelumas', 'price' => 155000, 'stock' => 40, 'description' => 'Pelumas khusus motor matic berteknologi 100% sintetis untuk akselerasi responsif.'],
            ['name' => 'Oli Gardan Motul Scooter Gear 80W-90 120ml', 'category' => 'Oli & Pelumas', 'price' => 38000, 'stock' => 50, 'description' => 'Pelumas girboks matic berdaya tahan tinggi terhadap tekanan ekstrem.'],
            ['name' => 'Filter Oli K&N KN-204 Racing Performance', 'category' => 'Filter & Udara', 'price' => 185000, 'stock' => 22, 'description' => 'Filter oli racing dengan material penyaringan sintetis tinggi dan mur pelepasan 17mm.'],
            ['name' => 'Filter Oli OEM Yamaha / Honda Original', 'category' => 'Filter & Udara', 'price' => 45000, 'stock' => 55, 'description' => 'Saringan oli standar pabrikan menjamin sirkulasi oli tetap bersih.'],
            ['name' => 'Filter Udara Ferrox Stainless Steel 45 Micron', 'category' => 'Filter & Udara', 'price' => 480000, 'stock' => 14, 'description' => 'Filter udara racing stainless steel mudah dicuci dan mengoptimalkan pasokan oksigen.'],
            ['name' => 'Busi Iridium Laser NGK CPR9EAIX-9', 'category' => 'Busi & Pengapian', 'price' => 125000, 'stock' => 48, 'description' => 'Busi elektroda iridium tipis untuk titik api terfokus dan pembakaran sempurna.'],
            ['name' => 'Busi Standar Denso Nickel U24EPR9', 'category' => 'Busi & Pengapian', 'price' => 35000, 'stock' => 70, 'description' => 'Busi standar berkualitas teruji untuk ketahanan operasional harian.'],
            ['name' => 'Kampas Rem Depan Brembo Sintered Sport', 'category' => 'Pengereman', 'price' => 380000, 'stock' => 18, 'description' => 'Brake pad sintered compound performa tinggi dengan gigitan presisi dan minim fading.'],
            ['name' => 'Kampas Rem Belakang Nissin Original OEM', 'category' => 'Pengereman', 'price' => 110000, 'stock' => 32, 'description' => 'Kampas rem belakang non-asbestos tahan panas dan ramah pada piringan cakram.'],
            ['name' => 'Minyak Rem Motul RBF 600 Factory Line DOT 4 500ml', 'category' => 'Pengereman', 'price' => 190000, 'stock' => 26, 'description' => 'Minyak rem racing bersuhu didih tinggi 312 derajat Celsius untuk rem tanpa jeda.'],
            ['name' => 'Rantai DID 520VR46 Professional O-Ring Gold 120L', 'category' => 'Drivetrain & Rantai', 'price' => 690000, 'stock' => 10, 'description' => 'Rantai balap berteknologi sealed ring O-ring tahan karat dan minim pemuaian rantai.'],
            ['name' => 'Roller CVT KTC Kytaco 11gr / 12gr Precision', 'category' => 'Transmisi CVT', 'price' => 95000, 'stock' => 30, 'description' => 'Roller teflon presisi tinggi untuk putaran CVT lebih halus dan responsif.'],
            ['name' => 'V-Belt Gates Powerlink EPDM Reinforced', 'category' => 'Transmisi CVT', 'price' => 175000, 'stock' => 24, 'description' => 'Sabuk CVT serat kevlar sintetis tahan panas tinggi dan lentur tanpa selip.'],
            ['name' => 'Ban Pirelli Diablo Rosso Sport 110/70-17 Tubeless', 'category' => 'Ban & Roda', 'price' => 620000, 'stock' => 15, 'description' => 'Ban sport compound ganda dengan cengkeraman maksimal di lintasan kering dan basah.'],
            ['name' => 'Ban Pirelli Diablo Rosso Sport 140/70-17 Tubeless', 'category' => 'Ban & Roda', 'price' => 840000, 'stock' => 12, 'description' => 'Ban sport belakang profil tajam untuk stabilitas manuver kemiringan tinggi.'],
            ['name' => 'Aki Kering Gel Motobatt QuadFlex MTZ6S 12V 5Ah', 'category' => 'Kelistrikan', 'price' => 340000, 'stock' => 18, 'description' => 'Aki gel elektrolit dengan CCA tinggi dan bebas perawatan untuk starter instan.'],
            ['name' => 'Bohlam Lampu Depan LED Osram All-Season HS1 12V', 'category' => 'Kelistrikan', 'price' => 175000, 'stock' => 25, 'description' => 'Lampu LED fokus tajam dengan cahaya putih tembus hujan dan hemat konsumsi daya.'],
        ];

        $spareparts = [];
        foreach ($sparepartsData as $data) {
            $spareparts[] = Sparepart::create($data);
        }

        // 6. Service Registrations (15 Layanan Servis)
        $servicesData = [
            // 4 Selesai (Completed & Paid)
            [
                'vehicle_id' => $vehicles[0]->id,
                'customer_id' => $customers[0]->id,
                'complaint' => 'Servis berkala 10.000 KM, tarikan awal terasa berat pada putaran 4000 RPM, ganti oli mesin dan filter.',
                'service_date' => Carbon::now()->subDays(6)->toDateString(),
                'status' => 'completed',
                'mechanic_id' => $mechanics[0]->id,
                'estimation' => 'Pembersihan throttle body, penggantian oli sintetis Motul 7100, dan pengecekan busi.',
                'service_cost' => 150000,
                'spareparts' => [
                    ['id' => $spareparts[0]->id, 'qty' => 2], // Motul 7100 2L
                    ['id' => $spareparts[5]->id, 'qty' => 1], // Filter K&N
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(6)->toDateString(),
                'notes' => 'Pembayaran via QRIS Statis MOTOVEL. Pengerjaan tuntas dan uji jalan stabil.',
            ],
            [
                'vehicle_id' => $vehicles[1]->id,
                'customer_id' => $customers[0]->id,
                'complaint' => 'CVT bergetar saat tarikan awal (gredek) di tanjakan, rem belakang kurang pakem.',
                'service_date' => Carbon::now()->subDays(5)->toDateString(),
                'status' => 'completed',
                'mechanic_id' => $mechanics[1]->id,
                'estimation' => 'Pembersihan mangkok ganda CVT, ganti roller dan V-belt, ganti kampas rem belakang.',
                'service_cost' => 125000,
                'spareparts' => [
                    ['id' => $spareparts[3]->id, 'qty' => 1], // Motul Scooter 1L
                    ['id' => $spareparts[4]->id, 'qty' => 1], // Oli gardan
                    ['id' => $spareparts[14]->id, 'qty' => 1], // Roller KTC
                    ['id' => $spareparts[15]->id, 'qty' => 1], // V-Belt Gates
                    ['id' => $spareparts[11]->id, 'qty' => 1], // Kampas rem belakang
                ],
                'payment_type' => 'cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(5)->toDateString(),
                'notes' => 'Pembayaran tunai lunas diterima kasir.',
            ],
            [
                'vehicle_id' => $vehicles[2]->id,
                'customer_id' => $customers[1]->id,
                'complaint' => 'Rantai kendor dan bunyi gemerisik, rem depan berdecit saat hard braking.',
                'service_date' => Carbon::now()->subDays(4)->toDateString(),
                'status' => 'completed',
                'mechanic_id' => $mechanics[3]->id,
                'estimation' => 'Penggantian rantai DID Gold O-ring dan instalasi kampas rem Brembo Sintered sport.',
                'service_cost' => 200000,
                'spareparts' => [
                    ['id' => $spareparts[13]->id, 'qty' => 1], // Rantai DID
                    ['id' => $spareparts[10]->id, 'qty' => 1], // Kampas Brembo
                    ['id' => $spareparts[12]->id, 'qty' => 1], // Minyak rem Motul RBF 600
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(4)->toDateString(),
                'notes' => 'Transfer bank Mandiri bukti valid terkonfirmasi.',
            ],
            [
                'vehicle_id' => $vehicles[3]->id,
                'customer_id' => $customers[2]->id,
                'complaint' => 'Lampu indikator aki berkedip, starter elektrik lambat merespons di pagi hari.',
                'service_date' => Carbon::now()->subDays(3)->toDateString(),
                'status' => 'completed',
                'mechanic_id' => $mechanics[2]->id,
                'estimation' => 'Pengecekan tegangan alternator, penggantian aki gel Motobatt dan ganti busi iridium.',
                'service_cost' => 100000,
                'spareparts' => [
                    ['id' => $spareparts[18]->id, 'qty' => 1], // Aki Motobatt
                    ['id' => $spareparts[8]->id, 'qty' => 1], // Busi Iridium
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(3)->toDateString(),
                'notes' => 'Pembayaran lunas EDC BCA.',
            ],

            // 4 Sedang Dikerjakan (In Progress)
            [
                'vehicle_id' => $vehicles[4]->id,
                'customer_id' => $customers[3]->id,
                'complaint' => 'Mesin brebet pada putaran atas dan knalpot nembak-nembak saat deselerasi.',
                'service_date' => Carbon::now()->subDays(1)->toDateString(),
                'status' => 'in_progress',
                'mechanic_id' => $mechanics[0]->id,
                'estimation' => 'Kalibrasi TPS, pembersihan injektor ultrasonic, ganti busi NGK Iridium dan filter oli.',
                'service_cost' => 175000,
                'spareparts' => [
                    ['id' => $spareparts[0]->id, 'qty' => 2],
                    ['id' => $spareparts[8]->id, 'qty' => 2],
                    ['id' => $spareparts[6]->id, 'qty' => 1],
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Kendaraan masih tahap penyetelan injeksi di ruang dyno.',
            ],
            [
                'vehicle_id' => $vehicles[6]->id,
                'customer_id' => $customers[5]->id,
                'complaint' => 'Rekomendasi penggantian sepasang ban sport untuk persiapan touring akhir pekan.',
                'service_date' => Carbon::now()->toDateString(),
                'status' => 'in_progress',
                'mechanic_id' => $mechanics[3]->id,
                'estimation' => 'Bongkar pasang ban depan & belakang Pirelli Diablo Rosso Sport dan balancing nitrogen.',
                'service_cost' => 150000,
                'spareparts' => [
                    ['id' => $spareparts[16]->id, 'qty' => 1], // Ban depan
                    ['id' => $spareparts[17]->id, 'qty' => 1], // Ban belakang
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Pemasangan velg depan selesai, proses balancing roda belakang.',
            ],
            [
                'vehicle_id' => $vehicles[7]->id,
                'customer_id' => $customers[6]->id,
                'complaint' => 'Servis berkala rutin 5.000 KM dan ganti oli Yamalube Super Sport.',
                'service_date' => Carbon::now()->toDateString(),
                'status' => 'in_progress',
                'mechanic_id' => $mechanics[4]->id,
                'estimation' => 'Tune up standar, pengecekan celah klep, dan ganti oli pelumas.',
                'service_cost' => 110000,
                'spareparts' => [
                    ['id' => $spareparts[1]->id, 'qty' => 1],
                    ['id' => $spareparts[6]->id, 'qty' => 1],
                ],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Sedang dilakukan pengurasan oli dan pengecekan filter udara.',
            ],
            [
                'vehicle_id' => $vehicles[8]->id,
                'customer_id' => $customers[7]->id,
                'complaint' => 'Pemasangan lampu LED Osram HS1 baru dan perapihan jalur kelistrikan tambahan.',
                'service_date' => Carbon::now()->toDateString(),
                'status' => 'in_progress',
                'mechanic_id' => $mechanics[2]->id,
                'estimation' => 'Pengecekan relay lampu dan instalasi soket waterproof LED Osram.',
                'service_cost' => 95000,
                'spareparts' => [
                    ['id' => $spareparts[19]->id, 'qty' => 1],
                ],
                'payment_type' => 'non-cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Pemasangan kabel body selesai, pengujian fokus sorot lampu.',
            ],

            // 4 Menunggu (Waiting)
            [
                'vehicle_id' => $vehicles[5]->id,
                'customer_id' => $customers[4]->id,
                'complaint' => 'Suara decit rem belakang keras dan tuas rem depan terasa terlalu dalam saat ditekan.',
                'service_date' => Carbon::now()->toDateString(),
                'status' => 'waiting',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Motor sudah parkir di antrean pit 2.',
            ],
            [
                'vehicle_id' => $vehicles[9]->id,
                'customer_id' => $customers[8]->id,
                'complaint' => 'Servis berkala Honda PCX 160, ganti oli mesin SPX dan oli transmisi akhir.',
                'service_date' => Carbon::now()->toDateString(),
                'status' => 'waiting',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Menunggu mekanik pit CVT menyelesaikan unit sebelumnya.',
            ],
            [
                'vehicle_id' => $vehicles[10]->id,
                'customer_id' => $customers[9]->id,
                'complaint' => 'Pengecekan suspensi depan bocor oli di as shock kiri.',
                'service_date' => Carbon::now()->addDay()->toDateString(),
                'status' => 'waiting',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Booking pendaftaran via website untuk jadwal besok pagi.',
            ],
            [
                'vehicle_id' => $vehicles[11]->id,
                'customer_id' => $customers[10]->id,
                'complaint' => 'Servis besar motor sport Honda CBR250RR, pembersihan kerak ruang bakar carbon cleaner.',
                'service_date' => Carbon::now()->addDay()->toDateString(),
                'status' => 'waiting',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'non-cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Jadwal servis telah diverifikasi admin via telepon.',
            ],

            // 3 Dibatalkan (Cancelled)
            [
                'vehicle_id' => $vehicles[12]->id,
                'customer_id' => $customers[11]->id,
                'complaint' => 'Permintaan ganti oli dan ganti ban luar.',
                'service_date' => Carbon::now()->subDays(2)->toDateString(),
                'status' => 'cancelled',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Dibatalkan oleh pelanggan karena ada tugas luar kota mendadak.',
            ],
            [
                'vehicle_id' => $vehicles[13]->id,
                'customer_id' => $customers[12]->id,
                'complaint' => 'Pengecekan sistem kelistrikan speedometer mati.',
                'service_date' => Carbon::now()->subDays(7)->toDateString(),
                'status' => 'cancelled',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Pelanggan tidak hadir setelah konfirmasi 3 kali (No Show).',
            ],
            [
                'vehicle_id' => $vehicles[14]->id,
                'customer_id' => $customers[13]->id,
                'complaint' => 'Servis ringan dan penggantian kampas rem.',
                'service_date' => Carbon::now()->subDays(10)->toDateString(),
                'status' => 'cancelled',
                'mechanic_id' => null,
                'estimation' => null,
                'service_cost' => 0,
                'spareparts' => [],
                'payment_type' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => null,
                'notes' => 'Pelanggan membatalkan reservasi servis.',
            ],
        ];

        foreach ($servicesData as $sData) {
            $service = ServiceRegistration::create([
                'vehicle_id' => $sData['vehicle_id'],
                'customer_id' => $sData['customer_id'],
                'complaint' => $sData['complaint'],
                'service_date' => $sData['service_date'],
                'status' => $sData['status'],
            ]);

            // Jika status completed atau in_progress, buat detail servis dan sparepart
            if (in_array($sData['status'], ['completed', 'in_progress']) && $sData['mechanic_id']) {
                $detail = ServiceDetail::create([
                    'service_registration_id' => $service->id,
                    'mechanic_id' => $sData['mechanic_id'],
                    'estimation' => $sData['estimation'],
                    'service_cost' => $sData['service_cost'],
                    'status' => $sData['status'],
                ]);

                $totalSparepartCost = 0;

                foreach ($sData['spareparts'] as $spItem) {
                    $sparepart = Sparepart::find($spItem['id']);
                    $subtotal = $sparepart->price * $spItem['qty'];
                    $totalSparepartCost += $subtotal;

                    ServiceSparepart::create([
                        'service_detail_id' => $detail->id,
                        'sparepart_id' => $sparepart->id,
                        'quantity' => $spItem['qty'],
                        'unit_price' => $sparepart->price,
                        'subtotal' => $subtotal,
                    ]);

                    // Kurangi stok jika servis selesai atau sedang berjalan
                    $sparepart->decrement('stock', $spItem['qty']);
                }

                $totalAmount = $sData['service_cost'] + $totalSparepartCost;

                Payment::create([
                    'service_registration_id' => $service->id,
                    'service_cost' => $sData['service_cost'],
                    'sparepart_cost' => $totalSparepartCost,
                    'total_amount' => $totalAmount,
                    'payment_type' => $sData['payment_type'],
                    'status' => $sData['payment_status'],
                    'notes' => $sData['notes'],
                    'payment_date' => $sData['payment_date'],
                ]);
            }
        }

        // 7. Contact Messages (Pesan Pelanggan Masuk)
        ContactMessage::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'phone' => '081298765432',
            'subject' => 'Pertanyaan Ketersediaan Sparepart Kawasaki ZX-25R',
            'message' => 'Halo tim MOTOVEL, apakah stok kampas rem Brembo dan filter K&N untuk motor ZX-25R tahun 2023 saat ini tersedia jika saya ingin booking servis akhir pekan ini?',
            'is_read' => true,
        ]);

        ContactMessage::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina.wijaya@outlook.com',
            'phone' => '081387654321',
            'subject' => 'Estimasi Biaya Paket Servis CVT Motor Matic',
            'message' => 'Selamat siang, saya ingin menanyakan rincian biaya servis CVT berkala untuk Honda Vario 160 beserta pembersihan injector. Terima kasih.',
            'is_read' => false,
        ]);

        ContactMessage::create([
            'name' => 'Ferry Gunawan',
            'email' => 'ferry.gunawan@yahoo.com',
            'phone' => '081576543210',
            'subject' => 'Konsultasi dyno test dan remap ECU harian',
            'message' => 'Selamat sore, apakah di bengkel MOTOVEL menerima setting ECU standar untuk motor Honda CBR250RR agar rpm bawah lebih padat? Berapa estimasi pengerjaannya?',
            'is_read' => false,
        ]);
    }
}
