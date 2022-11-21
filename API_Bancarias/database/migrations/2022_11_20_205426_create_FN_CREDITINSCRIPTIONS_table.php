<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFNCREDITINSCRIPTIONSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FN_CREDITINSCRIPTIONS', function (Blueprint $table) {
            $table->id();
            $table->string('channelCode');
            $table->string('financialCode');
            $table->string('orderId');
            $table->string('purchaseDescription');
            $table->decimal('totalAmount', 20);
            $table->decimal('shippingAmount', 20);
            $table->decimal('totalTaxesAmount', 20);
            $table->string('currency');
            $table->integer('clientDocType');
            $table->bigInteger('clientDocNumber');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('mobileNumber');
            $table->string('mobileNumberCountryCode');
            $table->string('redirectionUrl');
            $table->string('inscriptionId');
            $table->string('cuotas')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('FN_CREDITINSCRIPTIONS');
    }
}
