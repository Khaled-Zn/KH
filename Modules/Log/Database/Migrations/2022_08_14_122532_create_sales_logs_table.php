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
        Schema::create('sales_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('counter')->default(0);
            $table->unsignedBigInteger('daily_log_id');
            $table->foreign('daily_log_id')
            ->references('id')
            ->on('daily_logs')
            ->onDelete('cascade');
            $table->unsignedBigInteger('menu_item_id');
            $table->foreign('menu_item_id')
            ->references('id')
            ->on('menu_items')
            ->onDelete('cascade');
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
        Schema::dropIfExists('sales_logs');
    }
};
