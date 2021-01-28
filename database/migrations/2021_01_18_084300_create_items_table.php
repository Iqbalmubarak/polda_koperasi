<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('picture')->nullable();
            $table->text('note')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('modal')->nullable();
            $table->integer('price')->nullable();
            $table->integer('type_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('type_id')->references('id')->on('type')->onUpdate('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
