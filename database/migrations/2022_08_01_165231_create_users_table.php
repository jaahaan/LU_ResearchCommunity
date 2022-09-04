<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('department');
            $table->integer('department_id')->nullable();
            $table->string('designation');
            $table->string('image')->default('/profileImages/download.jpg');
            $table->text('about')->nullable();
            $table->json('education')->nullable();
            $table->text('skills')->nullable();
            $table->text('interests')->nullable();
            $table->text('honors_and_awards')->nullable();
            $table->boolean('isEmailVerified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('isVerifiedByAdmin')->default(0);
            $table->timestamp('verified_by_admin_at')->nullable();
            $table->string('userType')->default('user');
            $table->string('isVerifiedCode')->nullable();
            $table->string('isVerifiedByAdminCode')->nullable();
            $table->string('otp')->nullable();
            $table->string('twoFactorCode')->nullable();
            $table->dateTime('expires_at')->nullable();
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
