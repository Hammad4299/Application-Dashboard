<?php

namespace App\Listeners;

use App\Events\SendConfirmationMail;
use App\Mail\WelcomeUser;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendConfirmationMailListener
{
    protected $name;
    protected $email;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendConfirmationMail  $event
     * @return void
     */
    public function handle(SendConfirmationMail $event)
    {
        $user = $event->user;

        Mail::to($user->email)//$payload['user']->email)
            ->send(new WelcomeUser($user));

//        Mail::send('email.welcome', $payload, function(Message $message) use ($payload) {
//            $message
//                ->to($payload['user']->name)
//                ->from('rizwandogar111@gmail.com')
//                ->subject('Welcome!');
//        });
    }
}
