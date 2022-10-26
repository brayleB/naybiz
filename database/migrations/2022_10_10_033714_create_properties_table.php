<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('hoa_id');
            $table->unsignedBigInteger('landlord_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('address');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->float('price');
            $table->string('status');
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
        Schema::dropIfExists('properties');
    }
};
