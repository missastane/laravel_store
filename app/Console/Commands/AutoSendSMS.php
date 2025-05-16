<?php

namespace App\Console\Commands;

use App\Jobs\SendSMSToUsers;
use App\Models\Notify\SMS;
use Illuminate\Console\Command;

class AutoSendSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:send-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
    //  * @return int
     */
    public function handle()
    {
        $msgsToSend = SMS::where('published_at', '=', now())->where('status', 1)->get();
        foreach($msgsToSend as $sms)
        {
            SendSMSToUsers::dispatch($sms);
        }
    }
}
