<?php

namespace App\Http\Controllers;

use App\Models\ServiceRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Tampilkan seluruh riwayat servis lengkap dengan filter multikriteria dan pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $serviceStatus = $request->query('service_status');
        $paymentStatus = $request->query('payment_status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $services = ServiceRegistration::with(['customer', 'vehicle', 'serviceDetail.mechanic', 'payment'])
            ->when($serviceStatus, function ($query, $serviceStatus) {
                $query->where('status', $serviceStatus);
            })
            ->when($paymentStatus, function ($query, $paymentStatus) {
                $query->whereHas('payment', function ($pq) use ($paymentStatus) {
                    $pq->where('status', $paymentStatus);
                });
            })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('service_date', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('service_date', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('service_id', 'like', "%{$search}%")
                        ->orWhere('complaint', 'like', "%{$search}%")
                        ->orWhereHas('vehicle', function ($vq) use ($search) {
                            $vq->where('plate_number', 'like', "%{$search}%");
                        })
                        ->orWhereHas('customer', function ($cq) use ($search) {
                            $cq->where('name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        })
                        ->orWhereHas('serviceDetail.mechanic', function ($mq) use ($search) {
                            $mq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('service_date')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.history.index', compact(
            'services',
            'search',
            'serviceStatus',
            'paymentStatus',
            'startDate',
            'endDate'
        ));
    }
}
