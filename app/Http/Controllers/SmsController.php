<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;
use App\SmsHistory;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller {

    public function updateStatus(Request $request, Sms $sms)
    {

        $sms->status = $request->MessageStatus;

        switch ($sms->status) {
            case 'queued':
                $sms->queued = true;
                break;
            case 'failed':
                $sms->failed = true;
                break;
            case 'sent':
                $sms->sent = true;
                break;
            case 'delivered':
                $sms->delivered = true;
                break;
            case 'undelivered':
                $sms->undelivered = true;
                break;
        }

        $sms->save();

        $sms->history()->create(['status' => $sms->status]);

        Log::debug('Message Status Update', [
            'request' => $request->all(),
            'sms' => $sms
        ]);

        return response()->json(['message' => 'Status Updated'], 200);
    }

}
