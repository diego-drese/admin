<?php

namespace App\Models;

class RadioStationAccount extends RadioStation {
	const TABLE = 'radio_station_account';
	protected $table = 'radio_station_account';
    protected function getArrayableAppends() : array {
        $this->appends = array_unique(array_merge($this->appends, ['account_id', 'size_gb']));
        //$this->hidden = array_unique(array_merge($this->hidden, ['is_root']));
        return parent::getArrayableAppends();
    }
	
}
