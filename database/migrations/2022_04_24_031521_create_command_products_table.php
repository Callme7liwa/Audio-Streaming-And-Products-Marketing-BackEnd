<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command_products', function (Blueprint $table) {
            $table->bigInteger('command_id')->unsigned()->index()->nullable();
            $table->foreign('command_id')->references('id')->on('commands');

            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('size_id')->unsigned()->index()->nullable();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->primary(array('command_id', 'product_id','size_id'));
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
        Schema::dropIfExists('command_products');
    }
};
