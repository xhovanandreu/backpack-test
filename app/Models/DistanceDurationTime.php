<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DistanceDurationTime extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distance_duration_times';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'start_point',
        'end_point',
        'duration_time',
        'duration_traffic',
        'start_time',
        'km'
    ];


}
