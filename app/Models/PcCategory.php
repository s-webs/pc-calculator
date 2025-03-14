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
}
