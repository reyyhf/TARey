<?php

namespace App\Models\MasterData;

use App\Helpers\UuidGeneratorTrait;
use Illuminate\Database\Eloquent\Model;

class ScheduleLessonHour extends Model
{
    use UuidGeneratorTrait;

    public $incrementing = false;

    public $keyType = 'string';

    protected $table = 'schedule_lesson_hours';

    protected $fillable = [
        'schedule_day_id',
        'started_at',
        'ended_at',
        'started_duration',
        'ended_duration',
        'order_direction',
        'is_break_hour',
    ];

    protected $casts = [
        'started_at' => 'integer',
        'ended_at' => 'integer',
        'is_break_hour' => 'boolean',
        'order_direction' => 'integer',
    ];

    public function scheduleDay()
    {
        return $this->belongsTo(ScheduleDay::class, 'schedule_day_id');
    }

    public function scopeGetByOrderDirection($query, $scheduleDayId, $orderDirection = [])
    {
        return $query->where('schedule_day_id', $scheduleDayId)
            ->whereIn('order_direction', $orderDirection);
    }

    public function scopeGetByDay($query, $scheduleDayId = null)
    {
        return $query->where('schedule_day_id', $scheduleDayId)
            ->with('scheduleDay')
            ->orderBy('order_direction', 'asc');
    }

    public function scopeFindExistedHour($query, $scheduleDayId, $startedAt)
    {
        return $query->where('schedule_day_id', $scheduleDayId)
            ->where('started_at', $startedAt);
    }

    public function scopeCountMaximumBreakHours($query)
    {
        return $query->where('is_break_hour', 1)->count();
    }

    public function getScheduleLessonHourNameAttribute()
    {
        return 'Jam Pelajaran Ke - '.$this->started_at;
    }

    public function getDetailDurationAttribute()
    {
        return $this->started_duration.' - '.$this->ended_duration;
    }
}
