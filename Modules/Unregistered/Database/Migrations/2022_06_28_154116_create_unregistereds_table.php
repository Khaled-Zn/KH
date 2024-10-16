<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\CompleteInfo\Models\Residence;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unregistereds', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('full_name');
            $table->string('username')->nullable();
            $table->timestamp('age')->nullable();
            $table->foreignIdFor(Residence::class)->nullable();
            $table->unsignedBigInteger('study_id')->nullable();
            $table->string('study_type')->nullable();
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
        Schema::dropIfExists('unregistereds');
    }
};
