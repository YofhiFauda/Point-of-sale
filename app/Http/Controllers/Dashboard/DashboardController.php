<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index(Request $request)
{
    $filter = $request->input('filter', 'all');

    $orderDetailsQuery = OrderDetails::orderBy('order_id');

    // Apply filters based on the selected option
    if ($filter == 'today') {
        $orderDetailsQuery->whereDate('created_at', today());
    } elseif ($filter == 'this_week') {
        $orderDetailsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($filter == 'this_month') {
        $orderDetailsQuery->whereMonth('created_at', now()->month);
    }

    $orderDetails = $orderDetailsQuery->paginate(5); // Paginate with 5 items per page

    return view('dashboard.index', [
        'total_paid' => Order::sum('pay'),
        'total_due' => Order::sum('due'),
        'order_status' => Order::where('order_status', 'pending')->get(),
        'complete_orders' => Order::where('order_status', 'complete')->get(),
        'orderDetails' => $orderDetails,
        'products' => Product::orderBy('product_store')->take(5)->get(),
        'new_products' => Product::orderBy('buying_date')->take(2)->get(),
        'filter' => $filter, // Add this line to pass $filter to the view
    ]);
}
    
}
