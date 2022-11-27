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
        Schema::create('form_field', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('alias')->index();
            $table->enum('type',[
                'lookup',
                'text',
                'email',
                'tel',
                'number',
                'region',
                'country',
                'locale',
                'timezone',
                'datetime',
                'url',
            ])->index();
            $table->enum('field_group',[
                'core',
                'social',
                'professional',
            ])->index();
            $table->string('default_value')->index();
            $table->string('is_required')->index();
            $table->string('is_fixed')->index();
            $table->string('is_visible')->index();
            $table->string('is_short_visible')->index();
            $table->string('is_listable')->index();
            $table->smallInteger('order')->index()->default(0);
            $table->string('reference')->index();
            $table->text('properties');
            $table->tinyInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('form_field');
    }
};
