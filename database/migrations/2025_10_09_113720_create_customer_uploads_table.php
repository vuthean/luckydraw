<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('ACTIVE')->comment('Status when User try to upload customer: ACTIVE and INACTIVE');
            $table->string('file_name')->nullable()->comment('File Name');
            $table->string('created_by')->nullable()->comment('Created By');
            $table->string('updated_by')->nullable()->comment('Updated By');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_uploads');
    }
};
