<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBSTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_b_s_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code');
            $table->string('transaction_description');
            $table->dateTime('transaction_date');
            $table->string('customer_account_number');
            $table->timestamp('imported_at');
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
        Schema::dropIfExists('c_b_s_transactions');
    }
}
