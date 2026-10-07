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
        Schema::table('invitations', function (Blueprint $table): void {
            $table->string('bride_nickname', 80)->nullable()->after('bride_name');
            $table->string('groom_nickname', 80)->nullable()->after('groom_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->dropColumn(['bride_nickname', 'groom_nickname']);
        });
    }
};
