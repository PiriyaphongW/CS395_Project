<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class ProductController extends Controller
{
     public function productCreate(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
            'category' => 'required|string',
            'image' => 'required|string',
            'amount' => 'required',
            'price' => 'required|string|',
        ]);
        $product = Product::create($validate);

        $response = [
            'product' => $product,
            'message' => 'Create Product Success'
        ];
        return $response;
    }

    public function productRead(){
        return Product::all();
    }

    public function productReadID($id){
        return Product::find($id);
    }

    public function productUpdate(Request $request ,$id){
        $product = Product::find($id);
        $product->update($request->all());

        $response = [
            'product' => $product,
            'message' => 'Update Product Success'
        ];
        return $response;

    }

    public function productDelete($id){
        Product::destroy($id);

        $response = [
            'message' => 'Delete Product Success'
        ];
        return $response;

    }

    public function productReadGuest(){
        return product::limit(9)->get();
    }



    
}
