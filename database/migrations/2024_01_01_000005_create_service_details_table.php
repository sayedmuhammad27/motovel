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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->string('detail_id')->unique(); // DTL-0001
            $table->foreignId('service_registration_id')->unique()->constrained('service_registrations')->onDelete('cascade');
            $table->foreignId('mechanic_id')->nullable()->constrained('mechanics')->onDelete('set null');
            $table->text('estimation')->nullable();
            $table->decimal('service_cost', 12, 2)->default(0);
            $table->string('status')->default('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
