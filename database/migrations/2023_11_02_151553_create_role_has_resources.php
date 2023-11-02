<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('role_has_resources', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('resource_id')->unsigned();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_resources');
    }
};
