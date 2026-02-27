<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'name',
        'target_amount',
        'current_amount',
        'deadline',
        'is_completed',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
        'is_completed' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if ($this->target_amount == 0) {
            return 0;
        }

        return (int) (($this->current_amount / $this->target_amount) * 100);
    }
}
