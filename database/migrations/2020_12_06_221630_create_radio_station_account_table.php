<?php

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    protected $connection = 'mongo';
    public function up() {
        Schema::connection($this->connection)
            ->table('radio_station_account', function (Blueprint $collection) {
                $collection->background(["account_id"]);
                $collection->background(["fistel"]);
                $collection->background(["size_gb"]);
                $collection->background(["updated_at"]);
            });
    }

    public function down(){
        Schema::connection($this->connection)->dropIfExists('radio_station_account');
    }
};
