<?php declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var \App\Models\Order */
    protected $order;

    /** @var object */
    protected $customer;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order  $order
     * @param  object  $customer
     */
    public function __construct($order, object $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
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
    public function toMail()
    {
        return (new MailMessage)
                    ->greeting("Hola {$this->customer->fullname}, gracias por tu orden.")
                    ->line('Has el seguimiento de tu pedido del tu pedido.')
                    ->line('Clic en el botón para obeter más información.')
                    ->action('View Order', url(route('order.track-view', $this->order->token)));
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
