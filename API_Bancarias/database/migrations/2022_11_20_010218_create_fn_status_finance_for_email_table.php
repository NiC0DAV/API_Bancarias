<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnStatusFinanceForEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FN_STATUS_FINANCE_FOR_EMAIL', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->boolean('response_status');
            $table->decimal('guaranteeRate');
            $table->string('causalRejection');
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
        Schema::dropIfExists('FN_STATUS_FINANCE_FOR_EMAIL');
    }
}
