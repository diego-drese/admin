<?php

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    protected $connection = 'mongo';
    public function up() {
        Schema::connection($this->connection)
            ->table('radio_station', function (Blueprint $collection) {
                $collection->background(["id"]);
                $collection->background(["checksum_stacao_rd"]);
                $collection->background(["checksum_stacao_rd_date"]);
                $collection->background(["checksum_plano_basico_am"]);
                $collection->background(["checksum_plano_basico_am_date"]);
                $collection->background(["checksum_plano_basico_tv_fm"]);
                $collection->background(["checksum_plano_basico_tv_fm_date"]);
                $collection->background(["checksum"]);
                $collection->background(["documento_historico.id_document"]);
                $collection->background(["fistel"]);
                $collection->background(["updated_at"]);
            });
    }

    public function down(){
        Schema::connection($this->connection)->dropIfExists('radio_station');
    }
};
