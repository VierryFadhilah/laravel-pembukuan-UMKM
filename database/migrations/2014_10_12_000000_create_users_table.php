<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->timestamps();
        });
        Schema::create('access', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->timestamps();
        });
        Schema::create('roles_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("roles_id");
            $table->unsignedBigInteger('access_id');
            $table->foreign("roles_id")->references('id')->on('roles');
            $table->foreign('access_id')->references('id')->on('access');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('roles_id')->nullable(true);
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
