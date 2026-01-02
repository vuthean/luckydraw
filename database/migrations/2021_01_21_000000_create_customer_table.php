<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('cif_number');
            $table->string('account_number');
            $table->string('name');
            $table->string('phone_number');
            $table->string('account_category');
            $table->double('eod_balance', 8, 2)->nullable();
            $table->dateTime('to_kyc_at')->nullable();
            $table->dateTime('imported_at');

            $table->blamable();
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
        Schema::dropIfExists('customers');
    }
}
