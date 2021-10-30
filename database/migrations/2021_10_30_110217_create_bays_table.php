<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bays', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->double('width');
            $table->double('length');
            $table->string('location_name');
            $table->string('name',100);
            $table->string('coordinate');
            $table->string('status',20)->default('available');
            $table->char('active',1)->default('Y');
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
        Schema::dropIfExists('bays');
    }
}
