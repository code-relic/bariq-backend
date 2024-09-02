<?php

use illuminate\database\migrations\migration;
use illuminate\database\schema\blueprint;
use illuminate\support\facades\schema;

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
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
