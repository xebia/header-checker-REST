<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseHeaderFindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_header_findings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('response_header_id');
            $table->foreign('response_header_id')
                ->references('id')->on('response_headers');

            $table->unsignedInteger('header_rule_id');
            $table->foreign('header_rule_id')
                ->references('id')->on('header_rules');

            $table->unsignedTinyInteger('score');

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
        Schema::dropIfExists('response_header_findings');
    }
}