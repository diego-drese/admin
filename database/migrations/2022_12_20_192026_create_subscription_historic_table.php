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
        Schema::create('subscription_historic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id');
            $table->bigInteger('plan_id');
            $table->bigInteger('subscription_id');
            $table->decimal('value', 10,2);
            $table->text('description');
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
        Schema::dropIfExists('subscription_historic');
    }
};
