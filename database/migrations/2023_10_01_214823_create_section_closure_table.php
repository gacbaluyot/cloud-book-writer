<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // create_section_closure_table.php
    public function up(): void
    {
        Schema::create('section_closure', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ancestor');
            $table->unsignedBigInteger('descendant');
            $table->unsignedTinyInteger('depth');

            $table->foreign('ancestor')->references('id')->on('sections');
            $table->foreign('descendant')->references('id')->on('sections');

            $table->unique(['ancestor', 'descendant']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_closure');
    }
};
