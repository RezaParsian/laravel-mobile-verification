<?php

namespace Fouladgar\MobileVerifier\Tests;

use Fouladgar\MobileVerifier\Concerns\TokenBroker;
use Fouladgar\MobileVerifier\Contracts\SmsClient;
use Fouladgar\MobileVerifier\Listeners\SendMobileVerificationNotification;
use Fouladgar\MobileVerifier\Notifications\Channels\VerificationChannel;
use Fouladgar\MobileVerifier\Notifications\VerifyMobile;
use Fouladgar\MobileVerifier\Repository\DatabaseTokenRepository;
use Fouladgar\MobileVerifier\Tests\Models\User;
use Fouladgar\MobileVerifier\Tests\Models\VerifiableUser;
use Illuminate\Auth\Events\Registered;
use Mockery as m;

class ATest extends TestCase
{

    /** @test */
    public function it_can_hard()
    {
        $user = new VerifiableUser();
        $user->mobile = '55555';
        $event    = new Registered($user);
        $listener = new SendMobileVerificationNotification(new TokenBroker(new DatabaseTokenRepository()));

        $listener->handle($event);
    }

    /** @test */
    public function it_can()
    {
        $notification = new VerifyMobile('token_123');
        $notifiable   = new VerifiableUser();

        $notifiable->mobile = '555555';

        $verificationChannel = new VerificationChannel(
            $client = m::mock(SmsClient::class)
        );

        $client->shouldReceive('sendMessage')
                ->once()
                ->andReturn(true);

        $this->assertTrue($verificationChannel->send($notifiable, $notification));
    }

    /** @test */
    public function it_can2()
    {
        $notification = new VerifyMobile('token_123');
        $notifiable   = new User();

        $verificationChannel = new VerificationChannel(
            $client = m::mock(SmsClient::class)
        );

        $client->shouldNotReceive('sendMessage');

        $this->assertNull($verificationChannel->send($notifiable, $notification));
    }
}

