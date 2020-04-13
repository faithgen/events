<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fg_guests', function (Blueprint $table) {
            $table->string('id')->index()->primary();
            $table->string('event_id', 150)->index();
            $table->string('title');
            $table->string('name');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('fg_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fg_guests');
    }
}
