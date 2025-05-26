<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Attributes\Scope;
class ApplicationUser extends Model
{
    //
    use HasApiTokens;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_users';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'app_key',
        'app_secret',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;


    /**
     * Scope a query to only include verified app_key and app_secret.
     */
    #[Scope]
    protected function scopeVerifyKeys(Builder $query, string $app_key, string $app_secret): Builder
    {
        return $query->where('app_key', $app_key)
            ->where('app_secret', $app_secret);
    }

}
