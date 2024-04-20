<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer extends Controller
{
    public function cart_datatable(Request $request)
    {

        $product = Product::find($request->id);
        $amount = $product->unit_price * $request->qty;

        //checking data is exist with status 'T'
        $orders = Order::where('customer_id', $request->userid)->whereIn('order_status', ['T', 'N'])->first();
        if ($orders) {
            $orderDetail = OrderDetail::where('order_id', $orders->id)->where('product_id', $request->id)->first();
            if ($orderDetail) {
                $newQty = $request->qty + $orderDetail->product_qty;
                $newAmount = $product->unit_price * $newQty;

                $newTotalAmount = $newAmount + ($orders->total_amount - $orderDetail->sub_total);
                $add_cart = Order::where('id', $orders->id)->update([
                    'date' => now(),
                    'total_amount' => $newTotalAmount,
                    'fullfillment_status' => 'U',
                    'created_at' => now(),
                ]);

                $add_cart_detail = OrderDetail::where('id', $orderDetail->id)->update([
                    'product_qty' => $newQty,
                    'sub_total' => $newAmount,
                ]);
            } else {
                $add_cart_detail = OrderDetail::create([
                    'order_id' => $orders->id,
                    'product_id' => $request->id,
                    'product_qty' => $request->qty,
                    'sub_total' => $amount,
                ]);

                $newTotalAmount = $amount + $orders->total_amount;
                $add_cart = Order::where('id', $orders->id)->update([
                    'date' => now(),
                    'total_amount' => $newTotalAmount,
                    'fullfillment_status' => 'U',
                    'created_at' => now(),
                ]);
            }
        } else {
            $add_cart = Order::create([
                'customer_id' => $request->userid,
                'order_status' => 'T',
                'date' => now(),
                'total_amount' => $amount,
                'fullfillment_status' => 'U',
                'created_at' => now(),
            ]);

            $add_cart_detail = OrderDetail::create([
                'order_id' => $add_cart->id,
                'product_id' => $request->id,
                'product_qty' => $request->qty,
                'sub_total' => $amount,
            ]);
        }

        return response()->json(['success' => 'Added to cart']);
    }

    public function cart_remove(Request $request)
    {
        //remove data
        $orders = Order::where('customer_id', $request->userid)->whereIn('order_status', ['T', 'N'])->first();
        if ($orders) {
            $orderDetail = OrderDetail::where('product_id', $request->id)->first();
            if ($orderDetail) {
                $newTotalAmount = ($orders->total_amount - $orderDetail->sub_total);
                $update_cart = Order::where('id', $orders->id)->update([

                    'date' => now(),
                    'total_amount' => $newTotalAmount,
                    'fullfillment_status' => 'U',
                    'created_at' => now(),
                ]);
                $delete_cart_detail = OrderDetail::where('id', $orderDetail->id)->delete();
            }
        }

        return response()->json(['success' => 'Successfully remove from cart']);
    }

    public function checkout($id)
    {
        //remove data
        $orders = Order::where('id', $id)->whereIn('order_status', ['T', 'N'])->where('fullfillment_status', 'U')->first();
        if ($orders) {
            $update_order = Order::where('id', $orders->id)->update([
                'order_status' => 'N',
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('add-payment', ['id' => $orders->id]);
    }

    public function add_payment($id)
    {
        $user = Auth::user();
        $order = Order::with('customer.user_details', 'details.product')->where('id', $id)->first();


        return view('content.payment.add-payment', compact('user', 'order'));
    }
    public function order_payment(Request $request, $id)
    {

        $user = Auth::user();
        $update_order = Order::where('customer_id', $id)->update([
            'fullfillment_status' => 'F',
            'delivery_method' => $request->radioDeliveryMethod,
            'payment_method' => $request->radioPaymentMethod,
            'updated_at' => now(),
        ]);

        $products = Product::get();

        $order = OrderDetail::with('order', 'product')->whereHas('order', function ($q) use ($user) {
            $q->where('customer_id', $user->id)->whereIn('order_status', ['T', 'N'])->where('fullfillment_status', ['U']);
        })->get();

        $totalCart = Order::where('customer_id', $user->id)->whereIn('order_status', ['T', 'N'])->where('fullfillment_status', ['U'])->count();

        // return view('content.customer.dashboards-customer', compact('products', 'user', 'order', 'totalCart'));

        return redirect()->route('dashboard-customer');
    }
}
