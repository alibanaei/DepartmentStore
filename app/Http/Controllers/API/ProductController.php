<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\APICreateProductRequest;
use App\Http\Requests\Responses\APIResponse;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private const Minimum_Product_Cost = 1000;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return APIResponse::makeSuccess(null, $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(APICreateProductRequest $request)
    {
        $data = $request->all();
        if($data['cost'] < self::Minimum_Product_Cost) {
            return APIResponse::makeFail(message: 'Minimum Cost Violation', errorCode: 400);
        }

        Product::create($data);

        return APIResponse::makeSuccess('Data added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::findOr($id, fn() => new Product());

        if(! isset($product->id)) {
            return $this->notFoundResponse();
        }

        return APIResponse::makeSuccess(null, $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $product = Product::findOr($id, fn() => new Product());

        if(! isset($product->id)) {
            return $this->notFoundResponse();
        }

        $product->update($request->all());

        return APIResponse::makeSuccess(null, $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Product::findOr($id, fn() => new Product());

        if(! isset($product->id)) {
            return $this->notFoundResponse();
        }

        $product->delete();

        return APIResponse::makeSuccess('Product removed successfully');
    }

    private function notFoundResponse()
    {
        return APIResponse::makeFail(message: 'Product Not Found', errorCode: 404);
    }
}
