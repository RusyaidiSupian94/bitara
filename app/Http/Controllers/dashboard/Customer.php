<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\UOM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Customer extends Controller
{

    public function customer_dashboard()
    {
        $user = Auth::user();
        $category = Category::get();
        $products = Product::with('weight')->get();
        $order_paid = Order::with('payment', 'details.product', 'details.weight')->where('customer_id', $user->id)->get();

        $cart = Cart::with('product', 'weight')->where('customer_id', $user->id)->get();

        return view('content.customer.dashboards-customer', compact('products', 'user', 'cart', 'category', 'order_paid'));
    }
    public function cart_datatable(Request $request) // add to cart
    {
        $product = Product::find($request->id);
        $uomid = UOM::where('description', $request->uomdescription)->pluck('id')->first();
        //calculation qty for amount
        $uomqty = UOM::where('id', $uomid)->pluck('qty')->first();
        $amount = $product->unit_price * ($request->qty / $uomqty);

        $add = Cart::create([
            'customer_id' => Auth::user()->id,
            'product_id' => $request->id,
            'product_qty' => $request->qty,
            'product_uom' => $uomid,
            'sub_total' => $amount,
        ]);
        return response()->json(['success' => 'Added to cart']);
    }

    public function cart_remove(Request $request)
    {
        //remove data
        $cart = Cart::where('id', $request->id)->first()->delete();
        return response()->json(['success' => 'Successfully remove from cart']);
    }

    public function checkout($id)
    {
        return redirect()->route('add-payment', ['id' => $id]);
    }

    public function add_payment()
    {
        $user = Auth::user()->id;
        $customer = User::with('user_details')->find($user);
        $cart = Cart::with('product', 'weight')->where('customer_id', $user)->get();

        return view('content.payment.add-payment', compact('customer', 'cart'));
    }
    public function order_payment(Request $request, $id)
    {
        $order = Order::create([
            'customer_id' => $id,
            'order_status' => 'N',
            'order_type' => 'O',
            'date' => now(),
            'total_amount' => $request->total_amount,
            'fullfillment_status' => 'U',
            'created_at' => now(),
        ]);
        if ($order) {

            $carts = Cart::with('product', 'weight')->where('customer_id', $id)->get();

            foreach ($carts as $key => $item) {
                $order_details = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_qty' => $item->product_qty,
                    'product_uom' => $item->product_uom,
                    'sub_total' => $item->product->unit_price * $item->product_qty,
                ]);
            }
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'customer_id' => $id,
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

            $uptm = Payment::where('order_id', $order->id)->update([
                'payment_receipt' => $fileNameToStore,
            ]);
        }
        if ($payment) {
            $carts->each(function ($cart) {
                $cart->delete();
            });

            Session::flash('success', 'Payment process success!');
        } else {
            Session::flash('error', 'Payment process failed. Please try again later.');
        }
        return redirect()->route('dashboard-customer');
    }
}
