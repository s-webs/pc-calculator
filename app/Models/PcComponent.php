<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PcComponent extends Model
{
    protected $fillable = [
        'pc_category_id',
        'name',
        'image',
        'prime_cost',
        'sale_price',
        'quantity',
        'available'
    ];


    public function scopeUserItems(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PcCategory::class, 'pc_category_id');
    }
}
