<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_details', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('chamber_of_commerce')->nullable();
            $table->string('vat_number')->nullable();
            $table->datetime('effective_date');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
