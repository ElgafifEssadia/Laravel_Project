<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use  Validator ;



class ProductController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        return $this->sendResponse($products->toArray(), 'Products read succesfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $validator =    Validator::make($input, [
            'name'=> 'required',
            'category'=> 'required',
            'details'=> 'required',
            'quantity'=> 'required',
            'price'=> 'required'
        ] );

        if ($validator -> fails())
            return $this->sendError('error validation', $validator->errors());

        $products = Product::create($input);
        return $this->sendResponse($products->toArray(), 'Product  created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::find($id);
        if (is_null($products))
            return $this->sendError(  'Product not found ! ');

        return $this->sendResponse($products->toArray(), 'Product read succesfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $input = $request->all();
        $validator =    Validator::make($input, [
            'name'=> 'required',
            'category'=> 'required',
            'details'=> 'required',
            'quantity'=> 'required',
            'price'=> 'required'
        ] );

        if ($validator -> fails())
            return $this->sendError('error validation', $validator->errors());


        $product->name =  $input['name'];
        $product->details =  $input['details'];
        $product->save();

        return $this->sendResponse($product->toArray(), 'Product  updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return $this->sendResponse($product->toArray(), 'Product  deleted succesfully');
    }
}
