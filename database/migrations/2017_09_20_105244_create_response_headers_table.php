<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_headers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('response_id');
            $table->foreign('response_id')
                ->references('id')->on('responses');

            $table->string('name');
            $table->mediumText('value');

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
        Schema::dropIfExists('response_headers');
    }
}
