<?php

namespace App\Console\Commands;

use App\Jobs\SendMailToUsers;
use App\Models\Notify\Email;
use Illuminate\Console\Command;

class AutoSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:send-email';

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
        $emailsToSend = Email::where('published_at', '=', now())->where('status', 1)->get();
        foreach($emailsToSend as $email)
        {
            SendMailToUsers::dispatch($email);
        }
    }
}
