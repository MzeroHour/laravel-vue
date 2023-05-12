<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ---------- Same Way for search data
        // if(request('search')){
        //    $product = Product::where('name', 'like', '%' . request('search') . '%')->orderBy('id', 'desc')->paginate(5);
        //    return $product;
        // }else{
        //      $product = Product::orderBy('id', 'desc')->paginate(5);
        //      return $product;
        // }

        // ---------- Same Way for search data
        // $product = Product::query();
        //  if(request('search')){
        //    return $product->where('name', 'like', '%' . request('search') . '%')->orderBy('id', 'desc')->paginate(5);

        // }else{
        //     return $product->Product::orderBy('id', 'desc')->paginate(5);
        // }

        // ---------- Same Way for search data
        return Product::when(request('search'), function($query){
            $query->where('name', 'like', '%' . request('search') . '%')->orderBy('id', 'desc')->paginate(5);
        })->orderBy('id', 'desc')->paginate(5);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {

    // --- Validation
    //     $request->validate([
    //         'name' => 'required|string',
    //         'price' => 'required|numeric'
    //     ],
    // [
    //     'name.required'=> "အမည်ထည့်ရန်လိုအပ်သည်။",
    //     'name.string'=> "အမည် စာသားဖြစ်ရမည်။",
    //     'price.required'=> "ဈေးနှုန်း ထည့်ရန်လိုအပ်သည်။",
    //     'price.numeric'=> "ဈေးနှုန်း နံပါတ်ဖြစ်ရမည်။"
    // ]);

      // --- same way Store (save)
        // $product = new Product();
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->save();
        // return $product;


        $product = Product::create($request->only('name', 'price'));
        return $product;

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {


    //     // --- Validation
    //     $request->validate([
    //         'name' => 'nullable|string',
    //         'price' => 'nullable|numeric'
    //     ],[
    //         'name.string'=> "အမည် စာသားဖြစ်ရမည်။",
    //         'price.numeric'=> "ဈေးနှုန်း နံပါတ်ဖြစ်ရမည်။"
    //     ]
    // );

        // -- Same way Update
        // $product = Product::where('id', $id)->update(['name' => $request->name, 'price' => $request->price]);
        // return response()->json($product);

        $product->update($request->only('name', 'price'));
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return $product;
    }
}
