<?php

namespace App\Models;

use App\Helpers\UserDataHandlerTrait;
use App\Helpers\UuidGeneratorTrait;
use App\Models\User\Profile;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        Notifiable,
        UserDataHandlerTrait,
        UuidGeneratorTrait;

    protected $table = 'users';

    public $keyType = 'string';

    public $incrementing = 'false';

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
