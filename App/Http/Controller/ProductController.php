<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Panggil validator untuk memvalidasi inputan
use App\Models\Product; //Panggil model Product.php

class ProductController extends Controller
{
    //Menambah data ke database
    public function store(Request $request) {
        //Menvalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack, drink, food, groceries',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date',
        ]);

        //Kondisi apabila inputan yang diinginkan tidak sesuai
        if($validator->fails()) {
            //Response JSON akan dikirim jka ada inputan yang salah
            return response()->json($validator -> messages()) -> setStatusCode(422);  
        }
        $payload = $validator -> validated();
        //Memasukkan inputan yang benar ke database (table database)
        Product ::create([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at'],
        ]);
        //Response JSON akan dikirim jika benar
        return response() ->json([
            'msg' => 'Data product berhasil disimpan'
        ], 201);
    }
    function showAll(){
        //Panggil semua data produk dari tabel products
        $products = Product::all();

        //kirim respon json
        return response() -> json([
            'msg' => 'Data produk keseluruhan',
            'data' => $products
        ], 200);
    } 
    function showById($id){
        //Mencari data berdasarkan ID produk
        $product = Product::where('id', $id) -> first();

        //Kondisi apa bila data dengan ID ada
        if($product){
            //Response ketika ID ada
            return response() -> json([
                'msg' => 'Data produk dengan ID : '.$id , 
                'data' => $product
            ], 200);
        }
        //Response ketika data tidak ada
        return response() -> json([
            'msg' => 'Data produk dengan ID : '.$id.' tidak ditemukan'], 404);
    }
    function showByName(){
        //Mencari data berdasarkan nama produk yang mirip
        $product = Product::where('product_name', 'LIKE', '%'.$product_name.'%') -> get();

        //Kondisi apa bila data dengan ID ada
        if($product -> count() > 0){
            //Response ketika ID ada
            return response() -> json([
                'msg' => 'Data produk dengan nama yang mirip : '.$product_name , 
                'data' => $product
            ], 200);
        }
        //Response ketika data tidak ada
        return response() -> json([
            'msg' => 'Data produk dengan nama yang mirip : '.$product_name.' tidak ditemukan'], 404);
    }
}
