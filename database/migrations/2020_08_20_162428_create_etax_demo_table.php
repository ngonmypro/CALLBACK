<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtaxDemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etax_demo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('corporate_id')->unsigned();
            $table->string('reference_code', 50);
            $table->string('document_code', 50);
            $table->string('document_type', 50);

            $table->string('branch_code',5);
            $table->string('invoice_number',50);
            $table->string('batch_name', 100);

            $table->string('name');
            $table->string('email');

            $table->string('status', 50)->nullable();
            
            $table->longtext('pdf_file')->nullable();
            $table->longtext('xml_file')->nullable();

            $table->decimal('total_amount', 22, 2);

            $table->dateTime('due_date')->nullable();
            $table->dateTime('export_date')->nullable();

            $table->dateTime('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by')->nullable();

            $table->foreign('corporate_id')->references('id')->on('corporate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etax_demo');
    }
}
