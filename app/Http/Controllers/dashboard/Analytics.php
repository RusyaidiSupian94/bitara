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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Analytics extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('d-m-Y');
        $category = Category::all();

        $products = Product::join('tbl_category', 'tbl_product.category_id', '=', 'tbl_category.id')
            ->orderBy('tbl_product.total_stock', 'desc')
            ->get(['tbl_product.*', 'tbl_category.category_description']);
        return view(
            'content.dashboard.dashboards-analytics',
            compact('today', 'products', 'category')
        );
    }

    public function dashboard_data(Request $request)
    {
        $data = [];

        $today = Carbon::now()->timezone('Asia/Kuala_Lumpur')->toDateString();

        $min_date = $request->min;
        $max_date = $request->max;

        $orderQuery = Payment::query();

        if ($min_date) {
            // Filter based on min_date if provided
            $orderQuery->whereDate('payment_date', '>=', $min_date);
        }
        if ($max_date) {
            // Filter based on max_date if provided
            $orderQuery->whereDate('payment_date', '<=', $max_date);
        }
        if (!isset($min_date) && !isset($max_date)) {
            $orderQuery->whereDate('payment_date', $today);
        }
        $data['sale'] = $orderQuery->sum('payment_amount');
        $data['order'] = $orderQuery->count();

        $data['delivery'] = $orderQuery->where('delivery_method', '1')->count();
        
        $data['pickup'] = $orderQuery->where('delivery_method', '2')->count();

        // $data['delivery'] = $orderQuery->whereHas('payment', function ($payment) {
        //     $payment->where('delivery_method', '1');
        // })->count();
        // $data['pickup'] = $orderQuery->whereHas('payment', function ($payment) {
        //     $payment->where('delivery_method', '2');
        // })->count();

        return $data;
    }
    public function dashboard_data_trend(Request $request)
    {
        $data = [];

        $today = Carbon::now()->timezone('Asia/Kuala_Lumpur')->toDateString();
        $min_date = $request->min;
        $max_date = $request->max;

        // Get all categories
        $categories = Category::all();

        // Initialize data array to store results
        $data['category'] = $categories->pluck('category_description');

        // Initialize query builder for orders
        $orderQuery = Payment::query();

        // Apply date range filters if provided

        if ($min_date) {
            // Filter based on min_date if provided
            $orderQuery->whereDate('payment_date', '>=', $min_date);
        }
        if ($max_date) {
            // Filter based on max_date if provided
            $orderQuery->whereDate('payment_date', '<=', $max_date);
        }
        if (!isset($min_date) && !isset($max_date)) {
            $orderQuery->whereDate('payment_date', $today);
        }
        // Iterate over categories to count orders for each category
        foreach ($categories as $category) {
            $count = $orderQuery->whereHas('order.details.product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count();

            // Assign count to corresponding category description key in $data array
            $data[$category->category_description] = $count;
        }

        return $data;
    }


    public function product_dashboard()
    {
        $products = Product::with('category', 'weight')->orderBy('created_at')->get();
        return view('content.admin.product.dashboards-product', compact('products'));
    }
    public function product_list(Request $request)
    {
        $category = $request->category_id;
        $products = Product::with('category', 'weight')->where('category_id', $category)->orderBy('created_at')->get();
        return $products;
    }
    public function reporting_dashboard()
    {
        $array = [];
        $products = Product::orderBy('created_at')->get();
        $payments = Payment::with('order')->get();
        $product_id = Product::pluck('id')->toArray();
        foreach ($product_id as $key => $value) {
            # code...
            $order_qty_sum = OrderDetail::where('product_id', $value)->sum('product_qty');
            // Assuming $order_qty_sum represents the total quantity ordered for this product

            $product = Product::find($value); // Assuming $value represents the product_id

            $array[$key] = [
                'product_id' => $value,
                'product_name' => $product->product_name,
                'cost_price' => $product->cost_price,
                'sell_price' => $product->unit_price,
                'stock_qty' => $product->total_stock,
                'sell_product_qty' => $order_qty_sum,
                'total_cost' => $order_qty_sum * $product->cost_price,
                'total_sell' => $order_qty_sum * $product->unit_price,
                'profit' => ($order_qty_sum * $product->unit_price) - ($order_qty_sum * $product->cost_price),
            ];
        }

        return view('content.admin.reporting.dashboards-reporting', compact('products', 'array', 'payments'));
    }
    public function product_add()
    {
        $category = Category::get();
        $uoms = UOM::get();

        return view('content.admin.product.add-product', compact('category', 'uoms'));
    }
    public function product_edit($id)
    {
        $category = Category::get();
        $uoms = UOM::get();

        $product = Product::find($id);
        return view('content.admin.product.edit-product', compact('product', 'uoms', 'category'));
    }
    public function product_delete(Request $request)
    {
        $data = Product::where('id', $request->product_id)->first();
        $attach = $data->product_img;
        $file_path = storage_path('app/public/product/' . $attach);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        $product = Product::find($request->product_id)->delete();
        if ($product) {
            return true;
        }
    }
    public function product_store(Request $request)
    {
        $add_product = Product::create([
            'product_name' => $request->product_name,
            'product_details' => $request->product_details,
            'cost_price' => $request->cost,
            'unit_price' => $request->unit_price,
            'total_stock' => $request->total_stock,
            'category_id' => $request->category,
            'uom_id' => 1,
            'created_by' => Auth::user()->name,
            'created_at' => now(),

        ]);

        if ($request->hasFile('product_img')) {
            $attachment = $request->file('product_img');
            $att_name = $attachment->getClientOriginalName();
            $filename = pathinfo($att_name, PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . rand() . '.' . $extension;
            $path = $attachment->move(storage_path('app/public/product/'), $fileNameToStore);

            $uptm = Product::where('id', $add_product->id)->update([
                'product_img' => $fileNameToStore,
            ]);
        }

        if ($add_product) {

            Session::flash('success', 'File has been saved successfully');
        } else {
            Session::flash('error', 'Failed to save product. Please try again later.');
        }
        return redirect()->route('dashboard-product');
    }

    public function product_store_edited(Request $request, $id)
    {

        $update_product = Product::where('id', $id)
            ->update([
                'product_name' => $request->product_name,
                'product_details' => $request->product_details,
                'cost_price' => $request->cost,
                'unit_price' => $request->unit_price,
                'total_stock' => $request->total_stock,
                'category_id' => $request->category,
                'uom_id' => 1,
                'updated_by' => Auth::user()->name,
                'updated_at' => now(),
            ]);

        if ($request->hasFile('product_img')) {
            $data = Product::where('id', $id)->first();
            $attach = $data->product_img;
            $file_path = storage_path('app/public/product/' . $attach);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            $attachment = $request->file('product_img');
            $att_name = $attachment->getClientOriginalName();
            $filename = pathinfo($att_name, PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . rand() . '.' . $extension;
            $path = $attachment->move(storage_path('app/public/product/'), $fileNameToStore);

            $uptm = Product::where('id', $id)->update([
                'product_img' => $fileNameToStore,
            ]);
        }

        if ($update_product) {

            Session::flash('success', 'File has been saved successfully');
        } else {
            Session::flash('error', 'Failed to save product. Please try again later.');
        }
        return redirect()->route('dashboard-product');
    }
}
