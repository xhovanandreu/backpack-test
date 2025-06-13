<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Trip;
use App\Models\DistanceDurationTime;

use App\Services\GoogleDistanceMatrixAPIService as GoogleMatrixService;

/**
 * @class TripCalculatorService
 */
class TripCalculatorService
{
    protected GoogleMatrixService $googleMatrixService;

    public function __construct(GoogleMatrixService $googleMatrixService)
    {
        $this->googleMatrixService = $googleMatrixService;
    }

    /**
     * Calculate the estimated arrival time
     *
     * @param Trip $trip
     * @return void
     */
    public function calculateEstimatedArrivalTime(Trip $trip) : void
    {
        $valueOnDb = $this->getTheDurationInTraffic($trip);

        $this->updateEstimatedArrivalTime($trip, $valueOnDb->duration_traffic);
    }


    /**
     *
     * Update the estimated arrival time of the trip
     *
     * @param Trip $trip
     * @param int $duration_traffic
     * @return void
     */
    public function updateEstimatedArrivalTime(Trip $trip,int $duration_traffic) : void
    {
        $trip->update(['estimated_arrival_time'=>$trip->starting_time->add('seconds',$duration_traffic)]);
    }

    /**
     * @param Trip $trip
     * @return DistanceDurationTime
     */
    public function getTheDurationInTraffic(Trip $trip) : DistanceDurationTime
    {
        return DistanceDurationTime::where('start_point', $trip->getAttribute('start_point'))
            ->where('end_point', $trip->getAttribute('end_point'))
            ->where('start_time', $trip->getAttribute('starting_time'))
            ->first()?? $this->googleMatrixService->calculateTripDurationTimeApiCAll($trip);
    }

}


