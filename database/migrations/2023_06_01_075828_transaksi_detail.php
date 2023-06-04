<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("transaksi_detail", function( Blueprint $table ) {

            $table->id();
            
            $table->bigInteger("transaksi_id");
            $table->bigInteger("menu_id");
            $table->integer("amount");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
