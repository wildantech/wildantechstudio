<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->string('bride_photo')->nullable();
            $table->string('groom_photo')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('music_file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->dropColumn(['bride_photo', 'groom_photo', 'gallery_images', 'music_file']);
        });
    }
};
