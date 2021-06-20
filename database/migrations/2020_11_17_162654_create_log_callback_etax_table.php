<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogCallbackEtaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_callback_etax', function (Blueprint $table) {
            $table->increments('id');
            $table->string('success', 10)->nullable();
            $table->string('response_code', 50)->nullable();
            $table->string('invoice_number',50)->nullable();
            $table->string('status_file', 50)->nullable();
            $table->string('document',500)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_callback_etax');
    }
}
