<?php

namespace App\Imports;

use App\Models\Csv;
use Maatwebsite\Excel\Concerns\ToModel;

class CsvImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Csv([
            'categoria' => $row[0],
            'nome_prodotto' => $row[1],
            'prezzo' => $row[2],
        ]);
    }
}
