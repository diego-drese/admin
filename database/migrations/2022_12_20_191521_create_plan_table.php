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
        Schema::create('plan', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('account_id')->nullable();
            $table->string("name");
            $table->decimal("value", 10,2);
            $table->decimal("size_gb", 10,2)->default(1);
            $table->enum("days", [30, 90, 180, 360])->default(30);
            $table->tinyInteger("status")->default(1);
            $table->text("description");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('plan');
    }
};
