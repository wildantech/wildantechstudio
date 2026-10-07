<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_gifts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 100);
            $table->string('account_name', 120);
            $table->string('account_number', 80);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('invitations')->whereNotNull('gift_bank_name')->whereNotNull('gift_account_number')
            ->orderBy('id')->each(function (object $invitation): void {
                DB::table('invitation_gifts')->insert([
                    'invitation_id' => $invitation->id,
                    'provider' => $invitation->gift_bank_name,
                    'account_name' => $invitation->gift_account_name ?: $invitation->host_names,
                    'account_number' => $invitation->gift_account_number,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_gifts');
    }
};
