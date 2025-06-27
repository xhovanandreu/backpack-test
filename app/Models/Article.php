<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'slug',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function destinations() : hasMany
    {
        return $this->hasMany(Destination::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopeSearch(Builder $query, $searchText): Builder
    {

        return $query->where('title', 'like', "%{$searchText}%")
        ->orWhere('subtitle', 'like', "%{$searchText}%")
        ->orWhere('body', 'like', "%{$searchText}%");
    }


    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
