<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'desc', 'priority', 'completed', 'goal_id', 'day_id',
    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

}
