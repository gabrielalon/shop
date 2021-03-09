<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language', function (Blueprint $table) {
            $table->char('code', 2)->primary();
            $table->string('native_name', 255);
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->char('code', 3)->primary();
        });

        Schema::create('currency_rate', function (Blueprint $table) {
            $table->id();
            $table->char('currency_base_code', 3);
            $table->char('currency_target_code', 3);
            $table->date('date_exchange');
            $table->date('date');
            $table->float('rate', 4, 4, true);

            $table->unique(['currency_base_code', 'currency_target_code', 'date_exchange', 'date'], 'currency_rate');
            $table->foreign('currency_base_code')->references('code')->on('currency');
            $table->foreign('currency_target_code')->references('code')->on('currency');
        });

        Schema::create('continent', function (Blueprint $table) {
            $table->char('code', 2)->primary();
        });

        Schema::create('continent_translation', function (Blueprint $table) {
            $table->id();
            $table->char('continent_code', 2);
            $table->char('locale', 2);
            $table->string('name');

            $table->unique(['continent_code', 'locale'], 'continent_translation');
            $table->foreign('continent_code')->references('code')->on('continent');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('country', function (Blueprint $table) {
            $table->char('code', 2)->primary();
            $table->char('continent_code', 2);
            $table->string('native_name', 255);

            $table->foreign('continent_code')->references('code')->on('continent');
        });

        Schema::create('country_language', function (Blueprint $table) {
            $table->id();
            $table->char('country_code', 2);
            $table->char('language_code', 2);

            $table->unique(['country_code', 'language_code'], 'country_language');
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('language_code')->references('code')->on('language');
        });

        Schema::create('country_currency', function (Blueprint $table) {
            $table->id();
            $table->char('country_code', 2);
            $table->char('currency_code', 3);

            $table->unique(['country_code', 'currency_code'], 'country_currency');
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('currency_code')->references('code')->on('currency');
        });

        Schema::create('country_phone', function (Blueprint $table) {
            $table->char('country_code', 2);
            $table->string('prefix', 4);

            $table->foreign('country_code')->references('code')->on('country');
        });

        Schema::create('country_translation', function (Blueprint $table) {
            $table->id();
            $table->char('country_code', 2);
            $table->char('locale', 2);
            $table->string('name');

            $table->unique(['country_code', 'locale'], 'country_translation');
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('site', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_active')->index()->default(1);
            $table->string('name', 64)->unique();
        });

        Schema::create('site_domain', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('site_id')->references('id')->on('site');
            $table->string('url');

            $table->unique(['site_id', 'url'], 'site_domain');
        });

        Schema::create('site_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('site_id')->references('id')->on('site');
            $table->char('country_code', 2);
            $table->char('currency_code', 3);
            $table->char('language_code', 2);
            $table->boolean('is_default')->index()->default(0);

            $table->unique(['site_id', 'country_code', 'currency_code', 'language_code'], 'site_metadata');
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('currency_code')->references('code')->on('currency');
            $table->foreign('language_code')->references('code')->on('language');
        });

        Schema::create('site_currency_rate', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('site_id')->references('id')->on('site');
            $table->char('currency_base_code', 3);
            $table->char('currency_target_code', 3);
            $table->float('rate', 4, 4, true);

            $table->unique(['site_id', 'currency_base_code', 'currency_target_code'], 'site_currency_rate');
            $table->foreign('currency_base_code')->references('code')->on('currency');
            $table->foreign('currency_target_code')->references('code')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_currency_rate');
        Schema::dropIfExists('site_metadata');
        Schema::dropIfExists('site_domain');
        Schema::dropIfExists('site');
        Schema::dropIfExists('country_phone');
        Schema::dropIfExists('country_language');
        Schema::dropIfExists('country_currency');
        Schema::dropIfExists('country_translation');
        Schema::dropIfExists('country');
        Schema::dropIfExists('continent_translation');
        Schema::dropIfExists('continent');
        Schema::dropIfExists('currency_rate');
        Schema::dropIfExists('currency');
        Schema::dropIfExists('language');
    }
}
