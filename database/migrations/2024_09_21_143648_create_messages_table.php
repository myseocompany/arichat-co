<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('message_source_id')->constrained('message_sources')->onDelete('cascade');
            $table->foreignId('message_type_id')->constrained('message_types')->onDelete('restrict');
            $table->text('content');
            $table->text('media_url')->nullable();
            $table->boolean('is_outgoing')->default(true);
            $table->timestamp('sent_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            // Índices para consultas comunes
            $table->index('is_outgoing');
            $table->index('sent_at');
            $table->index('lead_id');
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
