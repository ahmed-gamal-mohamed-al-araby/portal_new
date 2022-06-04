<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationPurchase extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user_id;
    public $purchase_id;
    public $user_name;
    public $next_id;
    public $timeline;
    public $date;
    public $time;
    public function __construct($data = [])
    {
        $this->user_id = $data['user_id'];
        $this->purchase_id = $data['purchase_id'];
        $this->user_name = $data['user_name'];
        $this->next_id = $data['next_id'];
        $this->timeline = $data['timeline_id'];
        $this->date = date("Y M d", strtotime(Carbon::now()));
        $this->time = date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */


    public function toArray($notifiable)
    {
        return [
            "next_id" => $this->next_id,
            "purchase_id" => $this->purchase_id,
            'timeline_id' => $this->timeline
        ];
    }
}
