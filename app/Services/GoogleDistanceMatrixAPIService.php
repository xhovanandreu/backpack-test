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
                    'traffic_model'  => 'pessimistic',
                    'mode' => config('google-matrix.distance_matrix_mode'),
                ]
            );

            dd($response);

            return $this->processResponse($startStop, $endStops, $trip->starting_time, $response->json());
        } catch (Exception $e) {
            // return sth here
            return [];
        }

    }


    /**
     * Execute the API
     * @param Stop $startStops
     * @param Stop $endStops
     * @param array $optionalParams
     * @return Response|null
     */
    public function prepareAndExecute(Stop $startStops, Stop $endStops, array $optionalParams = [] ) : \Psr\Http\Message\ResponseInterface|null
    {
        try{
            $params = array_merge($optionalParams, [
                'destinations' => $endStops->lat. "," .$endStops->long,
                'origins' => $startStops->lat. "," .$startStops->long,
                'key' => config('services.google_maps.api_key'),
            ]);

            $baseUrl = config('google_matrix.distance_matrix_base_url');
//            dd($params, $baseUrl);
            return $this->client->request('GET', $baseUrl, $params);


        } catch (GuzzleException $e) {
            return null;
        }
    }

    /**
     * Call the API to get the duration time
     *
     * @param Stop $startStop
     * @param Stop $endStop
     * @param DateTime $startingTime
     *
     * @return DistanceDurationTime |null
     */
    public function processResponse(Stop $startStop, Stop $endStop, DateTime $startingTime , $data): DistanceDurationTime|null
    {

        if (!isset($data['rows']) || count($data['rows']) < 1) {
            Log::error("STOP METRIC ERROR RESPONSE: " . $data['error_message'] ?? 'No error message provided');
            return null;
        }


       $distanceDurationTime =  DistanceDurationTime::create([
            'start_point' => $startStop->id,
            'end_point' => $endStop->id,
            'duration_time' =>  $data['rows'][0]['elements'][0]['duration']['value'] ?? 0,
            'duration_traffic' =>  $data['rows'][0]['elements'][0]['duration_in_traffic']['value'] ?? 0,
            'start_time' => $startingTime,
            'distance' => $data['rows'][0]['elements'][0]['distance']['value'] ?? 0,
        ]);

        return $distanceDurationTime;
    }


}
