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
        Schema::create('account', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('company',191)->nullable();
            $table->string('website',191)->nullable();
            $table->string('email',191)->nullable();
            $table->tinyInteger('email_notify')->default('1'); // 0=No
            $table->string('address1',191)->nullable();
            $table->string('address2',191)->nullable();
            $table->string('state',191)->nullable();
            $table->string('city',191)->nullable();
            $table->string('postcode',191)->nullable();
            $table->integer('country_id');
            $table->string('phone',30)->nullable();
            $table->string('image',191)->nullable();
            $table->tinyInteger('api_access')->default(0); // 0=No
            $table->string('api_key',191)->nullable();
            $table->tinyInteger('status')->default(1); //0-Inactive

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->index('country_id');
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('account');
    }
};