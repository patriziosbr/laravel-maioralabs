<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Helpers;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencyArr = array(
        "EEK" => "kr",
        "ETB" => "Nkf",
        "EUR" => "€",
        "FKP" => "£",
        "FJD" => "FJ$",
        "GMD" => "D");

        $products = [
            [
                'name' => 'art-1',
                'price' => '2.99 €'
            ],
            [
                'name' => 'art-2',
                'price' => '50000.99 €'
            ],
            [
                'name' => 'art-3',
                'price' => '20.00 €'
            ],
            [
                'name' => 'art-3',
                'price' => '20.00 €'
            ]
        ];

        $hash = array();
        $array_out = array();
        
        foreach($products as $item) {
            $hash_key = $item['name'].'|'.$item['price'];
            if(!array_key_exists($hash_key, $hash)) {
                $hash[$hash_key] = sizeof($array_out);
                array_push($array_out, array(
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'count' => 0,
                ));
            }
            $array_out[$hash[$hash_key]]['count'] += 1;
        }

        foreach($array_out as $elem) {

        $price = preg_replace('/[^0-9]/', '', $elem['price']);
        $currency = preg_replace('/[0-9]+/', '', $elem['price']);
        $currency_removeDot = str_replace('.', '', $currency);
        $currency_clean = trim($currency_removeDot);

        $currencyString = array_search($currency_clean, $currencyArr);

        $elemName = $elem['name'];
        $elemQta = $elem['count'];
          
        $newPoduct = new Product();
        $newPoduct->name = $elemName;
        $newPoduct->category_id = rand(1, 4);
        $newPoduct->price = number_format(($price/100), 2, '.', '');
        $newPoduct->currency = $currencyString;
        $newPoduct->quantity = $elemQta;
        $newPoduct->save();

        }
        
    }
}
