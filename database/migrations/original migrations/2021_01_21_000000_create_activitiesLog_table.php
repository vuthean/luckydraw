<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateactivitiesLogTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('activitiesLog');
    Schema::create('activitiesLog', function (Blueprint $table) {
      $table->id('activitiesLog_id');
      $table->longText('activitiesLog_description');
      $table->longText('activitiesLog_doer');
      $table->longText('activitiesLog_prize');
      $table->longText('activitiesLog_customer_CIF');
      $table->longText('activitiesLog_customer_name');
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
    Schema::dropIfExists('activitiesLog');
  }
}
