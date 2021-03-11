<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type', 64)->index();
        });

        Schema::create('state_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('state_id')->references('id')->on('state');
            $table->char('locale', 2);
            $table->string('name');

            $table->unique(['state_id', 'locale'], 'state_translation');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('login')->index();
            $table->foreignUuid('state_id')->references('id')->on('user_state');
            $table->char('locale', 2);
            $table->string('email')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable()->index();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->softDeletes()->index();

            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('password_reset', function (Blueprint $table) {
            $table->char('token', 4)->primary();
            $table->string('login')->index();
            $table->timestamp('created_at')->nullable();

            $table->foreign('login')->references('login')->on('user');
        });

        Schema::create('role', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->unique();
            $table->boolean('is_active')->default(1);
            $table->unsignedTinyInteger('level')->default(99);
        });

        Schema::create('role_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('role_id')->references('id')->on('role');
            $table->char('locale', 2);
            $table->string('description');

            $table->unique(['role_id', 'locale'], 'role_translation');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('permission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->unique();
            $table->boolean('is_active')->default(1);
        });

        Schema::create('permission_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('permission_id')->references('id')->on('permission');
            $table->char('locale', 2);
            $table->string('description');

            $table->unique(['permission_id', 'locale'], 'permission_translation');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('role_id')->references('id')->on('role');
            $table->foreignUuid('permission_id')->references('id')->on('permission');

            $table->unique(['role_id', 'permission_id'], 'role_permission');
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('id')->on('user');
            $table->foreignUuid('role_id')->references('id')->on('role');

            $table->unique(['user_id', 'role_id'], 'user_role');
        });

        Schema::create('user_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('id')->on('user');
            $table->foreignUuid('permission_id')->references('id')->on('permission');

            $table->unique(['user_id', 'permission_id'], 'user_permission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permission_translation');
        Schema::dropIfExists('permission');
        Schema::dropIfExists('role_translation');
        Schema::dropIfExists('role');
        Schema::dropIfExists('password_reset');
        Schema::dropIfExists('user');
        Schema::dropIfExists('state_translation');
        Schema::dropIfExists('state');
    }
}
