<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class Analytics extends Controller
{
    public function index()
    {
        return view('content.dashboard.dashboards-analytics');
    }
    public function customer_dashboard()
    {

        $products = Product::get();
        return view('content.customer.dashboards-customer', compact('products'));
    }
    public function product_dashboard()
    {

        $products = Product::orderBy('created_at')->get();
        return view('content.admin.dashboards-product', compact('products'));
    }
    public function product_add()
    {
        $category = Category::get();
        $uoms = UOM::get();

        return view('content.admin.add-product', compact('category', 'uoms'));
    }
    public function product_edit($id)
    {
        $category = Category::get();
        $uoms = UOM::get();

        $product = Product::find($id);
        return view('content.admin.edit-product', compact('product', 'uoms', 'category'));
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
            'uom_id' => $request->uom,

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
}
