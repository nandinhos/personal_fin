<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('type_temp')->nullable()->after('type');
            $table->foreignId('to_account_id')->nullable()->constrained('accounts')->onDelete('set null')->after('account_id');
            $table->string('transfer_type')->nullable()->after('type_temp');
        });

        DB::statement('UPDATE transactions SET type_temp = type::text');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type', ['income', 'expense', 'transfer'])->nullable()->after('profile_id');
        });

        DB::statement('UPDATE transactions SET type = type_temp WHERE type_temp IS NOT NULL');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('type_temp');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('type_temp')->nullable();
        });

        DB::statement("UPDATE transactions SET type_temp = type::text WHERE type IN ('income', 'expense')");

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type', ['income', 'expense'])->nullable();
        });

        DB::statement('UPDATE transactions SET type = type_temp WHERE type_temp IS NOT NULL');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['type_temp', 'to_account_id', 'transfer_type']);
        });
    }
};
