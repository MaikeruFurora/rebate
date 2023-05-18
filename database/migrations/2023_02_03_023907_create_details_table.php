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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->foreign('header_id')->references('id')->on('headers')->onDelete('cascade')->onUpdate('cascade');
            $table->text('dscription');
            $table->text('itemcode')->nullable();
            $table->string('quantity')->nullable();
            $table->string('priceafvat')->nullable();
            $table->string('linetotal')->nullable();
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
        Schema::dropIfExists('details');
    }
};
