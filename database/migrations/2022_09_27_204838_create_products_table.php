<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('category_id')->nullable();
            // $table->foreign('category_id')
            //     ->references('id')
            //     ->on('categories')
            //     ->onDelete('SET NULL');
            $table->string('category_name', 50)->nullable()->default(NULL);
            $table->string('cod_article', 200)->nullable()->default(NULL);
            $table->string('name', 100);
            $table->decimal('price', 7,2);
            $table->float('percentage_discount', 5,2)->nullable()->default(NULL);
            $table->unsignedTinyInteger('quantity');
            $table->string('currency', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
