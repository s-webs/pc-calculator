<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PcBuild extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'name',
        'components',
        'prime_cost',
        'sale_price',
        'quantity',
        'available',
    ];

    protected $casts = [
        'components' => 'array'
    ];

    public function scopeUserItems(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
