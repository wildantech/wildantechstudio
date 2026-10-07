<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->string('bride_name')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->unsignedSmallInteger('bride_child_order')->nullable();
            $table->string('groom_name')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->unsignedSmallInteger('groom_child_order')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->dropIndex(['expires_at']);
            $table->dropColumn([
                'bride_name', 'bride_father', 'bride_mother', 'bride_child_order',
                'groom_name', 'groom_father', 'groom_mother', 'groom_child_order', 'expires_at',
            ]);
        });
    }
};
