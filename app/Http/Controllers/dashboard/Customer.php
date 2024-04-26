<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        $count = OrderDetail::where('order_id', $orders->id)->count();
        if ($count == 0) {
            $orders->delete();
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
        $payment = Payment::create([
            'order_id' => $request->order_id,
            'customer_id' => $request->user_id,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_contact' => $request->customer_contact,
            'delivery_method' => $request->radioDeliveryMethod,
            'payment_date' => now(),
            'payment_amount' => $request->total_amount,
            'payment_method' => $request->radioPaymentMethod,
            'payment_receipt' => $request->payment_receipt,
            'payment_status' => 'U',
            'created_at' => now(),
        ]);

        if ($request->hasFile('payment_receipt')) {

            $attachment = $request->file('payment_receipt');
            $att_name = $attachment->getClientOriginalName();
            $filename = pathinfo($att_name, PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . rand() . '.' . $extension;
            $path = $attachment->move(storage_path('app/public/payment/'), $fileNameToStore);

            $uptm = Payment::where('id', $id)->update([
                'payment_receipt' => $request->payment_receipt,
            ]);
        }

        if ($payment) {
            $update_order = Order::where('id', $request->order_id)->update([
                'fullfillment_status' => 'F',
            ]);
        }

        if ($update_order) {

            Session::flash('success', 'Payment process success!');
        } else {
            Session::flash('error', 'Payment process failed. Please try again later.');
        }
        return redirect()->route('dashboard-customer');
    }
}
