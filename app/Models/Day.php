<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Day extends Model
{
    use HasFactory;

    public $fillable = [
        'day_number', 'result', 'week_id'
    ];

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

}
