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
        Schema::create('role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->tinyInteger("status")->default(1);
            $table->tinyInteger("root_account")->nullable()->unique();
            $table->tinyInteger("user_account")->nullable();
            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('role_user');
        Schema::dropIfExists('role');
    }
};