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
    protected $emailTo = null;
    public function __construct($emailClass, $emailTo) {
        $this->emailClass   = $emailClass;
        $this->emailTo      = $emailTo;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $maxAttempts = 3;
        $attempts = 0;
        while ($attempts < $maxAttempts) {
            try {
                Mail::to($this->emailTo)->send($this->emailClass);
                Log::info('SendEmailJob::handle', ['attempt'=>$attempts, 'emailTo' => $this->emailTo, 'class' => get_class($this->emailClass)]);
                $attempts=$maxAttempts;
                break;
            } catch (\Exception $e) {
                $attempts++;
                if ($attempts < $maxAttempts) {
                    sleep(2);
                    Log::error('SendEmailJob::handle, error', [
                        'emailTo'   => $this->emailTo,
                        'class'     => get_class($this->emailClass),
                        'error'     => str_replace(array("\r", "\n", "\t"), '',$e->getMessage()),
                        'line'      => $e->getLine(),
                        'file'      => $e->getFile(),
                        'attempt'   => $attempts,
                    ]);
                } else {
                    $this->fail($e);
                }
            }
        }
    }

}
