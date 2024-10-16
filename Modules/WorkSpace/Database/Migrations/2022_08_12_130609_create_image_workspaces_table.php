<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_workspaces', function (Blueprint $table) {
            $table->unsignedBigInteger('work_space_id');
            $table->unsignedBigInteger('image_id');

            $table->foreign('image_id')
            ->references('id')
            ->on('images')
            ->onDelete('cascade');

            $table->primary(['work_space_id','image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_workspaces');
    }
};
