<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

use Log;

class CsvController extends Controller
{
    public function uploadcsv(Request $request)
    {
        $data = $request->all();
         //validaizione maunale
         $validator = Validator::make($data, [
            'file_upload' => 'required|mimes:xlsx'
        ],
        [
            'file_upload.required' => 'file mancante', 
            'file_upload.mimes' => 'Formato non accettato, carica un csv o xlsx',
        ]);
        //errore in validazione
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        if ($request->file('file_upload')) {
            $input = $request->input();
                $file = $request->file('csv_file');
                $fileName = $file->getClientOriginalName();
                $tempPath = $file->getRealPath();
                $location = 'app/storage';
                $file->move($location, $fileName);
                $filepath = public_path($location."/".$fileName);

                $file = fopen($filepath,"r");
                # open the file
                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open($file);
                # read each cell of each row of each sheet
                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $row) {
                        foreach ($row->getCells() as $cell) {
                            Log::info($cell->getValue());
                        }
                    }
                }
                $reader->close();
 
                fclose($file);
                dd('ciao'); //arrays of arrays wow
        }
    }

    public function index()
    {
        $product = Product::all();

        return response()->json($product);
    }

}


