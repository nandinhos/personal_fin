<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'profile_id',
        'name',
        'type',
        'last_four_digits',
        'limit',
        'current_balance',
        'closing_day',
        'due_day',
        'color',
        'brand',
        'is_active',
    ];

    protected $casts = [
        'limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'closing_day' => 'integer',
        'due_day' => 'integer',
        'is_active' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
