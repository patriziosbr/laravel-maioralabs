<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csv extends Model
{
    protected $fillable = [
        'categoria',
        'nome_prodotto',
        'prezzo'
    ];
}
