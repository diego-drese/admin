<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ActionLog extends Model {
    
    protected $table = 'action_log';
    protected $fillable= [
        'account_id',
        'user_id',
        'collection',
        'collection_id',
        'type',
        'action',
    ];
    const ACTION_CREATED    = 'created';
    const ACTION_UPDATED    = 'updated';
    const ACTION_DELETED    = 'deleted';
    const ACTION_PAYMENT    = 'payment';

    const TYPE_INFO         = 'info';
    const TYPE_ERROR        = 'error';
    const TYPE_WARNING      = 'warning';

    protected static function booted() {
        static::addGlobalScope(new AccountScope());
    }

    protected static function insertLog(Model $model, string $origin, string $type, User $user=null, $action=null, $desc=null){
        try {
            $model = self::firstOrNew();
            $model->fill([
                'account_id'    => (string)$model->account_id,
                'table_id'      => $model->_id,
                'table'         => $model->getTable(),
                'user'          => (string)$user->id ?? 'Sys',
                'type'          => $type,
                'action'        => $action,
                'origin'        => $origin,
                'desc'          => $desc,
            ]);
            $model->save();
        } catch (\Exception $e){
            Log::error('ActionLog insertLog,', ['e'=>$e->getMessage(), 'file'=>$e->getFile(), 'line'=>$e->getLine(), 'trace'=>$e->getTrace()]);
            $model = self::firstOrNew();
            $model->fill([
                'account_id'    => 'Undefined',
                'table_id'      => 'Undefined',
                'table'         => 'Undefined',
                'user'          => 'Undefined',
                'type'          => self::TYPE_ERROR,
                'action'        => 'Undefined',
                'origin'        => 'Undefined',
                'desc'          => json_encode(['e'=>$e->getMessage(), 'file'=>$e->getFile(), 'line'=>$e->getLine(), 'trace'=>$e->getTrace()]),
            ]);
            $model->save();
        }
        return $model;
    }



}
