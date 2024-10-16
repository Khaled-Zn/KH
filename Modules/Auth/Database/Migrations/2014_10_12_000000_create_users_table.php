<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Speciality;
use Modules\CompleteInfo\Models\UserTalent;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('email_verification_token');
            $table->string('full_name')->nullable();
            $table->string('username')->nullable();
            $table->timestamp('age')->nullable();
            $table->foreignIdFor(Residence::class)->nullable();
            $table->unsignedBigInteger('study_id')->nullable();
            $table->string('study_type')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
