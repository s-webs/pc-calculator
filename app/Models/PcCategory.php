<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PcCategory extends Model
{
    protected $fillable = ['name'];

    public function scopeUserItems(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    public function components(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PcComponent::class, 'pc_category_id');
    }
}
