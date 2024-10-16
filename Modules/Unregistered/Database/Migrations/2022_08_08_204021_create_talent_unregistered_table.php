<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\CompleteInfo\Models\Talent;
use Modules\Unregistered\Models\Unregistered;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talent_unregistered', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Unregistered::class)->nullable();
            $table->foreignIdFor(Talent::class)->nullable();
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
        Schema::dropIfExists('talent_unregistered');
    }
};
