<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HabitatValidated extends Notification
{
    use Queueable;
    private $habitat_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($habitat_id)
    {
       $this->habitat_id = $habitat_id;
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
        return (new MailMessage)
            ->from(env('NOTIFICATION_MAIL_CONTACT'))
            ->subject('Validation de votre Habitat')
            ->line('Félicitations! Votre habitat a été validé par AtypikHouse. Il est dès à présent visible sur le site
            atypik-house.com')
            ->action('Consulter l\'Habitat', url(env('BASE_URL_TO_SEE_HABITAT').'/'.$this->habitat_id))
            ->line('Merci de faire confiance à AtypikHouse !');
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
