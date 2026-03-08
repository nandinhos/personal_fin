<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'profile_id',
        'name',
        'type',
        'initial_balance',
        'balance',
        'color',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Recalculates the balance based on initial_balance + sum(incomes) - sum(expenses)
     */
    public function recalculateBalance()
    {
        $incomes = $this->transactions()->where('type', 'income')->sum('amount');
        $expenses = $this->transactions()->where('type', 'expense')->sum('amount');
        
        $this->balance = $this->initial_balance + $incomes - $expenses;
        $this->save();
        
        return $this->balance;
    }

    protected function formattedBalance(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => 'R$ ' . number_format($this->balance, 2, ',', '.')
        );
    }
}
