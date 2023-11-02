<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->boolean('is_menu')->index();
            $table->string('route_name')->nullable();
            $table->string('controller_method');
            $table->boolean('can_be_default')->default(0);
            $table->bigInteger('parent_id')->index()->default(0);
            $table->integer('order');
            $table->timestamps();
            $table->unique(['name','route_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('resources');
    }
};
