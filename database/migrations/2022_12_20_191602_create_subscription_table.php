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
    public function up(){
        Schema::create('subscription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id');
            $table->bigInteger('plan_id');
            $table->string('fistel')->index();
            $table->string('subscription_id')->index();//Identify subscription from payment business
            $table->tinyInteger('status')->default(1)->index();// 1=Active 2=Inactive 0=Canceled
            $table->timestamp('start_date')->useCurrent()->index();
            $table->timestamp('next_payment_date')->index();
            $table->timestamp('end_date')->index();

            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('subscription');
    }
};
