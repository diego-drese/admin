<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ActionLog;

trait Observable {
    public static function bootObservable() {
        static::created(function (Model $model) {
            $changes = $model->isDirty() ? $model->getDirty() : false;
            if($changes)  {
                $user = Auth::user();
                $logData = [
                    'account_id'    => isset($model->account_id) ? $model->account_id : null,
                    'table_id'      => isset($model->_id) ? $model->_id : $model->id,
                    'table'         => $model->getTable(),
                    'user_id'       => isset($user->id) ? $user->id : null,
                    'user_name'     => isset($user->name) ? $user->name : 'Sys',
                    'type'          => ActionLog::TYPE_INFO,
                    'action'        => ActionLog::ACTION_CREATED,
                ];
                $dataParser = [];
                foreach($changes as $attr => $value) {
                    if(is_numeric($value) || is_array($value) || strlen($value)<50){
                        $dataParser[$attr] = $value;
                    }else{
                        $dataParser[$attr] = mb_substr($value, 0, 50).'...';
                    }
                }
                $logData['data'] = $dataParser;
                Log::info('CoreOctaFlow Observable', $logData);
            }
        });
        static::updated(function (Model $model) {
            $changes = $model->isDirty() ? $model->getDirty() : false;
            if($changes)  {
                $user = Auth::user();
                $logData = [
                    'account_id'    => isset($model->account_id) ? $model->account_id : null,
                    'table_id'      => isset($model->_id) ? $model->_id : $model->id,
                    'table'         => $model->getTable(),
                    'user_id'       => isset($user->id) ? $user->id : null,
                    'user_name'     => isset($user->name) ? $user->name : 'Sys',
                    'type'          => ActionLog::TYPE_INFO,
                    'action'        => ActionLog::ACTION_UPDATED,
                ];
                $dataParser = [];
                foreach($changes as $attr => $value) {
                    if($model->getOriginal($attr)!=$model->$attr){
                        if(is_numeric($value) || is_array($value) || strlen($value)<50){
                            $dataParser[$attr] = ['from'=>$model->getOriginal($attr), 'to'=>$value];
                        }else{
                            $dataParser[$attr] = ['from'=>mb_substr($model->getOriginal($attr), 0, 191).'...', 'to'=>mb_substr($value, 0, 191).'...'];
                        }
                    }
                }
                $logData['change'] = $dataParser;
                Log::info('CoreOctaFlow Observable', $logData);
            }
        });

        static::deleted(function (Model $model) {
            $changes = $model->isDirty() ? $model->getDirty() : false;
            if($changes)  {
                $user = Auth::user();
                $logData = [
                    'account_id'    => isset($model->account_id) ? $model->account_id : null,
                    'table_id'      => isset($model->_id) ? $model->_id : $model->id,
                    'table'         => $model->getTable(),
                    'user_id'       => isset($user->id) ? $user->id : null,
                    'user_name'     => isset($user->name) ? $user->name : 'Sys',
                    'type'          => ActionLog::TYPE_INFO,
                    'action'        => ActionLog::ACTION_DELETED,
                ];
                Log::info('CoreOctaFlow Observable', $logData);
            }
        });
    }
}