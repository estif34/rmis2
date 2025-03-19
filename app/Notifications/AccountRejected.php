<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(?string $reason = null)
    {
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
                    ->subject('Account Application Status')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('We regret to inform you that your account application has not been approved at this time.');
                    
        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }
        
        $mail->line('If you have any questions, please contact the administrator.')
             ->line('Thank you for your understanding.');
             
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your account has been rejected',
            'reason' => $this->reason,
        ];
    }
}