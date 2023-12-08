<?php

namespace App\Notifications;

use App\Notifications\Channels\WhatsappChannel;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class GeneralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string  $title,
        public string  $body,
        public ?string $image = null,
        public array   $methods = ['database', 'fcm', 'whatsapp'],
        public ?string $url = null,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        $channels = [];

        if (in_array('database', $this->methods)) {
            $channels[] = 'database';
        }

        if (in_array('fcm', $this->methods)) {
            $channels[] = FcmChannel::class;
        }

        if (in_array('whatsapp', $this->methods)) {
            $channels[] = WhatsappChannel::class;
        }

        return $channels;
    }

    /**
     * Prepare FCM Message.
     *
     * @param mixed $notifiable
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function toFcm(mixed $notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData([
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image ?? asset('logo.png'),
                'url' => $this->url ?? '',
            ])
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle($this->title)
                    ->setBody($this->body)
                    ->setImage($this->image ?? asset('logo.png'))
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')),
            );
    }

    /**
     * Get Whatsapp Data to be Sent (phones/message).
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toWhatsapp(mixed $notifiable): array
    {
        return [
            'phones' => [$notifiable->getPhoneForVerification()],
            'type' => $this->image ? 'IMAGE' : 'TEXT',
            'image' => $this->image,
            'message' => "{$this->title}\n" .
                "{$this->body}\n" .
                ($this->url ?? '') . "\n" .
                "--------------------------\n" .
                "Megaminds Academy | مستقبل أفضل من أجل أطفالك",
        ];
    }

    /**
     * Get the Database representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     * @throws \Exception
     */
    public function toDatabase(mixed $notifiable): array
    {
        $actions = [];

        if (filled($this->url)) {
            $actions[] = Action::make('open_url')
                ->label(__('filament-support::actions/view.single.label'))
                ->url($this->url);
        }

        return array_merge(
            \Filament\Notifications\Notification::make()
                ->title($this->title)
                ->body($this->body)
                ->actions($actions)
                ->getDatabaseMessage(),
            [
                'image' => $this->image ?? asset('logo.png'),
                'url' => $this->url ?? null,
            ]
        );
    }
}
