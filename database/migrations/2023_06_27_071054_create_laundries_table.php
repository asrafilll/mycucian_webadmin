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
        Schema::create('laundries', function (Blueprint $table) {
            $table->id();
            $table->string('claim_code');
            $table->bigInteger('user_id')->constrained();
            $table->bigInteger('shop_id')->constrained();
            $table->double('weight');
            $table->boolean('with_pickup');
            $table->boolean('with_delivery');
            $table->text('pickup_address');
            $table->text('delivery_address');
            $table->double('total');
            $table->text('description');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundries');
    }
};
