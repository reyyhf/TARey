<?php

namespace App\Models;

use App\Helpers\UuidGeneratorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes, UuidGeneratorTrait;

    public $keyType = 'string';

    public $incrementing = 'false';
}
