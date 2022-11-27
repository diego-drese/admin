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
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->string("verb");
            $table->text("uri");
            $table->tinyInteger("status")->default(1);
            $table->smallInteger("order")->default(0);
            $table->integer("parent")->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permission');
    }
};