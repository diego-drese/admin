<?php
namespace App\Console;

use App\Models\HermesSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class KillCrons extends Command {
    public $signature    = 'Aerd:KillCrons {SecKillAll?} {--KillAll} {--KillAllHost} ';
    public $processName  = 'Aerd:KillCrons';
    public $description  = '';
    public $FILES        = [];
    public $jobName      = 'AerdKillCrons';
    public $totalMinutes = 700;


    public function __construct() {
        $this->description  = 'End all loaders or those that are marked to end in the table hermes_schedule';
        parent::__construct();
    }

    public function handle() {
        $killAll    = $this->option('KillAll');
        $KillAllHost= $this->option('KillAllHost');
        $SecKillAll = $this->argument('SecKillAll');

        if(!$killAll && !$KillAllHost && !$SecKillAll){
            $hostName       = getHostName();
            $cronsToKill    = HermesSchedule::where('host', $hostName)->where('status', 'W')->get();
            foreach ($cronsToKill as $cron){
                $cron->status       = 'N';
                $cron->last_kill_at = date('Y-m-d H:i:s');
                if($cron->save()){
                    Redis::setex('Kill' . $cron->name, 60, 1);
                    Log::info("KillCrons, Kill [".$cron->name."] process");
                }
            }
        }else if($killAll){
            $sec = 85;
            Redis::setex('KillCrons', 120, 1);
            while ($sec>0){
                Log::info("KillCrons, KillAll and CleanRedis waiting[".$sec."] seconds");
                $sec--;
                sleep(1);
            }
            Log::info("KillCrons, KillAll and CleanRedis removing all files lock");
            File::delete(File::glob(storage_path().'/framework/*.lock'));
            Log::info("KillCrons, KillAll and CleanRedis clean");
            Redis::flushdb();
            Redis::setex('KillCrons', 5, 1);
        }else if(!$killAll && $SecKillAll && (int)$SecKillAll>0){
            Log::info("KillCrons, KillAll width [".$SecKillAll."] seconds");
            Redis::setex('KillCrons', (int)$SecKillAll, 1);
        } elseif(!$killAll && $KillAllHost){
            $hostName       = getHostName();
            Log::info("KillCrons, KillAllHost [".$hostName."] host");
            $cronsToKill    = HermesSchedule::where('host', $hostName)->get();
            foreach ($cronsToKill as $cron){
                $cron->last_kill_at = date('Y-m-d H:i:s');
                if($cron->save()){
                    $redisKillThisCron  = 'Kill'.trim($cron->name);
                    Redis::setex($redisKillThisCron, 90, 1);
                    Log::info("KillCrons, KillHost[".$hostName."] Process[".$cron->name."] Kill[".$redisKillThisCron."]");
                }
            }

            File::delete(File::glob(storage_path().'/framework/*.lock'));
            Redis::setex('KillCrons', 5, 1);
        } else {
            Log::info("KillCrons, killAll [".$killAll."]");
            Redis::setex('KillCrons', 120, 1);
        }
    }
}