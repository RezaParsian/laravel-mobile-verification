<?php

namespace Fouladgar\MobileVerifier\Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'name', 'mobile',
    ];
}
