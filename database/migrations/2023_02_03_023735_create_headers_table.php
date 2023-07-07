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
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->date('docdate')->nullable();//docdate
            $table->string('clientname',150)->nullable(); //clientname 
            $table->string('cardname',100)->nullable(); //name
            $table->string('docnum',50)->nullable(); //u_si_no 
            $table->string('reference_1')->nullable(); //docnum 
            $table->string('reference_2')->nullable(); //u_dr_no 
            $table->string('itemcode',50)->nullable(); //itemcode 

            //for table
            // $table->text('dscription')->nullable(); //dscription 
            // $table->double('quantity',18,4)->nullable(); //quantity 
            // $table->double('priceafvat',18,4)->nullable(); //priceafvat 
            // $table->double('linetotal',18,4)->nullable(); //linetotal 
            
            $table->string('detail_1',50)->nullable(); //doctotal 
            $table->string('detail_2',50)->nullable(); //vatsum 
            $table->double('totalamount',18,4)->nullable(); //totalamount 
            $table->text('docstatus',5)->nullable(); //docstatus
            $table->text('comments')->nullable(); //comments
            $table->text('reason')->nullable();
            $table->decimal('rebateAmount',18,4); 
            $table->string('encodedby',50)->nullable();
            $table->string('approvedby')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->text('cancelremarks')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->text('rejectremarks')->nullable();
            $table->string('reference')->nullable();
            $table->string('seriescode',20)->nullable();
            $table->string('status',1);
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
        Schema::dropIfExists('headers');
    }
};


