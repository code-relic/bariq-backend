<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('projects_id');
            $table->unsignedBigInteger('projects_teams_id');
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();

            // $table->integer('views_id');
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('projects_teams_id')->references('id')->on('teams')->onDelete('cascade');

            // $table->foreign('views_id')
            //     ->references('id')
            //     ->on('views')
            //     ->onDelete('NO ACTION')
            //     ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lists');
    }
};
