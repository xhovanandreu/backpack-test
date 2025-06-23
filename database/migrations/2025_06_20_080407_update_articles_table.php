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

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('date');
            $table->dropColumn('price');

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('body')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('subtitle');
            $table->dropColumn('body');

            $table->date('date')->nullable();
            $table->decimal('price')->nullable();
            $table->string('name')->nullable();

        });
    }
};
