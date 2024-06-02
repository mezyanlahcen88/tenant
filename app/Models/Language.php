<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }
    //  put the scopes there
    /**
     * Scope a query to only include actived items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTranslated($query)
    {
        return $query->where('language_id', 1)->first();
    }
}
