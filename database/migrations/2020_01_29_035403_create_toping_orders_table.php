<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toping_orders', function (Blueprint $table) {
          $table->bigInteger('product_order_id')->unsigned();
          $table->integer('toping_id')->unsigned();
          $table->integer('price');

          $table->foreign('product_order_id')->references('id')->on('product_orders');
          $table->foreign('toping_id')->references('id')->on('topings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toping_orders');
    }
}
