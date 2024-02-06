<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->text('description');
        $table->enum('status', ['To Do', 'In Progress', 'Completed']);
        $table->unsignedBigInteger('user_id')->nullable(); // Added user_id field
        $table->timestamp('started_at')->nullable(); // Added started_at field
        $table->timestamps();

        // Define foreign key constraint
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
