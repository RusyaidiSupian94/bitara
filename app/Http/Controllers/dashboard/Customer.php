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

class Customer extends Controller
{
    public function cart_datatable(Request $request)
    {
        // dd($request->all());

        $product = Product::find($request->id);
        $amount = $product->unit_price * $request->qty;

        //checking data is exist with status 'T'
        $orders = Order::where('customer_id', $request->userid)->where('order_status', 'T')->first();
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
                    'sub_total' => $amount
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
                'sub_total' => $amount
            ]);
        }


        return response()->json(['success' => 'Added to cart']);
    }

    public function cart_remove(Request $request)
    {
        //remove data
        $orders = Order::where('customer_id', $request->userid)->where('order_status', 'T')->first();
        if ($orders) {
            $orderDetail = OrderDetail::where('id', $request->id)->first();
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

    public function checkout(Request $request, $id)
    {
        //remove data
        $orders = Order::where('customer_id', $id)->where('order_status', 'T')->first();
        if ($orders) {
            $update_order = Order::where('id', $orders->id)->update([
                'order_status' => 'N',
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('add-payment', ['id' => $id]);
    }

    public function add_payment()
    {
        $user = Auth::user();
        return view('content.payment.add-payment', compact('user'));
    }
}
