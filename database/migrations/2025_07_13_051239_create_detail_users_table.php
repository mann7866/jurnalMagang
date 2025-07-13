<?php

use App\Enums\GenderEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('no_telp');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('nuptk')->nullable();
            $table->string('nisn')->nullable();
            $table->enum('gender',array_column(GenderEnum::cases(), 'value'));
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
