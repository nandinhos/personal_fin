<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['credit', 'debit']);
            $table->string('last_four_digits', 4);
            $table->decimal('limit', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->unsignedTinyInteger('closing_day')->nullable();
            $table->unsignedTinyInteger('due_day')->nullable();
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
