<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->uuid('uuid')->unique();
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('username',50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('language_id')->constrained()->nullable()->default(1);
            $table->string('password');
            $table->boolean('isactive');
            $table->integer('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('picture')->nullable();
            $table->text('roles_name');
            $table->text('address')->nullable();
            $table->text('codepostale')->nullable();
            $table->text('gender', 15)->nullable();
            $table->boolean('isSuperAdmin')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
};
