<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function importProduct(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function saleItem(Request $request)
    {
        try{
            $productCount = Product::count();
            if($productCount == 0)
            {
                return redirect()->back()->with('error', 'Please first Import Product');
            }

            for ($i = 0; $i < 500; $i++) {
                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'total' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $totalPrice = 0;

                for ($j = 0; $j < rand(1, 5); $j++) {
                    $productId = rand(1, 100);
                    $productData = Product::find($productId);
                    if($productData)
                    {
                        SaleItem::create([
                            'sale_id' => $sale->id,
                            'product_id' => $productId,
                            'quantity' => rand(1, 10),
                            'price' => $productData->price,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        $totalPrice+= (int)$productData->price;
                    }
                }

                Sale::where('id', $sale->id)->update(['total' => $totalPrice]);
            }

            return redirect()->back()->with('success', 'Dummy records added successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }

    }

}
