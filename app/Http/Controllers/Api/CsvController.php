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
use Illuminate\Support\Str;
use Log;

class CsvController extends Controller
{
    protected function currency_list() {
        return array(
            "EEK" => "kr",
            "ETB" => "Nkf",
            "EUR" => "€",
            "FKP" => "£",
            "FJD" => "FJ$",
            "GMD" => "D"
        );
    }

    public function uploadcsv(Request $request)
    {
        $data = $request->all();

        // Log::info($data['file']);
         //validaizione maunale
         $validator = Validator::make($data, [
            'file' => 'required|mimes:xlsx'
        ],
        [
            'file.required' => 'file mancante',
            'file.mimes' => 'errore formato',
        ]);
        //errore in validazione
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        DB::table('csvs')->truncate(); //svuoto la tabella dall'upload precedente DEBUG

        Excel::import(new CsvImport, $data['file']); //store del csv in tabella apposita

        $originalCsv = Csv::all();
        // Log::info($originalCsv);
        $i=0;
        $allCAtegory = [];
        foreach($originalCsv as $key => $item) {
        //salto la prima riga se il checkbox è true
        if($data['checked']){
            if($key == 0)
                continue;
        }
        $productObj = json_decode($item); // Log::info($productObj->categoria); //le categorie
        array_push($allCAtegory, $productObj->categoria);
        }
        
        //salvo le categorie uniche a db
        $cleanCAtegories = array_unique($allCAtegory);
        foreach($cleanCAtegories as $category) {
            //se la acategoria esiste non la salvo
            if (!Category::where('name', $category )->exists()) {
                $newCategory = new Category();
                $newCategory->name = $category;
                $newCategory->save();
            }
        }

        $cleanCsv = json_decode( $originalCsv, TRUE ); //Log::info($cleanCsv); //array di arrays ok

        //conto i doppioni e creo un array di arrays con count e codice articolo
        $hash = array();
        $array_out = array();
        foreach($cleanCsv as $key => $item) {
            if($data['checked']){
                if($key == 0)
                    continue;
            }
            $hash_key = $item['categoria'].'|'.$item['nome_prodotto'].'|'.$item['prezzo'];
            if(!array_key_exists($hash_key, $hash)) {
                $hash[$hash_key] = sizeof($array_out);
                array_push($array_out, array(
                    'category' => $item['categoria'],
                    'cod_article' => '',
                    'name' => $item['nome_prodotto'],
                    'price' => $item['prezzo'],
                    'count' => 0,
                ));
            }
            $array_out[$hash[$hash_key]]['count'] += 1;
        }
        Log::info($array_out); //ok

        foreach($array_out as $elem) {

            $price = preg_replace('/[^0-9]/', '', $elem['price']); //da prezzo prendo solo valore numerico
            $currency = preg_replace('/[0-9]+/', '', $elem['price']); // da prezzo escludo i numeri (rimane '. €')
            $currency_removeDot = str_replace('.', '', $currency); // levo il punto extra 
            $currency_clean = trim($currency_removeDot); //levo lo spazio
            $currencyString = array_search($currency_clean, $this->currency_list()); // cerco la currency in $currency_list
    
            $elemName = $elem['name'];
            $elemQta = $elem['count'];
            $category = Category::where('name', $elem['category'])->first(); //cerco nella tab category
            $decimalPrice = number_format(($price/100), 2, '.', '');
            $existingProduct = Product::where('name', $elemName )->where('category_id', $category->id)->where('price', $decimalPrice);

            //genero codice articolo nome+categoria
            $fullCode = $elemName .' '. $category->name .' '. $decimalPrice ;
            $code_article = Str::slug($fullCode, '-'); 
            $existingCode = Product::where('cod_article', $code_article)->first();
            $codeBase = $code_article;
            $counter = 1;
            while($existingCode) {
                $code_article = $codeBase . "-" . $counter;
                $existingCode = Product::where('cod_article', $code_article)->first();
                $counter++;
            }

            //se il prodotto non esiste crealo
            if (!$existingProduct->exists()) {
                $newPoduct = new Product();
                $newPoduct->cod_article = $code_article;
                $newPoduct->name = $elemName;
                $newPoduct->category_id = $category->id;
                $newPoduct->category_name = $elem['category'];
                $newPoduct->price = $decimalPrice;
                $newPoduct->currency = $currencyString;
                $newPoduct->quantity = $elemQta;
                $newPoduct->save();
            }else{
                //se esite aggiungi alla quantita
                $existingProductRow = $existingProduct->first();
                $existingQuantity = $existingProductRow->quantity;
                $existingQuantityAdd = $existingQuantity + $elemQta;
                Product::where('id', $existingProductRow->id)->update(['quantity' => $existingQuantityAdd]);
            }
        }
        return response()->json(
            //  ['success' => true]
            $data
        );
    }

    public function productcateogries()
    {
        $product = Product::all();
        $category = Category::all();

        $data = [
            'product' => $product,
            'category' => $category
        ];

        return response()->json($data);
    }

    public function applaydiscount(Request $request)
    {
        $data = $request->all();

        foreach ($data as $values) {
            foreach ($values as $key => $value) {
               if(isset($value['discount'])) {
                    if(strpos($value['discount'], '.')){
                        $num = floatval($value['discount']);
                    } else {
                        $num = intval($value['discount']);
                    }
                    if($num > 100) {
                        return response()->json(
                            ['errors' => true]
                        );
                    }
                    Product::where('category_id', $value['id'])->update(['percentage_discount' => $num]);
               } else {
                    Product::where('category_id', $value['id'])->update(['percentage_discount' => NULL]);
               }
            }
        }

        return response()->json(
            ['success' => true]
            // $data
        );
    }

}


