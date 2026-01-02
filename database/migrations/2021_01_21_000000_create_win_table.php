<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('win');

    Schema::create('win', function (Blueprint $table) {
      $table->id();
      $table->integer('win_prizeID');
      $table->integer('win_ticketID');
      $table->date('win_delAt');
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
    Schema::dropIfExists('win');
  }
}
