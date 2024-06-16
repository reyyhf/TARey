<?php

namespace App\Models\User;

use App\Models\BaseModel as Base;

class UserStatus extends Base
{
    protected $table = 'user_statuses';

    protected $fillable = [
        'name',
        'minimum_teach_load_hour',
    ];

    protected $casts = [
        'minimum_teach_load_hour' => 'integer',
    ];
}
