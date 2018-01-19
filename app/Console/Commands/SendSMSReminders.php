<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;
use App\Appointment;
use Carbon\Carbon;
use App\Sms;

class SendSMSReminders extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-reminders:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS Reminders for all appointments that are eligible for criteria';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sid = 'ACa72585b0dcebe0257e98f8a98d42ed4c';
        $token = '640daf412274d073100183158a4f3399';

        $client = new Client($sid, $token);

        $now = Carbon::now();

        $sms = Sms::whereDate('send_at', '=', Carbon::today())->whereRaw("MINUTE(send_at) = $now->minute")->whereRaw("HOUR(send_at) = $now->hour")->get();

        foreach ($sms as $message) {
            // Use the client to do fun stuff like send text messages!
            $twilioMessage = $client->messages->create(
                    // the number you'd like to send the message to
                    $message->to,
                    array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $message->from_name,
//                'from' => '+18606614770',
                // the body of the text message you'd like to send
                'body' => $message->content,
                // sms/{sms}/status/update
                'StatusCallback' => "http://a26850ae.ngrok.io/sms/{$message->id}/status/update"
                    )
            );
            $message->sid = $twilioMessage->sid;
            $message->status = $twilioMessage->status;
            switch ($message->status) {
                case 'queued':
                    $message->queued = true;
                    break;
                case 'failed':
                    $message->failed = true;
                    break;
                case 'sent':
                    $message->sent = true;
                    break;
                case 'delivered':
                    $message->delivered = true;
                    break;
                case 'undelivered':
                    $message->undelivered = true;
                    break;
            }
            $message->save();
            $message->history()->create(['status' => $twilioMessage->status,]);
        }
        $smsCount = count($sms);
        $this->info($smsCount);
    }

}
