<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Orders extends Controller
{
    public function index()
    {
        return view('content.dashboard.dashboards-analytics');
    }

    public function order_dashboard()
    {

        $new_orders = Order::with('customer.user_details')->where('order_status','N')->orderBy('created_at')->get();
        $orders = Order::with('customer.user_details')->whereIn('order_status',['P','D','C'])->orderBy('created_at')->get();
        return view('content.admin.order.dashboards-order', compact('new_orders','orders'));
    }

    public function order_prepare($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'P',
            'preparing_at' => now(),
            'preparing_by' =>Auth::user()->username,
            ]
        );

        if ($update_order) {

            Session::flash('success', 'Order submitted to preparing..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }
    public function order_cancel($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'R']
        );

        if ($update_order) {

            Session::flash('success', 'Order have been cancel..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }

    public function order_deliver($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'D',
            'delivering_at' => now(),
            'delivering_by' =>Auth::user()->username,]
        );

        if ($update_order) {
            Session::flash('success', 'Order submitted for delivery..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }

    public function order_complete($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'C',
            'completed_at' => now(),
            'completed_by' =>Auth::user()->username,]
        );

        if ($update_order) {
            Session::flash('success', 'Order completed..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }

    public function order_complete_detail(Request $request){
        $order = Order::with('customer.user_details','details.product')->where('id', $request->id)->first();

        return view('content.admin.order.complete-order-detail', compact('order'));


    }

    public function order_datatable(Request $request)
    {
        $orders = OrderDetail::where('order_id', $request->id)->with('product')->get();
        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('product_name', function ($row) {
                return $row->product->product_name;
            })
            ->addColumn('quantity', function ($row) {
                return $row->product_qty;
            })
            ->addColumn('sub_total', function ($row) {
                return $row->sub_total;
            })
            ->make(true);

    }

}
