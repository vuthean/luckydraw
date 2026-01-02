<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s_logs', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_cif');
            $table->string('customer_account');
            $table->string('customer_phone');
            $table->string('sms_from')->nullable();
            $table->string('sms_to')->nullable();
            $table->text('sms_text')->nullable();
            $table->string('sms_gateway')->nullable();
            $table->timestamp('send_date')->nullable();
            $table->timestamp('send_for_spin_date')->nullable();
            $table->string('response')->nullable();
            $table->string('description')->nullable();
            $table->string('send_via')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('s_m_s_logs');
    }
}
