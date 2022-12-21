<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_account', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->tinyInteger('is_admin')->index();
            $table->tinyInteger('all_radio_station')->index()->default(0);
            $table->json('radio_station')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('account')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');

            $table->primary(['user_id', 'account_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_account');
    }
};
