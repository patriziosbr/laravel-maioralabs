<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
        
        foreach($prod as $item) {
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
        
        //   echo 'name: '.$elem['name'].' price: '. number_format(($price/100), 2, '.', '') . ' currency: '. $currency  .' qta '.$elem['count']; DEBUG FACCIO IL SAVE ->

        $newPoduct = new Product();
        $newPoduct->name = $elem['name'];
        $newPoduct->price = number_format(($price/100), 2, '.', '');
        $newPoduct->currency = $currency;
        $newPoduct->currency = $elem['count'];
        $newPoduct->save();

        }
        
    }
}
