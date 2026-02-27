<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'name',
        'type',
        'amount',
        'current_value',
        'purchase_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'current_value' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
