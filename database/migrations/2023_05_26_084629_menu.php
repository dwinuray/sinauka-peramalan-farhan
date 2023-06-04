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
        //
        Schema::create('menu', function(Blueprint $table) {

            $table->id();
            $table->bigInteger('kriteria_id');
            $table->string('nm_menu');
            $table->integer('price');
            $table->string('description');
            $table->string('photo', 75);
            
            $table->timestamps();
            $table->softDeletes();

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
