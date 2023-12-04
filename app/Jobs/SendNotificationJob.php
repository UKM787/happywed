<?php

namespace App\Jobs;

use App\Models\Guest\GuestInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guestlist;
    protected $invitation;
    protected $callback;
    protected $notificationClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($guestlist, $invitation,   $notificationClass, $callback)
    {
        $this->guestlist = $guestlist;
        $this->invitation = $invitation;
        $this->callback = $callback;
        $this->notificationClass = $notificationClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->guestlist);
        $failedEmails = [];
        foreach ($this->guestlist as $guest) {
            try {
                Notification::send($guest, new $this->notificationClass($this->invitation->host, $this->invitation, 'sent you invitation'));
                //dd($guest);
                GuestInvitation::where('user_id', $guest->id)->where('invitation_id', $this->invitation->id)->first()->update(['email'=> 2]);
                //$guest->invitations[0]->guest_invitation->update(['email', 1]);
                // $guest->notify(new $this->notificationClass($this->invitation->host, $this->invitation, 'sent you invitation'));
            } catch (\Exception $e) {
                //dd($e);
                $failedEmails[] = $guest->email;
                //dd($guest, 'fail');
                GuestInvitation::where('user_id', $guest->id)->where('invitation_id', $this->invitation->id)->first()->update(['email'=> 3]);

                //$guest->invitations[0]->guest_invitation->update(['email', 10]);
            }
        }

        if (!empty($failedEmails)) {
            //dd($$failedEmails);
            //call_user_func($this->callback, $failedEmails);
        }
    }
}
