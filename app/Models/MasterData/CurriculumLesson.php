<?php

namespace App\Models\MasterData;

use App\Helpers\UuidGeneratorTrait;
use Illuminate\Database\Eloquent\Model;

class CurriculumLesson extends Model
{
    use UuidGeneratorTrait;

    protected $table = 'curriculum_lessons';

    protected $fillable = [
        'semester_id',
        'lesson_id',
        'classroom_label',
        'maximum_hours_per_week',
    ];

    public $keyType = 'string';

    public $incrementing = 'false';

    protected $casts = [
        'maximum_hours_per_week' => 'integer',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'id', 'lesson_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function scopeGetByLesson($query)
    {
        return $query->with([
            'lessons',
            'semester',
        ])
            ->get()
            ->groupBy('lesson_id');
    }
}
