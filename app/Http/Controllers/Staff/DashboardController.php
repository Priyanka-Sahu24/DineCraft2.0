<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $staff = $user->staff;

        $data = [];

        // =========================
        // CHEF
        // =========================
        if ($user->hasRole('chef')) {

            $data['pendingOrders'] = Order::where('order_status', 'Pending')->count();

            $data['preparingOrders'] = Order::where('order_status', 'Preparing')->count();
        }

        // =========================
        // WAITER
        // =========================
        if ($user->hasRole('waiter')) {

            $data['myOrders'] = Order::where('staff_id', $staff->id)->count();

            $data['activeOrders'] = Order::where('staff_id', $staff->id)
                                        ->whereNotIn('order_status', ['Completed'])
                                        ->count();
        }

        // =========================
        // CASHIER
        // =========================
        if ($user->hasRole('cashier')) {

            $data['completedOrders'] = Order::where('order_status', 'Completed')->count();

            $data['todayOrders'] = Order::whereDate('created_at', today())->count();
        }

        // =========================
        // DELIVERY
        // =========================
        if ($user->hasRole('delivery')) {

            $data['deliveryOrders'] = Order::where('staff_id', $staff->id)
                                           ->where('order_type', 'Delivery')
                                           ->count();

            $data['deliveredOrders'] = Order::where('staff_id', $staff->id)
                                            ->where('order_status', 'Delivered')
                                            ->count();
        }

        // =========================
        // 📈 MONTHLY ORDERS (LINE CHART)
        // =========================

        $monthlyOrders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData   = [];

        foreach ($monthlyOrders as $item) {
            $chartLabels[] = date("M", mktime(0,0,0,$item->month,1));
            $chartData[]   = $item->total;
        }

        $data['chartLabels'] = $chartLabels;
        $data['chartData']   = $chartData;


        // =========================
        // 🥧 ORDER STATUS (PIE CHART)
        // =========================

        $statusData = Order::select(
                'order_status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('order_status')
            ->get();

        $data['statusLabels'] = $statusData->pluck('order_status');
        $data['statusCounts'] = $statusData->pluck('total');


        return view('staff.dashboard', $data);
    }
}