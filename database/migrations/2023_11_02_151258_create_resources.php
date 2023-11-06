<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Resource;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->enum('type', [Resource::TYPE_ROUTE, Resource::TYPE_CONTROL]);
            $table->string('description');
            $table->string('name');
            $table->string('route')->nullable();
            $table->string('controller')->nullable();
            $table->bigInteger('parent_id')->index()->default(0);
            $table->integer('order');
            $table->timestamps();
            $table->unique(['route']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('resources');
    }
};
