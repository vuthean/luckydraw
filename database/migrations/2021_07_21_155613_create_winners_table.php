<?php

use App\Enums\WinType;
use App\Models\Customer;
use App\Models\LuckyPrize;
use App\Models\Ticket;
use App\Models\Win;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();

            /** customer  */
            $table->foreignIdFor(Customer::class);
            $table->string('customer_name');
            $table->string('customer_cif_number');
            $table->string('customer_account_number');
            $table->string('customer_phone');

            $table->foreignIdFor(Ticket::class);
            $table->foreignIdFor(LuckyPrize::class);
            $table->string('prize_name');
            $table->enum('win_type', [WinType::MotorBikePrize, WinType::CashPrize, WinType::ParasolPrize, WinType::WaterBottlePrize]);
            $table->timestamp('win_at');

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
        Schema::dropIfExists('winners');
    }
}
