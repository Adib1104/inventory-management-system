<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSupplierTable extends Migration
{
    public function up()
    {
        Schema::create('item_supplier', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('supp_id');
            $table->timestamps();

            $table->primary(['item_id', 'supp_id']);

            $table->foreign('item_id')
                  ->references('item_id')
                  ->on('items')
                  ->onDelete('cascade');

            $table->foreign('supp_id')
                  ->references('sup_id')
                  ->on('suppliers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_supplier');
    }
}
