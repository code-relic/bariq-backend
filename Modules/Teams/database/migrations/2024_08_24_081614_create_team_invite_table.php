<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_invite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('recipient_id');
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->timestamps();
            
            //? Forgin Keys
            $table->foreign("team_id")->references("id")->on("teams")->onDelete("cascade");
            $table->foreign("sender_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("recipient_id")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_invite');
    }
};
