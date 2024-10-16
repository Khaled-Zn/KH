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
        Schema::create('work_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique()->nullable();
            $table->text('description')->nullable();
            $table->integer('phone_number')->nullable();
            $table->string('address',100)->nullable();
            $table->string('working_days',100)->nullable();
            $table->foreignId('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_spaces');
    }
};
