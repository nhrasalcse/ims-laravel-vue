<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('product_qr_code')->nullable(); 
            $table->string('suplier')->nullable();
            $table->string('product_regular_price')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('quentity')->nullable();
            $table->string('stock_level')->nullable();
            $table->string('stock_in')->nullable();
            $table->string('stock_out')->nullable();
            $table->string('user_id')->nullable();
            $table->string('date')->nullable();
            $table->string('delete_status')->default(1);
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
        Schema::dropIfExists('stocks');
    }
}
