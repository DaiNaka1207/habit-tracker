<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('habit_logs')]
#[Fillable(['habit_id', 'date'])]
class HabitLog extends Model
{
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
