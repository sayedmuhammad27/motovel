<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\ServiceRegistration;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan statistik dan ringkasan dashboard operasional bengkel.
     */
    public function index(): View
    {
        $totalCustomers = Customer::count();
        $totalVehicles = Vehicle::count();
        $totalServices = ServiceRegistration::count();

        $servicesWaiting = ServiceRegistration::where('status', 'waiting')->count();
        $servicesInProgress = ServiceRegistration::where('status', 'in_progress')->count();
        $servicesCompleted = ServiceRegistration::where('status', 'completed')->count();
        $servicesCancelled = ServiceRegistration::where('status', 'cancelled')->count();

        $totalRevenue = Payment::where('status', 'paid')->sum('total_amount');
        $pendingRevenue = Payment::where('status', 'pending')->sum('total_amount');

        // 5 Servis Terbaru
        $recentServices = ServiceRegistration::with(['customer', 'vehicle', 'serviceDetail.mechanic', 'payment'])
            ->latest()
            ->take(6)
            ->get();

        // Data Grafik Servis berdasarkan Status
        $statusChartData = [
            'labels' => ['Menunggu', 'Sedang Dikerjakan', 'Selesai', 'Dibatalkan'],
            'data' => [$servicesWaiting, $servicesInProgress, $servicesCompleted, $servicesCancelled],
        ];

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalVehicles',
            'totalServices',
            'servicesWaiting',
            'servicesInProgress',
            'servicesCompleted',
            'servicesCancelled',
            'totalRevenue',
            'pendingRevenue',
            'recentServices',
            'statusChartData'
        ));
    }
}
