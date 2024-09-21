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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('channel_id')->constrained('channels');
            $table->foreignId('message_type_id')->constrained('message_types');
            $table->text('content');
            $table->text('media_url')->nullable(); // Campo renombrado y marcado como opcional
            $table->boolean('is_outgoing')->default(true); // Añadir si es un mensaje de salida
            $table->timestamp('sent_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
