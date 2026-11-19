<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\ServiceRegistration;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Tampilkan pusat laporan dan analisis operasional bengkel.
     */
    public function index(Request $request): View
    {
        $reportType = $request->query('type', 'revenue');
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $data = $this->fetchReportData($reportType, $startDate, $endDate);

        return view('admin.reports.index', compact('reportType', 'startDate', 'endDate', 'data'));
    }

    /**
     * Halaman cetak laporan resmi (Print-Friendly Layout).
     */
    public function print(Request $request): View
    {
        $reportType = $request->query('type', 'revenue');
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $data = $this->fetchReportData($reportType, $startDate, $endDate);

        return view('admin.reports.print', compact('reportType', 'startDate', 'endDate', 'data'));
    }

    /**
     * Helper untuk mengambil data laporan berdasarkan jenis dan rentang tanggal.
     */
    private function fetchReportData(string $type, string $startDate, string $endDate): array
    {
        switch ($type) {
            case 'revenue':
                $payments = Payment::with(['serviceRegistration.vehicle', 'serviceRegistration.customer'])
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                $totalPaid = $payments->where('status', 'paid')->sum('total_amount');
                $totalPending = $payments->where('status', 'pending')->sum('total_amount');
                $totalServiceCost = $payments->where('status', 'paid')->sum('service_cost');
                $totalSparepartCost = $payments->where('status', 'paid')->sum('sparepart_cost');

                return [
                    'records' => $payments,
                    'totalPaid' => $totalPaid,
                    'totalPending' => $totalPending,
                    'totalServiceCost' => $totalServiceCost,
                    'totalSparepartCost' => $totalSparepartCost,
                ];

            case 'services':
                $services = ServiceRegistration::with(['vehicle', 'customer', 'serviceDetail.mechanic', 'payment'])
                    ->whereBetween('service_date', [$startDate, $endDate])
                    ->latest('service_date')
                    ->get();

                return [
                    'records' => $services,
                    'totalServices' => $services->count(),
                    'completedCount' => $services->where('status', 'completed')->count(),
                    'inProgressCount' => $services->where('status', 'in_progress')->count(),
                    'waitingCount' => $services->where('status', 'waiting')->count(),
                    'cancelledCount' => $services->where('status', 'cancelled')->count(),
                ];

            case 'spareparts':
                $usedParts = ServiceSparepart::with(['sparepart', 'serviceDetail.serviceRegistration.vehicle'])
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                $totalQuantity = $usedParts->sum('quantity');
                $totalValue = $usedParts->sum('subtotal');

                return [
                    'records' => $usedParts,
                    'totalQuantity' => $totalQuantity,
                    'totalValue' => $totalValue,
                ];

            case 'customers':
                $customers = Customer::withCount(['vehicles', 'serviceRegistrations'])
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                return [
                    'records' => $customers,
                    'totalCustomers' => $customers->count(),
                ];

            case 'vehicles':
                $vehicles = Vehicle::with('customer')
                    ->withCount('serviceRegistrations')
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                return [
                    'records' => $vehicles,
                    'totalVehicles' => $vehicles->count(),
                    'maticCount' => $vehicles->where('type', 'matic')->count(),
                    'manualCount' => $vehicles->where('type', 'manual')->count(),
                ];

            default:
                return [];
        }
    }
}
