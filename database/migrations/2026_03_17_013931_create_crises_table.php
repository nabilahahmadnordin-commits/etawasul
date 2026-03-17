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
        Schema::create('crises', function (Blueprint $table) {
            $table->id('Crisis_ID');
            $table->string('Crisis_Type')->nullable();
            $table->text('Crisis_Description')->nullable();
            $table->string('Crisis_Severity')->nullable();
            $table->string('Impact_level')->nullable();
            $table->string('Location')->nullable();
            $table->dateTime('Date_Reported')->nullable();
            $table->string('Status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crises');
    }



};
