<?php

namespace Fouladgar\MobileVerification\Notifications;

use Fouladgar\MobileVerification\Contracts\MustVerifyMobile;
use Fouladgar\MobileVerification\Notifications\Channels\VerificationChannel;
use Fouladgar\MobileVerification\Notifications\Messages\MobileVerificationMessage;
use Illuminate\Notifications\Notification;

class VerifyMobile extends Notification
{
    /**
     * The verification token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return [VerificationChannel::class];
    }

    /**
     * Build the mobile representation of the notification.
     *
     * @param $notifiable
     *
     * @return MobileVerificationMessage
     */
    public function toMobile(MustVerifyMobile $notifiable): MobileVerificationMessage
    {
        return (new MobileVerificationMessage())->to($notifiable->getMobileForVerification())
            ->token($this->token);
    }
}
