<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('message_sources', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('user_id')->nullable()->constrained('users');  // Relación con usuarios (opcional)
            $table->boolean('is_default')->default(false);  // Columna añadida para marcar el canal predeterminado
            $table->text('settings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_sources');
    }
};
