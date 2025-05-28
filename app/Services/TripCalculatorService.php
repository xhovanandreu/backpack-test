<?php

namespace App\Services;

//use App\Models\ApplicationUser;
use App\Models\ApplicationUser;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Trip;
use App\Models\DistanceDurationTime;
/**
 * @class TripCalculatorService
 */
class TripCalculatorService
{
    use WithoutModelEvents;

    /**
     * Calculate the estimated arrival time
     *
     * @param Trip $trip
     * @return void
     */
    public function calculateEstimatedArrivalTime(Trip $trip) : void
    {
        // check if exits in db

        $valueOnDb = DistanceDurationTime::where('start_point', $trip->getAttribute('start_point'))
            ->where('end_point', $trip->getAttribute('end_point'))
            ->where('start_time', $trip->getAttribute('starting_time'))
            ->first();

        if(!$valueOnDb){
            // call api
            $valueOnDb  = $this->calculateTripDurationTimeApiCAll($trip);
        }
        $trip->setAttribute('estimated_arrival_time',  $trip->getAttribute('starting_time')->add('minutes',$valueOnDb->duration_traffic));
        $trip->saveQuietly();
    }

    /**
     * Call the API to get the duration time
     *
     * @param Trip $trip
     * @return DistanceDurationTime
     */
    public function calculateTripDurationTimeApiCAll(Trip $trip)
    {
        // here lets make the api call

        // here lets save the data in the db

        try {

            // api call
            $distanceDurationTime = DistanceDurationTime::create([
                'start_point' => $trip->getAttribute('start_point'),
                'end_point' => $trip->getAttribute('end_point'),
                'duration_time' => 125,
                'duration_traffic' => 155,
                'start_time' => $trip->getAttribute('starting_time'),
                'km' => 155.34,
            ]);
            return $distanceDurationTime;

        } catch (Exception $e) {
            // return sth here
            return [];
        }

    }

}
