<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parent_id')->nullable()->index();
            $table->boolean('is_active')->default(0)->index();
            $table->unsignedSmallInteger('position')->nullable()->default(0)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->softDeletes()->index();
        });

        Schema::create('blog_category_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('blog_category_id')->references('id')->on('blog_category');
            $table->char('locale', 2);
            $table->string('name')->index();

            $table->unique(['blog_category_id', 'locale'], 'blog_category_translation');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('blog_entry', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_active')->default(0)->index();
            $table->timestamp('publish_at')->nullable()->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->softDeletes()->index();
        });

        Schema::create('blog_entry_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('blog_entry_id')->references('id')->on('blog_entry');
            $table->char('locale', 2);
            $table->string('name')->index();
            $table->text('description')->nullable();

            $table->unique(['blog_entry_id', 'locale'], 'blog_entry_translation');
            $table->foreign('locale')->references('code')->on('language');
        });

        Schema::create('blog_entry_with_category', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('blog_entry_id')->references('id')->on('blog_entry');
            $table->foreignUuid('blog_category_id')->index()->references('id')->on('blog_category');

            $table->unique(['blog_entry_id', 'blog_category_id'], 'blog_entry_with_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_entry_with_category');
        Schema::dropIfExists('blog_entry_translation');
        Schema::dropIfExists('blog_entry');
        Schema::dropIfExists('blog_category_translation');
        Schema::dropIfExists('blog_category');
    }
}
