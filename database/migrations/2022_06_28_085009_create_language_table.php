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
        Schema::create('language', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name',30)->nullable();
            $table->tinyInteger("status")->default(1);
            $table->string('code',20)->nullable();
            $table->string('icon',191)->nullable();
            $table->tinyInteger('default')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


            $table->index('name');
            $table->index('code');
            $table->index('status');
            $table->index('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('language');
    }
};
