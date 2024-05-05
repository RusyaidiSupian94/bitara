<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $new_orders = Payment::with('order.details.product', 'order.details.weight')->where('payment_status', 'U')->get();
        $orders = Payment::with('order.details.product', 'order.details.weight')->where('payment_status', 'F')->get();
        return view('content.admin.order.dashboards-order', compact('new_orders', 'orders'));
    }
    public function manual_order_dashboard()
    {

        $orders = Order::with('customer.user_details')->where('order_type', 'M')->orderBy('created_at')->get();
        return view('content.admin.order.dashboards-manual-order', compact( 'orders'));
    }

    public function order_add()
    {
        // $new_orders = Order::with('customer.user_details')->where('order_status','N')->orderBy('created_at')->get();
        $category = Category::get();
        $uoms = UOM::get();

        return view('content.admin.order.add-manual-order', compact('category', 'uoms'));
    }

    public function order_edit($id)
    {
        $category = Category::get();
        $uoms = UOM::get();
        $order = Order::with('details.product', 'details.weight')->find($id);

        return view('content.admin.order.edit-manual-order', compact('category', 'uoms', 'order'));
    }
    public function order_store(Request $request)
    {
        // dd($request->all(), Auth::user()->username);

        // $product = Product::find($request->id);
        // $amount = $product->unit_price * $request->qty;

        $add_order = Order::create([
            'customer_id' => Auth::user()->id,
            'order_status' => 'C',
            'order_type' => 'M',
            'date' => now(),
            // 'total_amount' => $amount,
            'fullfillment_status' => 'F',
            'created_at' => now(),
            'created_by' => Auth::user()->username,
        ]);

        foreach ($request->product_list as $key => $list) {
            $product = Product::find($list['id']);
            // dd($product)
            if ($list['weight'] == 1) {
                $subtotal = $product->unit_price * $list['qty'];
            } else if ($list['weight'] == 2) {
                $subtotal = $product->unit_price / 4 * $list['qty'];
            } else if ($list['weight'] == 3) {
                $subtotal = $product->unit_price / 2 * $list['qty'];
            } else {
                $subtotal = 0;
            }
            $add_cart_detail = OrderDetail::create([
                'order_id' => $add_order->id,
                'product_id' => $list['id'],
                'product_qty' => $list['qty'],
                'product_uom' => $list['weight'],
                'sub_total' => $subtotal,
            ]);
        }

        $orderDetails = OrderDetail::where('order_id', $add_order->id)->sum('sub_total');
        // dd($orderDetails);
        $update_order = Order::where('id', $add_order->id)->update([
            'total_amount' => $orderDetails,
        ]);

        return redirect()->route('dashboard-manual-order');

    }
    public function order_edited_store(Request $request, $id)
    {
        // dd($request->all(), Auth::user()->username);

        $edit_order = Order::where('id', $id)->update([
            'customer_id' => Auth::user()->id,
            'order_status' => 'C',
            'order_type' => 'M',
            'date' => now(),
            // 'total_amount' => $amount,
            'fullfillment_status' => 'F',
            'created_at' => now(),
            'created_by' => Auth::user()->username,
        ]);

        foreach ($request->product_list as $key => $list) {

            $product = Product::find($list['id']);
            if ($list['weight'] == 1) {
                $subtotal = $product->unit_price * $list['qty'];
            } else if ($list['weight'] == 2) {
                $subtotal = $product->unit_price / 4 * $list['qty'];
            } else if ($list['weight'] == 3) {
                $subtotal = $product->unit_price / 2 * $list['qty'];
            } else {
                $subtotal = 0;
            }
            if (isset($list['order_detail_id'])) {

                $add_detail = OrderDetail::where('id', $list['order_detail_id'])->update([
                    'order_id' => $id,
                    'product_id' => $list['id'],
                    'product_qty' => $list['qty'],
                    'product_uom' => $list['weight'],
                    'sub_total' => $subtotal,
                ]);
            } else {

                $add_detail = OrderDetail::create([
                    'order_id' => $id,
                    'product_id' => $list['id'],
                    'product_qty' => $list['qty'],
                    'product_uom' => $list['weight'],
                    'sub_total' => $subtotal,
                ]);
            }
        }

        $orderDetails = OrderDetail::where('order_id', $id)->sum('sub_total');
        // dd($orderDetails);
        $update_order = Order::where('id', $id)->update([
            'total_amount' => $orderDetails,
        ]);

        return redirect()->route('dashboard-manual-order');

    }

    public function order_process($id)
    {
        $payment = Payment::with('order.details.product', 'order.details.weight')->where('order_id', $id)->first();
        return view('content.admin.order.new-order-detail', compact('payment'));
    }

    public function order_prepare($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'P',
                'fullfillment_status' => 'F',
                'preparing_at' => now(),
                'preparing_by' => Auth::user()->username,
            ]
        );
        $update_payment = Payment::where('order_id', $id)->update(
            ['payment_status' => 'F',
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
            ['order_status' => 'CN']
        );

        if ($update_order) {

            Session::flash('success', 'Order have been cancel..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }

    public function order_ready($id)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'R',
                'ready_at' => now(),
                'ready_by' => Auth::user()->username]
        );

        if ($update_order) {
            Session::flash('success', 'Order is ready for customer..');
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
                'delivering_by' => Auth::user()->username]
        );

        if ($update_order) {
            Session::flash('success', 'Order submitted for delivery..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        return redirect()->route('dashboard-order');
    }

    public function order_complete($id, $page)
    {
        $update_order = Order::where('id', $id)->update(
            ['order_status' => 'C',
                'completed_at' => now(),
                'completed_by' => Auth::user()->username]
        );

        if ($update_order) {
            Session::flash('success', 'Order completed..');
        } else {
            Session::flash('error', 'Failed. Please try again later.');
        }
        if ($page == 'A') {

            return redirect()->route('dashboard-order');
        } elseif ($page == 'C') {
            return redirect()->route('dashboard-customer');

        }
    }

    public function order_complete_detail(Request $request)
    {
        // $order = Order::with('customer.user_details', 'details.product')->where('id', $request->id)->first();
        $payment = Payment::with('order.details.product', 'order.details.weight')->where('order_id', $request->id)->first();

        $page = $request->page;

        return view('content.admin.order.complete-order-detail', compact('payment', 'page'));

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
            ->addColumn('weight', function ($row) {
                $oum = UOM::find($row->product_uom);
                return $oum->description;
            })
            ->addColumn('sub_total', function ($row) {
                return $row->sub_total;
            })
            ->make(true);

    }

    public function remove_edited_order_item(Request $request)
    {
        $id = $request->item_id;
        $order = OrderDetail::find($id)->delete();
        if ($order) {
            return response()->json(['success' => 'Item removed!']);

        } else {
            return response()->json(['error' => 'Failed to removed!']);

        }

    }

      public function order_delete(Request $request)
    {
        $order_details = OrderDetail::where('order_id',$request->order_id)->get();
        foreach($order_details as $order){
            $order->delete();
        }
        $order = Order::find($request->order_id)->delete();
        if ($order) {
            return true;
        }
    }

}
