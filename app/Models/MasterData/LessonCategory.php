<?php

namespace App\Models\MasterData;

use App\Models\BaseModel as Base;

class LessonCategory extends Base
{
    protected $table = 'lesson_categories';

    protected $fillable = [
        'name',
    ];
}
