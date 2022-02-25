<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_systems', function (Blueprint $table) {
            $table->id();
            $table->text('subject', 255)->nullable();
            $table->text('query_request')->nullable();
            $table->string('query_type', 255)->default('general');
            $table->integer('transaction_number')->nullable();
            $table->string('url', 255)->nullable();
            $table->string('method', 255)->nullable();
            $table->string('ip', 255)->nullable();
            $table->string('agent', 255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('log_systems');
    }
}
