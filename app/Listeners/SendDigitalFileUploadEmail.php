<?php

namespace App\Listeners;

use App\Events\DigitalProductFileUploadComplete;
use App\Mail\DigitalFileUploadSuccessMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDigitalFileUploadEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DigitalProductFileUploadComplete $event): void
    {
        $file = $event->file;
        $user = $event->user;

        Log::info('User: ' . $user);
        Log::info('File: ' . $file);

        if (!$user)
            return;

        Mail::to($user->email)
            ->queue(new DigitalFileUploadSuccessMail($file, $user));
    }
}
