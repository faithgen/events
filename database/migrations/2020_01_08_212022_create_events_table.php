<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fg_events', function (Blueprint $table) {
            $table->string('id')->index()->primary();
            $table->string('ministry_id', 150)->index();
            $table->string('name');
            $table->text('description');
            $table->json('location');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('published')->default(false);
            $table->string('url')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();

            $table->foreign('ministry_id')->references('id')->on('fg_ministries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fg_events');
    }
}
