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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_check_token')->nullable()->index();
            $table->timestamp('email_check_send_at')->nullable()->index();
            $table->timestamp('email_check_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function($table) {
            $table->dropColumn(['email_check_token', 'email_check_send_at', 'email_check_at']);
        });
    }
};
