<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\UserChildren;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChildrenBirthdayMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $fromUser;

    public $child;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param UserChildren $children
     */
    public function __construct(User $user,UserChildren $children)
    {
        $this->fromUser = $user;
        $this->child = $children;
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
        $subject = sprintf('Դուք ստացել եք բոնուս մեր կայքի կողմից!');
        $greeting = sprintf('Բարև ձեզ!');
        $message = sprintf('Ձեր երեխայի՝ %s-ի, ծննդյան օրվա արթիվ նվիրում ենք ձեզ 5000դր․ բոնուս։ Շնորակալություն մեր կայքից օգտվելու համար!',$this->child->name);
        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message);
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
