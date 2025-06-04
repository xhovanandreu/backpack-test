<?php

namespace App\Services;

use App\Models\DistanceDurationTime;
use App\Models\Stop;
use App\Models\Trip;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DateTime;
use Psr\Http\Message\ResponseInterface;

class GoogleDistanceMatrixAPIService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Call the API to get the duration time
     *
     * @param Trip $trip
     * @return DistanceDurationTime|null|array
     */
    public function calculateTripDurationTimeApiCAll(Trip $trip): DistanceDurationTime|null|array
    {
        try {

            $startStop = $trip->startStop()->first();
            $endStops = $trip->endStop()->first();

            $response =  $this->prepareAndExecute(
                $startStop,
                $endStops,
                [
                    'departure_time' =>  $trip->starting_time->timestamp,
                    'traffic_model'  => config('google-matrix.distance_matrix_traffic_model'),
                    'mode' => config('google-matrix.distance_matrix_mode'),
                ]
            );

            if (!$response) {
                Log::warning("No response returned from Google API for trip ID {$trip->id}");
                return null;
            }


            return $this->processResponse($startStop, $endStops, $trip->starting_time, json_decode($response->getBody(), true));
        } catch (Exception $e) {
            Log::error("Trip calculation failed for trip ID {$trip->id}: {$e->getMessage()}");
            return null;
        }

    }


    /**
     * Execute the API
     * @param Stop $startStops
     * @param Stop $endStops
     * @param array $optionalParams
     * @return ResponseInterface|null
     */
    public function prepareAndExecute(Stop $startStops, Stop $endStops, array $optionalParams = [] ) : ResponseInterface|null
    {
        try{
            $requestMethod = config('google-matrix.distance_matrix_request_method');
            $baseUrl = config('google-matrix.distance_matrix_base_url');
            $params = array_merge($optionalParams, [
                'destinations' => $endStops->lat. "," .$endStops->long,
                'origins' => $startStops->lat. "," .$startStops->long,
                'key' => config('services.google_maps.api_key'),
            ]);


            return $this->client->request($requestMethod, $baseUrl,[
                'query' => $params
            ]);


        } catch (GuzzleException $e) {

            Log::error("Google Matrix API failed: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Call the API to get the duration time
     *
     * @param Stop $startStop
     * @param Stop $endStop
     * @param DateTime $startingTime
     * @param array $data
     * @return DistanceDurationTime |null
     */
    public function processResponse(Stop $startStop, Stop $endStop, DateTime $startingTime, array $data): DistanceDurationTime|null
    {
        if (!isset($data['rows']) || count($data['rows']) < 1) {
            Log::error("Google Matrix API error: " . $data['error_message'] ?? 'No error message provided');
            return null;
        }


        return DistanceDurationTime::create([
            'start_point' => $startStop->id,
            'end_point' => $endStop->id,
            'duration_time' =>  $data['rows'][0]['elements'][0]['duration']['value'] ?? 0,
            'duration_traffic' =>  $data['rows'][0]['elements'][0]['duration_in_traffic']['value'] ?? 0,
            'start_time' => $startingTime,
            'distance' => $data['rows'][0]['elements'][0]['distance']['value'] ?? 0,
        ]);
    }


}
