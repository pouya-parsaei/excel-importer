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
            $table->string('name',255)->nullable();
            $table->string('product_url',255)->nullable();
            $table->string('seo_title',255)->nullable();
            $table->string('seo_description',255)->nullable();
            $table->text('meta_keywords',255)->nullable();
            $table->string('h1_1',255)->nullable();
            $table->text('description')->nullable();
            $table->string('category',255)->nullable();
            $table->string('brand',255)->nullable();
            $table->string('initial_price')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('discount')->nullable();
            $table->unsignedInteger('single_price')->nullable();
            $table->unsignedInteger('single_price_2')->nullable();
            $table->string('image_url',255)->nullable();
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
