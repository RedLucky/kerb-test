<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCustomerBaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_customer_bays', function (Blueprint $table) {
            $table->id();
            $table->string('book_number',25)->unique();
            $table->integer('bay_id');
            $table->integer('customer_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->double('duration_in_hours')->default(0);
            $table->string('status',10)->default('unpaid');
            $table->softDeletes();
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
        Schema::dropIfExists('book_customer_bays');
    }
}
