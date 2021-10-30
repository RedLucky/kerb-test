<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCustomerBaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_customer_bays', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number',25)->unique();
            $table->integer('book_customer_bay_id');
            $table->integer('owner_payment_method_id');
            $table->double('charge');
            $table->double('tip');
            $table->double('tax');
            $table->double('total');
            $table->string('status')->default('settlement'); // failed, cancel, error, settlement
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
        Schema::dropIfExists('payment_customer_bays');
    }
}
