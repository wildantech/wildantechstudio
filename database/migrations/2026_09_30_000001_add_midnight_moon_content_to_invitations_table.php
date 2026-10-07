<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->string('bride_instagram', 2048)->nullable();
            $table->string('groom_instagram', 2048)->nullable();
            $table->json('love_story')->nullable();
            $table->string('livestream_url', 2048)->nullable();
            $table->text('gift_delivery_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->dropColumn([
                'bride_instagram',
                'groom_instagram',
                'love_story',
                'livestream_url',
                'gift_delivery_address',
            ]);
        });
    }
};
