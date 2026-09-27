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
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('badge')->default('01 / LAYANAN');
        $table->string('title');
        $table->text('description');
        $table->string('image_url');
        $table->string('badge_color')->default('blue');
        $table->integer('order_position')->default(1);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
