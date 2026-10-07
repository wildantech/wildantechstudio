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
        Schema::create('invitation_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('group_name')->nullable();
            $table->string('token', 48)->unique();
            $table->string('rsvp_status')->nullable();
            $table->unsignedTinyInteger('party_size')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('marked_sent_at')->nullable();
            $table->index(['invitation_id', 'rsvp_status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_guests');
    }
};
