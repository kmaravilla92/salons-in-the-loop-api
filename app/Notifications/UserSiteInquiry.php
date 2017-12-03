<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserSiteInquiry extends Notification
{
    use Queueable;

    protected $enquiry_details = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($enquiry_details = [])
    {
        $this->enquiry_details = $enquiry_details['contact'];
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
        $sender_name = $this->enquiry_details['first_name'] . ' ' . $this->enquiry_details['last_name'];
        $mail_message = (new MailMessage)
                            ->from($this->enquiry_details['email'], $sender_name)
                            ->subject('User Site Inquiry')
                            ->greeting('Hi Admin,')
                            ->line('A new site inquiry has been sent by our user, please see the details below:');
                            
        foreach($this->enquiry_details as $field => $value) {
            $field_label = ucwords(str_replace('_',' ', $field));
            $message = $field_label . ': ' . $value;
            $mail_message = $mail_message->line($message);
        }

        return $mail_message;
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
