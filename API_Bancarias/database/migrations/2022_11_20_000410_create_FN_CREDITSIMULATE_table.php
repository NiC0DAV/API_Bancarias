<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFNCREDITSIMULATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FN_CREDITSIMULATE', function (Blueprint $table) {
            $table->id('FN_NUMERO');
            $table->string('financialCode');
            $table->decimal('totalAmount');
            $table->decimal('shippingAmount');
            $table->string('currency');
            $table->integer('documentType');
            $table->string('documentNumber');
            $table->decimal('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('mobileNumber');
            $table->string('mobileNumberCountryCode');
            $table->string('validToFinance');
            $table->string('causalRejection')->nullable();
            $table->string('maximunPaymentTerm');
            $table->string('guaranteeRate')->nullable();
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
        Schema::dropIfExists('fN_CREDITSIMULATE');
    }
}
