<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class CsvController extends Controller
{
    public function upLoad(Request $request)
    {
        $data = $request->all();
         //validaizione maunale
         $validator = Validator::make($data, [
            'guest_name' => 'required|max:30'
        ],
        [
            'guest_name.required' => 'inserisci nome'
        ]);
    }

    public function index()
    {
        $product = Product::all();

        return response()->json($product);
    }

}


