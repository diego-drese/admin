<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $emailClass = null;
    protected $user = null;
    public function __construct($emailClass, $user) {
        $this->emailClass   = $emailClass;
        $this->user         = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        try {
            Mail::to($this->user->email)->send($this->emailClass);
            Log::info('SendEmailJob::handle', ['user'=>$this->user, 'class'=>get_class($this->emailClass)]);
        }catch (\Exception $e){
            Log::error('SendEmailJob::handle', ['user'=>$this->user, 'class'=>get_class($this->emailClass), 'error'=>$e->getMessage(), 'line'=>$e->getLine(), 'file'=>$e->getFile()]);
            $this->fail($e);
        }

    }
}
