<?php

use App\Models\Equipment;
use App\Models\Workshop;
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
        Schema::create('equipment_workshop', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workshop::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Equipment::class)->constrained()->onDelete('cascade');
            $table->bigInteger('quantity_taken')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_workshop');
    }
};
