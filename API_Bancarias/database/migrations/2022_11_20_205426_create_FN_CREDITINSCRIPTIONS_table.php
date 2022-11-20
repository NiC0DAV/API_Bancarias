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
            $table->decimal('totalAmount');
            $table->decimal('shippingAmount');
            $table->decimal('totalTaxesAmount');
            $table->string('currency');
            $table->integer('clientDocType');
            $table->integer('clientDocNumber');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('mobileNumber');
            $table->string('mobileNumberCountryCode');
            $table->string('redirectionUrl');
            $table->string('inscriptionId');
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
