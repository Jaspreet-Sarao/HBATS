<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        Schema::create('visit_passcodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('code')->unique();
            $table->timestamp('expires_at');
            $table->enum('status', ['active', 'invalid'])->default('active');
            $table->string('reason')->nullable();
            $table->timestamps();
            
            $table->index(['patient_id', 'status']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_passcodes');
    }
};
