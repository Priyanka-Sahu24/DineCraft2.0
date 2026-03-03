<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ======================
        // TOP CARDS
        // ======================

        $totalStaff   = Staff::count();
        $totalTables  = Table::count();
        $totalOrders  = Order::count();
        $totalRevenue = OrderItem::sum('subtotal');


        // ======================
        // MONTHLY ORDERS (LINE)
        // ======================

        $ordersData = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $ordersChartLabels = [];
        $ordersChartData   = [];

        foreach ($ordersData as $data) {
            $ordersChartLabels[] = date("M", mktime(0,0,0,$data->month,1));
            $ordersChartData[]   = $data->total;
        }


        // ======================
        // MONTHLY REVENUE (BAR)
        // ======================

        $revenueData = OrderItem::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(subtotal) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $revenueChartLabels = [];
        $revenueChartData   = [];

        foreach ($revenueData as $data) {
            $revenueChartLabels[] = date("M", mktime(0,0,0,$data->month,1));
            $revenueChartData[]   = $data->total;
        }


        // ======================
        // ORDER TYPE (PIE)
        // ======================

        $orderTypeData = Order::select(
                'order_type',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('order_type')
            ->get();

        $orderTypeLabels = $orderTypeData->pluck('order_type');
        $orderTypeCounts = $orderTypeData->pluck('total');


        // ======================
        // ORDER STATUS (DOUGHNUT)
        // ======================

        $orderStatusData = Order::select(
                'order_status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('order_status')
            ->get();

        $orderStatusLabels = $orderStatusData->pluck('order_status');
        $orderStatusCounts = $orderStatusData->pluck('total');


        // ======================
        // RECENT ACTIVITY
        // ======================
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentReservations = \App\Models\Reservation::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentLeaves = \App\Models\Leave::with('staff.user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStaff',
            'totalTables',
            'totalOrders',
            'totalRevenue',
            'ordersChartLabels',
            'ordersChartData',
            'revenueChartLabels',
            'revenueChartData',
            'orderTypeLabels',
            'orderTypeCounts',
            'orderStatusLabels',
            'orderStatusCounts',
            'recentOrders',
            'recentReservations',
            'recentLeaves'
        ));
    }
}