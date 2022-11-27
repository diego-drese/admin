<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('country', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name',30)->nullable();
            $table->string('iso',20)->nullable();
            $table->string('time_zone',191)->nullable();
            $table->tinyInteger('minimum_size_phone')->nullable();
            $table->tinyInteger('maximum_size_phone')->nullable();
            $table->string('ddi',50)->nullable();
            $table->string('code',50)->nullable();
            $table->string('currency',50)->nullable();
            $table->string('currency_symbol',50)->nullable();
            $table->tinyInteger("status")->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


            $table->index('name');
            $table->index('iso');
            $table->index('code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('country');
    }
};
