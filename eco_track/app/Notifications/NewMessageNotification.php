<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Define which channels the notification will be sent through.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // you can add 'mail' if needed
    }

    /**
     * Format notification for storage in the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New message from user: ' . $this->message->sender->name,
            'content' => $this->message->content,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'created_at' => $this->message->created_at,
        ];
    }

    /**
     * Optional: send as email if 'mail' is enabled in via()
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Message Notification')
            ->line('You have received a new message from ' . $this->message->sender->name . '.')
            ->line('Message: "' . $this->message->content . '"')
            ->action('View Message', url('/admin-messages'))
            ->line('Thank you for using EcoTrack!');
    }

    /**
     * Optional: fallback array representation
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message->content,
        ];
    }
}
