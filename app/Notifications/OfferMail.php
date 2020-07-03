<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $fromUser;

    public $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,Offer $offer)
    {
        $this->fromUser = $user;
        $this->offer = $offer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = sprintf('Դուք ստացել եք նոր առաջարկ %s-ից!', $this->fromUser->name);
        $greeting = sprintf('Բարև ձեզ!');
        $message = sprintf('Ցանկանում եմ գնել %s հատ %s  %s դրամով!', $this->offer->quantity,$this->offer->product->model->title,$this->offer->price);
        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->action('Տեսնել ապրանքը', url($this->offer->id));
//            ->line('Thank you for using our application!')
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
