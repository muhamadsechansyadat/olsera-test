<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToPajakItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pajak_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_item')->change();
            $table->unsignedBigInteger('id_pajak')->change();
            $table->foreign('id_item')->references('id')->on('item')->onDelete('cascade');
            $table->foreign('id_pajak')->references('id')->on('pajak')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pajak_item', function (Blueprint $table) {
            //
        });
    }
}
