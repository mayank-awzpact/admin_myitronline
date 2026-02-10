<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;
    public $callback_url;
    public $domain;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $callback_url, $domain)
    {
        $this->token = $token;
        $this->email = $email;
        $this->callback_url = $callback_url;
        $this->url = 'https://' . $domain . '.com'; // Ensuring the URL is properly formed with https
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
        $url = $this->url . '/' . $this->callback_url . '?token=' . $this->token . '&email=' . urlencode($this->email);

        return (new MailMessage)
            ->greeting('Hello!')
            ->subject('Password Reset Request:eITRFiling.com')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
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
