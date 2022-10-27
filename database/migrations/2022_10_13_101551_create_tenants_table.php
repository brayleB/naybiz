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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landlord_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('address')->nullable();
            $table->string('valid_id')->nullable();
            $table->string('status');
            $table->string('occupants')->nullable();
            $table->string('vehicles')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
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
        Schema::dropIfExists('tenants');
    }
};
