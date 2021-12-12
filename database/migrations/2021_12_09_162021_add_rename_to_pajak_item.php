<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRenameToPajakItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pajak_item', function (Blueprint $table) {
            $table->renameColumn('id_item', 'item_id');
            $table->renameColumn('id_pajak', 'pajak_id');
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
            $table->renameColumn('item_id', 'id_item');
            $table->renameColumn('pajak_id', 'id_pajak');
        });
    }
}
