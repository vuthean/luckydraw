<?php

use App\Enums\WinType;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('customer_name');
            $table->string('customer_cif_number');
            $table->string('customer_account_number');
            $table->string('customer_phone');

            $table->string('number');
            $table->timestamp('win_at')->nullable();
            $table->enum('win_type', [WinType::MotorBikePrize, WinType::CashPrize, WinType::ParasolPrize, WinType::WaterBottlePrize])->nullable();
            $table->timestamp('generated_at');
            $table->timestamp('spind_monthly_prize_at')->nullable();
            $table->timestamp('spind_grand_prize_at')->nullable();

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
        Schema::dropIfExists('tickets');
    }
}
