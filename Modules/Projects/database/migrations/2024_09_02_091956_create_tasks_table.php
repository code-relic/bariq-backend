<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->ulid('id')->primary(); // ULID primary key
            $table->string('title', 255)->nullable();
            $table->string('description', 1200)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('projects_id');
            $table->unsignedBigInteger('projects_teams_id');
            $table->json('assets')->nullable();
            $table->string('docs', 2000)->nullable();
            $table->unsignedBigInteger('lists_id');
            // relations
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('projects_teams_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['projects_id']);
            $table->dropForeign(['projects_teams_id']);
        });
        Schema::dropIfExists('tasks');
    }
};