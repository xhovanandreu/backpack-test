<?php

return [
    'distance_matrix_base_url'        => env('DISTANCE_MATRIX_BASE_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json'),
    'distance_matrix_mode'            => env('GOOGLE_DISTANCE_MATRIX_MODE', 'driving'),
    'distance_matrix_traffic_model'   => env('GOOGLE_DISTANCE_MATRIX_TRAFFIC_MODEL', 'pessimistic'),
    'distance_matrix_request_method'  => env('GOOGLE_DISTANCE_MATRIX_REQUEST_METHOD', 'GET'),
    'distance_matrix_endpoint'        => env('GOOGLE_DISTANCE_MATRIX_ENDPOINT', 'json'),

];
