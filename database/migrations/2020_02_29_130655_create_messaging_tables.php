<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_storage', function (Blueprint $table) {
            $table->id();
            $table->string('event_id', 36)->collation('utf8mb4_bin'); // case sensitive search
            $table->string('event_name', 255)->index('event_name')->collation('utf8mb4_bin');
            $table->unsignedInteger('version')->default(1);
            $table->json('payload');
            $table->json('metadata');
            $table->foreignUuid('user_id')->nullable()->index()->references('id')->on('user');
            $table->timestamps();

            $table->unique(['event_id', 'version'], 'event');
            $table->index('created_at');
        });

        Schema::create('snapshot_storage', function (Blueprint $table) {
            $table->id();
            $table->string('aggregate_id', 36)->collation('utf8mb4_bin'); // case sensitive search
            $table->string('aggregate_type', 255)->collation('utf8mb4_bin');
            $table->mediumText('aggregate');
            $table->integer('last_version')->index()->default(1);

            $table->unique(['aggregate_id', 'aggregate_type'], 'aggregate');
        });

        Schema::create('state_storage', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('aggregate_id', 36)->collation('utf8mb4_bin'); // case sensitive search
            $table->string('saga_type', 255)->collation('utf8mb4_bin');
            $table->json('payload');
            $table->boolean('is_done')->index()->nullable()->default(0);
            $table->dateTime('recorded_on')->index();

            $table->unique(['aggregate_id', 'saga_type'], 'aggregate_saga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_storage');
        Schema::dropIfExists('snapshot_storage');
        Schema::dropIfExists('state_storage');
    }
}
