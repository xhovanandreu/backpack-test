<?php

return [
    'distance_matrix_base_url'        => env('DISTANCE_MATRIX_BASE_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json'),
    'distance_matrix_mode'            => env('GOOGLE_DISTANCE_MATRIX_MODE', 'driving'),
//    'distance_matrix_admin_email'     => env('GOOGLE_MATRIX_ADMIN_EMAIL', 'info@busforfun.com'),
//    'distance_matrix_unit_system'     => env('GOOGLE_DISTANCE_MATRIX_UNIT_SYSTEM', 1),
    'distance_matrix_request_method'  => env('GOOGLE_DISTANCE_MATRIX_REQUEST_METHOD', 'GET'),
    'distance_matrix_endpoint'        => env('GOOGLE_DISTANCE_MATRIX_ENDPOINT', 'json'),

//    'route_matrix_base_url'           => env('ROUTE_MATRIX_BASE_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json'),
//    'route_matrix_travel_mode'        => env('ROUTE_MATRIX_TRAVEL_MODE', 'DRIVE'),
//    'route_matrix_routing_preference' => env('ROUTE_MATRIX_ROUTING_PREFERENCE', 'TRAFFIC_AWARE_OPTIMAL'),
//    'route_matrix_request_method'     => env('ROUTE_MATRIX_REQUEST_METHOD', 'GET'),
//    'route_matrix_field_mask'         => env('ROUTE_MATRIX_FIELD_MASK', 'originIndex,destinationIndex,duration,distanceMeters,status,condition'),
];
