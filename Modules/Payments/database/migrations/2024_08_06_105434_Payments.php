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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('status', 45);
            $table->timestamps();
            $table->unsignedBigInteger('payer_id');
            $table->unsignedBigInteger('teams_id');

            //? Forginkeys
            $table->foreign('payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teams_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['plans_id']);
            $table->dropForeign(['payer_id']);
            $table->dropForeign(['teams_id']);
        });
        Schema::dropIfExists('payments');
    }
};
