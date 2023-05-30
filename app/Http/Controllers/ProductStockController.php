<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\ProductPurchase;
use App\Models\Currencie;
use App\Models\ProductStock;
use App\Models\Utility;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(\Auth::user()->can('manage product & service'))
        {
            $productServices = ProductService::with("products")->where('created_by', '=', \Auth::user()->creatorId())->orderByDesc('id')->get();

            return view('productstock.index', compact('productServices'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductStock $productStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productPurchase = ProductPurchase::find($id);
        $productService = ProductService::find($productPurchase->product_id); 

        $currencies = Currencie::where('created_by',\Auth::user()->creatorId())->get()->pluck('name', 'id');
        $currencies->prepend("--","");

        if(\Auth::user()->can('edit product & service'))
        {
            if($productService->created_by == \Auth::user()->creatorId())
            {
                return view('productstock.edit', compact('productService','productPurchase','currencies'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit product & service'))
        {
            $productService = ProductService::find($id);
            $total = $productService->quantity + $request->quantity;

            if($productService->created_by == \Auth::user()->creatorId())
            {
                $productService->quantity   = $total;
                $productService->created_by = \Auth::user()->creatorId();
                $productService->save();

                $productPurchase = new productPurchase();
                $productPurchase->product_id=$productService->id;
                $productPurchase->sale_price=$request->sale_price;
                $productPurchase->purchase_price=$request->purchase_price;
                $productPurchase->issue_date=date("Y-m-d", strtotime($request->issue_date));
                $productPurchase->quantity=$total;
                $productPurchase->currency_id=$request->currency_id;
                $productPurchase->save();

                //Product Stock Report
                $type        = 'manually';
                $type_id     = 0;
                $description = $request->quantity . '  ' . __('quantity added by manually');
                Utility::addProductStock($productService->id, $request->quantity, $type, $description, $type_id);


                return redirect()->route('productstock.index')->with('success', __('Product quantity updated manually.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductStock $productStock)
    {
        //
    }
}
