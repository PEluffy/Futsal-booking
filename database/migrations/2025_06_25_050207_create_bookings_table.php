<?php

use App\Models\Court;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Court::class)->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('phone');
            $table->integer('price');
            $table->string('team_name');
            $table->enum('status', ['reserved', 'payed', 'canceled']); //status enums either  reserved or payed or cancel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
