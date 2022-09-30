<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Imports\CsvImport;
use App\Models\Csv;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use Log;

class CsvController extends Controller
{
    public function uploadcsv(Request $request)
    {
        $data = $request->all();
        // Log::info($request->file('file'));
        // Log::info($data['file']);
         //validaizione maunale
         $validator = Validator::make($data, [
            'file' => 'required|mimes:xlsx'
        ],
        [
            'file.required' => 'file mancante', 
            'file.mimes' => 'Formato non accettato, carica un csv o xlsx',
        ]);
        //errore in validazione
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        DB::table('csvs')->truncate(); //svuoto la tabella dall'upload precedente 

        Excel::import(new CsvImport, $data['file']); //store del csv in tabella apposita

        $originalCsv = Csv::all();
        
        $allCAtegory = 

        foreach($originalCsv as $item) {
            Log::info($item);
        }

        //pulisco la collection dai doppioni e creo un array con categoria
        // $hash = array();
        // $array_out = array();
        
        // foreach($originalCsv as $item) {
        //     $hash_key = $item['name'].'|'.$item['price'];
        //     if(!array_key_exists($hash_key, $hash)) {
        //         $hash[$hash_key] = sizeof($array_out);
        //         array_push($array_out, array(
        //             'name' => $item['name'],
        //             'price' => $item['price'],
        //             'count' => 0,
        //         ));
        //     }
        //     $array_out[$hash[$hash_key]]['count'] += 1;
        // }

     

        
        return response()->json(['success' => true]);
        
        
    }

    public function index()
    {
        $product = Product::all();

        return response()->json($product);
    }

}


